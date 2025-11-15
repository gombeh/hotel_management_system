<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BookingPayment;
use App\Enums\BookingStatus;
use App\Enums\RoomStatus;
use App\Enums\SmokingPreference;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Booking\CreateRequest;
use App\Http\Requests\Admin\Booking\PricesRequest;
use App\Http\Requests\Admin\Booking\RoomTypesRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\MealPlan;
use App\Models\Payment;
use App\Models\RoomType;
use App\Services\BookingService;
use App\Services\Filters\FilterDate;
use App\Services\Sorts\MultiColumnSort;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;


class BookingController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Booking::class, 'booking');
    }

    public function index(Request $request)
    {
        $limit = $request->limit;
        $user = auth()->user();

        $customers = Customer::all()->pluck('full_name', 'id');

        $bookings = QueryBuilder::for(Booking::class)
            ->with(['rooms.type', 'customer'])
            ->allowedFilters([
                AllowedFilter::exact('customer_id'),
                AllowedFilter::exact('ref_number'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('payment_status'),
                AllowedFilter::exact('room_number', 'rooms.room_number'),
                AllowedFilter::custom('check_in', new FilterDate),
                AllowedFilter::custom('check_out', new FilterDate),
            ])
            ->allowedSorts([
                'ref_number',
                AllowedSort::custom('full_name', new MultiColumnSort(['first_name', 'last_name'], 'customer')),
                'check_in',
                'check_out',
                'status',
                'total_price',
                'deposit_amount'
            ])
            ->latest()
            ->paginate($limit)
            ->withQueryString()
            ->through(fn($booking) => $booking->setAttribute('access', [
                'payments' => $user->can('viewAny', [Payment::class, $booking]),
                'show' => $user->can('show', $booking),
                'checkIn' => $user->can('checkIn', $booking) &&
                    $booking->check_in->lte(now()->startOfDay()) &&
                    $booking->status === BookingStatus::RESERVED,
                'checkOut' => $user->can('checkOut', $booking) &&
                    $booking->check_out->lte(now()->startOfDay()) &&
                    $booking->status === BookingStatus::CHECK_IN &&
                    $booking->payment_status === BookingPayment::PAID
            ]));

        return inertia('Admin/Booking/List', [
            'smokingPreferences' => SmokingPreference::asSelect(),
            'statuses' => BookingStatus::asSelect(),
            'paymentStatuses' => BookingPayment::asSelect(),
            'bookings' => BookingResource::collection($bookings),
            'customers' => $customers,
            'filters' => request()->input('filters') ?? (object)[],
            'sorts' => request()->input('sorts') ?? "",
            'limit' => $limit,
            'access' => [
                'createBookings' => $user->can('create', Booking::class),
            ]
        ]);
    }

    public function show(Booking $booking)
    {
        $booking->load('rooms.type', 'customer', 'mealPlan', 'statuses', 'charges', 'kids');

        return inertia('Admin/Booking/Show', [
            'smokingPreferences' => SmokingPreference::asSelect(),
            'statuses' => BookingStatus::asSelect(),
            'paymentStatuses' => BookingPayment::asSelect(),
            'booking' => BookingResource::make($booking),
        ]);
    }

    public function create()
    {
        $customers = Customer::active()->get()->pluck('full_name', 'id');
        $mealPlans = MealPlan::all()->pluck('name', 'id');

        return inertia('Admin/Booking/Create', [
            'customers' => $customers,
            'smokingPreferences' => SmokingPreference::asSelect(),
            'mealPlans' => $mealPlans,
        ]);
    }

    public function store(CreateRequest $request, BookingService $bookingService)
    {
        $data = $request->validated();
        $data['status'] = $data['check_in_now'] ? BookingStatus::CHECK_IN : BookingStatus::RESERVED;
        $booking = $bookingService->create($data);

        return redirect()->intended(route('admin.bookings.payments.index', $booking))
            ->with('success', 'Booking has been created.');
    }

    public function roomTypes(RoomTypesRequest $request)
    {
        $data = $request->validated();

        $roomTypes = RoomType::whereHas('rooms', function (Builder $query) use ($data) {
            $query->when(
                $data['smoking_preference'] !== SmokingPreference::NO_PREFERENCE->value,
                function (Builder $query) use ($data) {
                    $query->where('smoking_preference', $data['smoking_preference']);
                }
            )->whereNot('status', RoomStatus::Maintenance)
            ->whereDoesntHave(
                'bookings',
                fn(Builder $q) => $q->activeOverlap($data['check_in'], $data['check_out'])
            );
        })->active()
            ->capacity($data['adults'], $data['children'])
            ->get()
            ->pluck('name', 'id');

        return response()->json([
            'roomTypes' => $roomTypes,
        ]);
    }

    public function prices(PricesRequest $request, BookingService $bookingService)
    {
        $data = $request->validated();

        $prices = $bookingService->calculatePrices($data);

        return response()->json($prices);
    }

}
