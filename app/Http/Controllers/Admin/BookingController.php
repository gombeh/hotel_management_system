<?php

namespace App\Http\Controllers\Admin;

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
use App\Models\RoomType;
use App\Services\BookingService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Spatie\QueryBuilder\QueryBuilder;


class BookingController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->limit;
        $user = auth()->user();
        $bookings = QueryBuilder::for(Booking::class)
            ->with('rooms.type', 'customer')
            ->paginate($limit)
            ->through(fn($booking) => $booking->setAttribute('access', [
                'show' => $user->can('show', $booking),
            ]));

        return inertia('Admin/Booking/List', [
            'smokingPreferences' => SmokingPreference::asSelect(),
            'statuses' => BookingStatus::asSelect(),
            'bookings' => BookingResource::collection($bookings),
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
        $booking->load('rooms.type', 'customer', 'mealPlan', 'statuses', 'charges');
        return inertia('Admin/Booking/Show', [
            'smokingPreferences' => SmokingPreference::asSelect(),
            'statuses' => BookingStatus::asSelect(),
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

    public function store(CreateRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            $roomTypes = RoomType::with(['rooms' => function (HasMany $query) use ($data) {
                $query->when($data['smoking_preference'] !== SmokingPreference::NO_PREFERENCE->value, function (Builder $query) use ($data) {
                    $query->where('smoking_preference', $data['smoking_preference']);
                })
                    ->whereNot('status', RoomStatus::Maintenance)
                    ->whereDoesntHave('bookings', function (Builder $query) use ($data) {
                        $query->where(function ($q) use ($data) {
                            $q->where('check_in', '<', $data['check_out'])
                                ->where('check_out', '>', $data['check_in'])
                                ->where('status', BookingStatus::RESERVED);
                        });
                    });
            }])->where('max_adult', '>=', $data['adults'])
                ->where('max_children', '>=', $data['children'])
                ->whereIn('id', collect($data['rooms'])->pluck('type_id'))
                ->get();

            $errors = collect($data['rooms'])->mapWithKeys(function ($room, $i) use ($roomTypes) {
                $roomType = $roomTypes->where('id', $room['type_id'])->first();

                if (!$roomType) {
                    return ["rooms.{$i}.type_id" => 'Your Room type is not available'];
                }

                if ($room['quantity'] > $roomType->rooms->count()) {
                    return ["rooms.{$i}.quantity" => 'Number of rooms not available'];
                }

                return [null];
            })->filter(fn($r) => $r);

            if ($errors->isNotEmpty()) {
                throw ValidationException::withMessages($errors->toArray());
            }

            BookingService::store($data);
        });

        return redirect()->back()->with('success', 'Booking has been created.');
    }

    public function roomTypes(RoomTypesRequest $request)
    {
        $data = $request->validated();

        $roomTypes = RoomType::whereHas('rooms', function (Builder $query) use ($data) {
            $query->when($data['smoking_preference'] !== SmokingPreference::NO_PREFERENCE->value, function (Builder $query) use ($data) {
                $query->where('smoking_preference', $data['smoking_preference']);
            })
                ->whereNot('status', RoomStatus::Maintenance)
                ->whereDoesntHave('bookings', function (Builder $query) use ($data) {
                    $query->where(function ($q) use ($data) {
                        $q->where('check_in', '<', $data['check_out'])
                            ->where('check_out', '>', $data['check_in'])
                            ->where('status', BookingStatus::RESERVED);
                    });
                });
        })->where('max_adult', '>=', $data['adults'])
            ->where('max_children', '>=', $data['children'])
            ->get()
            ->pluck('name', 'id');

        return response()->json([
            'roomTypes' => $roomTypes,
        ]);
    }

    public function prices(PricesRequest $request)
    {
        $data = $request->validated();

        $numberOfNights = $data['nights'];

        $roomTypes = collect($data['rooms'])->map(function ($room) use ($numberOfNights) {
            $roomType = RoomType::find($room['type_id']);


            $roomType->setAttribute('rooms', (int)$room['quantity']);
            $roomType->setAttribute('totalPrice', $roomType->price * $roomType->rooms * $numberOfNights);

            return $roomType;
        });

        $roomsPrice = $roomTypes->sum(fn($rt) => $rt->price * $rt->rooms) * $numberOfNights;

        $mealPlan = MealPlan::find($data['meal_plan_id']);
        $mealPlanPrice = $mealPlan->adult_price * $data['adults'];

        $mealPlanAges['adults'] = ['price' => $mealPlan->adult_price, 'count' => $data['adults']];
        foreach ($data['children_age'] as ['age' => $age]) {
            if ($age >= 0 && $age < 2) {
                $mealPlanPrice += $mealPlan->infant_price;
                if (!isset($mealPlanAges['infant'])) {
                    $mealPlanAges = [...$mealPlanAges, 'infant' => ['price' => $mealPlan->infant_price, 'count' => 1,]];
                } else {
                    $mealPlanAges['infant']['count']++;
                }
            } else if ($age >= 2 && $age <= 12) {
                $mealPlanPrice += $mealPlan->child_price;
                if (!isset($mealPlanAges['children'])) {
                    $mealPlanAges = [...$mealPlanAges, 'children' => ['price' => $mealPlan->child_price, 'count' => 1]];
                } else {
                    $mealPlanAges['children']['count']++;
                }
            }
        }

        $mealPlanAges = array_map(function ($mealPlanAge, $name) use ($numberOfNights) {
            return ['name' => $name, ...$mealPlanAge, 'totalPrice' => $mealPlanAge['price'] * $mealPlanAge['count'] * $numberOfNights];
        }, $mealPlanAges, array_keys($mealPlanAges));

        $mealPlanPrice *= $numberOfNights;


        $tax = ($roomsPrice + $mealPlanPrice) * config('hotel.tax_rate');

        $totalPrice = $roomsPrice + $mealPlanPrice + $tax;

        return response()->json([
            'totalRooms' => $roomsPrice,
            'roomTypes' => $roomTypes->select('name', 'rooms', 'price', 'totalPrice'),
            'mealPlan' => $mealPlanPrice,
            'mealPlanAges' => array_values($mealPlanAges),
            'tax' => $tax,
            'total' => $totalPrice,
        ]);
    }
}
