<?php

namespace App\Http\Controllers\Landing;

use App\Enums\BookingStatus;
use App\Enums\SmokingPreference;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Booking\PricesRequest;
use App\Http\Requests\Landing\BookingRequest;
use App\Http\Resources\RoomTypeResource;
use App\Models\MealPlan;
use App\Models\RoomType;
use App\Services\BookingService;


class BookingController extends Controller
{
    public function create(RoomType $roomType)
    {
        $roomType->load('media', 'bedTypes');

        $mealPlans = MealPlan::all()->pluck('name', 'id');
        return inertia('Landing/Booking', [
            'roomType' => RoomTypeResource::make($roomType),
            'smokingPreferences' => SmokingPreference::asSelect(),
            'mealPlans' => $mealPlans,
            'filters' => (object) request()->input('filters', []),
        ]);
    }

    public function store(BookingRequest $request, BookingService $bookingService)
    {
        $data = $request->validated();

        $data = [
            ...$data,
            'rooms' => [
                [
                    'type_id' => $data['room_type_id'],
                    'quantity' => $data['rooms']
                ]
            ],
            'check_in_now' => false,
            'customer_id' => auth('customer')->id(),
            'lock_until_at' => now()->addMinutes(30),
            'status' => BookingStatus::PENDING,
        ];

        $booking = $bookingService->create($data);

        return redirect()->intended(route('home'))
            ->with('success', 'Booking has been created.');
    }

    public function prices(PricesRequest $request, BookingService $bookingService)
    {
        $data = $request->validated();

        $prices = $bookingService->calculatePrices($data);

        return response()->json($prices);
    }
}
