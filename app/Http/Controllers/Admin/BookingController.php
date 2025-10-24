<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BookingStatus;
use App\Enums\ChargeType;
use App\Enums\SmokingPreference;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Booking\CreateRequest;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\MealPlan;
use App\Models\RoomType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        $roomTypes = RoomType::all()->pluck('name', 'id');
        $customers = Customer::active()->get()->pluck('full_name', 'id');
        $mealPlans = MealPlan::all()->pluck('name', 'id');

        return inertia('Admin/Booking/Create', [
            'customers' => $customers,
            'roomTypes' => $roomTypes,
            'smokingPreferences' => SmokingPreference::asSelect(),
            'mealPlans' => $mealPlans,
        ]);
    }

    public function store(CreateRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {

            $data['status'] = $data['check_in_now'] ? BookingStatus::CHECK_IN : BookingStatus::RESERVED;

            $booking = Booking::create(except_keys($data, ['rooms', 'check_in_now', 'children_ages']));

            $statuses = [BookingStatus::PENDING, BookingStatus::RESERVED];
            $statuses = $data['check_in_now'] ? [...$statuses, BookingStatus::CHECK_IN] : $statuses;

            foreach ($statuses as $status) {
                $booking->statuses()->create([
                    'status' => $status,
                ]);
            }

            $roomTypes = collect([]);
            $rooms = collect($data['rooms'])->flatMap(function ($room) use (&$roomTypes) {
                $roomType = RoomType::find($room['type_id']);
                $rooms = $roomType->rooms()->limit($room['quantity'])->get()->pluck('id');

                $rooms->map(fn($room) => $roomTypes->push($roomType));
                return $rooms;
            });

            $booking->rooms()->sync($rooms);

            $totalPrice = $this->getTotalPrice($booking, $roomTypes, $data);

            $booking->update([
                'total_price' => $totalPrice,
            ]);
        });

        return redirect()->back()->with('success', 'Booking has been created.');
    }


    /**
     * @throws \Exception
     */
    function getTotalPrice(Booking $booking, Collection $roomTypes, array $data): int|float
    {
        $numberOfDays = $booking->check_in->diffInDays($booking->check_out);

        $roomsPrice = $roomTypes->sum('price') * $numberOfDays;
        $booking->charges()->create([
            'charge_type' => ChargeType::ROOM,
            'amount' => $roomsPrice,
        ]);

        $mealPlan = MealPlan::find($data['meal_plan_id']);
        $mealPlanPrice = $mealPlan->adult_price * $booking->adults;


        foreach($data['children_age'] as ['age' => $age]) {
            dump($age >= 0 && $age < 2, $age >= 2 && $age <= 12, $age);
            if($age >= 0 && $age < 2) {
                $mealPlanPrice +=  $mealPlan->infant_price;
            }else if($age >= 2 && $age <= 12) {
                $mealPlanPrice +=  $mealPlan->child_price;
            }else {
                throw new \Exception('you not kids');
            }

            $booking->children()->create([
                'age' => $age,
            ]);
        }

        $mealPlanPrice *= $numberOfDays;

        $booking->charges()->create([
            'charge_type' => ChargeType::MEAL_PLAN,
            'amount' => $mealPlanPrice
        ]);

        $tax = ($roomsPrice + $mealPlanPrice) * config('hotel.tax_rate');
        $booking->charges()->create([
            'charge_type' => ChargeType::TAX,
            'amount' => $tax
        ]);

        return $roomsPrice + $mealPlanPrice + $tax;
    }
}
