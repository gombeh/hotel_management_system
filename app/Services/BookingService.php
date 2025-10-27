<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Enums\ChargeType;
use App\Models\Booking;
use App\Models\MealPlan;
use App\Models\RoomType;
use Illuminate\Support\Collection;

class BookingService
{

    public static function store (array $data): void
    {
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

        $totalPrice = static::getTotalPrice($booking, $roomTypes, $data);

        $booking->update([
            'total_price' => $totalPrice,
        ]);
    }

    public static function getTotalPrice(Booking $booking, Collection $roomTypes, array $data): int|float
    {
        $numberONights = $booking->check_in->diffInDays($booking->check_out);


        $roomsPrice = $roomTypes->sum('price') * $numberONights;
        $booking->charges()->create([
            'charge_type' => ChargeType::ROOM,
            'amount' => $roomsPrice,
        ]);

        $mealPlan = MealPlan::find($data['meal_plan_id']);
        $mealPlanPrice = $mealPlan->adult_price * $booking->adults;


        foreach ($data['children_age'] as ['age' => $age]) {
            if ($age >= 0 && $age < 2) {
                $mealPlanPrice += $mealPlan->infant_price;
            } else if ($age >= 2 && $age <= 12) {
                $mealPlanPrice += $mealPlan->child_price;
            }

            $booking->children()->create([
                'age' => $age,
            ]);
        }

        $mealPlanPrice *= $numberONights;

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
