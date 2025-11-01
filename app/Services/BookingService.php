<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Enums\ChargeType;
use App\Enums\RoomStatus;
use App\Enums\SmokingPreference;
use App\Models\Booking;
use App\Models\MealPlan;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BookingService
{

    public function create(array $data): ?Booking
    {
        $booking = null;
        DB::transaction(function () use ($data, &$booking) {
            [$roomTypes, $errors] = $this->checkAvailability($data);

            if ($errors->isNotEmpty()) {
                throw ValidationException::withMessages($errors->toArray());
            }

            $data['status'] = $data['check_in_now'] ? BookingStatus::CHECK_IN : BookingStatus::RESERVED;

            $booking = Booking::create(except_keys($data, ['rooms', 'check_in_now', 'children_ages']));

            $this->attachStatuses($booking, $data['check_in_now']);

            $this->attachRooms($booking, $data['rooms'], $roomTypes);

            $totalPrice = $this->processBookingCharges($booking, $roomTypes, $data);

            $booking->update([
                'total_price' => $totalPrice,
            ]);
        });

        return $booking;
    }

    public function calculatePrices(array $data): array
    {
        $numberOfNights = $data['nights'];

        [$roomTypes, $roomsPrice] = $this->calculateRoomsPrice($data['rooms'], $numberOfNights);

        $mealPlan = MealPlan::find($data['meal_plan_id']);
        $mealPlanPrice = $mealPlan->adult_price * $data['adults'];

        $mealPlanAges = collect([
            'adults' => [
                'price' => $mealPlan->adult_price,
                'count' => $data['adults'],
            ],
        ]);

        foreach ($data['children_age'] as ['age' => $age]) {
            if ($age >= 0 && $age < 2) {
                $key = 'infant';
                $price = $mealPlan->infant_price;
            } elseif ($age >= 2 && $age <= 12) {
                $key = 'children';
                $price = $mealPlan->child_price;
            } else {
                continue;
            }

            $mealPlanPrice += $price;
            $mealPlanAges->put($key, [
                'price' => $price,
                'count' => $mealPlanAges->get($key)['count'] ?? 1,
            ]);
        }

        $mealPlanAges = $mealPlanAges->map(fn($item, $name) => [
            'name' => $name,
            'price' => $item['price'],
            'count' => $item['count'],
            'totalPrice' => $item['price'] * $item['count'] * $numberOfNights,
        ]);
        $mealPlanPrice *= $numberOfNights;

        $tax = ($roomsPrice + $mealPlanPrice) * config('hotel.tax_rate');
        $tax = round($tax, 2);

        $totalPrice = round($roomsPrice + $mealPlanPrice + $tax ,2);

        return [
            'totalRooms' => $roomsPrice,
            'roomTypes' => $roomTypes->select('name', 'rooms', 'price', 'totalPrice'),
            'mealPlan' => $mealPlanPrice,
            'mealPlanAges' => $mealPlanAges,
            'tax' => $tax,
            'total' => $totalPrice,
        ];
    }

    private function attachRooms(Booking $booking, array $rooms, $roomTypes): void
    {
        $rooms = collect($rooms)->flatMap(function ($room) use ($roomTypes) {
            $roomType = $roomTypes->where('id', $room['type_id'])->first();
            return $roomType->rooms()->limit($room['quantity'])->get()->pluck('id');
        });

        $booking->rooms()->sync($rooms);
    }

    private function processBookingCharges(Booking $booking, Collection $roomTypes, array $data): int|float
    {
        $numberOfNights = $booking->check_in->diffInDays($booking->check_out);

        $roomsPrice = $this->calculateRoomsPrice($data['rooms'], $numberOfNights, $roomTypes);

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

            $booking->kids()->create([
                'age' => $age,
            ]);
        }

        $mealPlanPrice *= $numberOfNights;

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

    private function checkAvailability(array $data): array
    {
        $roomTypes = RoomType::with(['rooms' => function (HasMany $query) use ($data) {
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
        }])->active()
            ->capacity($data['adults'], $data['children'])
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

        return array($roomTypes, $errors);
    }

    private function calculateRoomsPrice($rooms, float $numberOfNights, ?Collection $initialRoomType = null): array|float
    {
        $roomTypes = collect($rooms)->map(function ($room) use ($initialRoomType, $numberOfNights) {
            $roomType = $initialRoomType
                ? $initialRoomType->where('id', $room['type_id'])->first()
                : RoomType::find($room['type_id']);

            $roomType->setAttribute('rooms', (int)$room['quantity']);
            $roomType->setAttribute('totalPrice', $roomType->price * $roomType->rooms * $numberOfNights);

            return $roomType;
        });

        $prices = $roomTypes->sum(fn($rt) => $rt->price * $rt->rooms) * $numberOfNights;

        return $initialRoomType
            ? $prices
            : [$roomTypes, $prices];
    }

    private function attachStatuses(Booking $booking, bool $checkInNow): void
    {
        $statuses = [BookingStatus::PENDING, BookingStatus::RESERVED];
        $statuses = $checkInNow ? [...$statuses, BookingStatus::CHECK_IN] : $statuses;

        foreach ($statuses as $status) {
            $booking->statuses()->create([
                'status' => $status,
            ]);
        }
    }
}
