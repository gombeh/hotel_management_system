<?php

namespace App\Http\Controllers\Customer;

use App\Enums\BookingStatus;
use App\Enums\SmokingPreference;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Spatie\QueryBuilder\QueryBuilder;


class BookingController extends Controller
{
    public function index()
    {
        $customer = auth('customer')->user();
        $bookings = QueryBuilder::for(Booking::class)
            ->with(['rooms.type'])
            ->where('customer_id', $customer->id)
            ->latest()
            ->get()
            ->map(fn(Booking $booking) => $booking->setAttribute('access', [
                'show' => $booking->isPaid(),
                'retry' => $booking->isPayable(),
            ]));

        return inertia('Customer/Bookings', [
            'smokingPreferences' => SmokingPreference::asSelect(),
            'statuses' => BookingStatus::asSelect(),
            'bookings' => BookingResource::collection($bookings),
        ]);
    }
}
