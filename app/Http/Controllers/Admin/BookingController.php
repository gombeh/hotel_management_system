<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BookingStatus;
use App\Enums\RoomStatus;
use App\Enums\SmokingPreference;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Booking\CreateRequest;
use App\Http\Requests\Admin\Booking\PricesRequest;
use App\Http\Requests\Admin\Booking\RoomTypesRequest;
use App\Models\Customer;
use App\Models\MealPlan;
use App\Models\RoomType;
use App\Services\BookingService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {}

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

        $numberOfDays = $data['days'];

        $roomTypes = collect($data['rooms'])->map(function ($room) use ($numberOfDays) {
            $roomType = RoomType::find($room['type_id']);


            $roomType->setAttribute('rooms', (int)$room['quantity']);
            $roomType->setAttribute('totalPrice', $roomType->price * $roomType->rooms * $numberOfDays);

            return $roomType;
        });

        $roomsPrice = $roomTypes->sum(fn ($rt) => $rt->price * $rt->rooms) * $numberOfDays;

        $mealPlan = MealPlan::find($data['meal_plan_id']);
        $mealPlanPrice = $mealPlan->adult_price * $data['adults'];

        $mealPlanAges['adults'] = ['price' => $mealPlan->adult_price, 'count' => $data['adults']];
        foreach ($data['children_age'] as ['age' => $age]) {
            if ($age >= 0 && $age < 2) {
                $mealPlanPrice += $mealPlan->infant_price;
                if(!isset($mealPlanAges['infant'])) {
                    $mealPlanAges= [...$mealPlanAges, 'infant' => ['price' => $mealPlan->infant_price, 'count' => 1,]];
                } else {
                    $mealPlanAges['infant']['count']++;
                }
            } else if ($age >= 2 && $age <= 12) {
                $mealPlanPrice += $mealPlan->child_price;
                if(!isset($mealPlanAges['children'])) {
                    $mealPlanAges = [...$mealPlanAges, 'children' => ['price' => $mealPlan->child_price, 'count' => 1]];
                } else {
                    $mealPlanAges['children']['count']++;
                }
            }
        }

        $mealPlanAges = array_map(function($mealPlanAge, $name) use($numberOfDays) {
            return ['name' => $name, ...$mealPlanAge, 'totalPrice' => $mealPlanAge['price'] * $mealPlanAge['count'] * $numberOfDays];
        }, $mealPlanAges, array_keys($mealPlanAges));

        $mealPlanPrice *= $numberOfDays;


        $tax = ($roomsPrice + $mealPlanPrice) * config('hotel.tax_rate');

        $totalPrice= $roomsPrice + $mealPlanPrice + $tax;

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
