<?php

namespace App\Http\Controllers\Customer;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $customer = Auth::guard('customer')->user();

        // Upcoming Booking
        $upcoming_booking = Booking::with('rooms.type')->where('customer_id', $customer->id)
            ->whereDate('check_in', '>=', now())
            ->whereIn('status', [BookingStatus::RESERVED, BookingStatus::RESERVED])
            ->orderBy('check_in')
            ->first();

        // Recent Bookings
        $recent_bookings = Booking::where('customer_id', $customer->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $upcoming_count = Booking::where('customer_id', $customer->id)
            ->whereDate('check_in', '>=', now())
            ->count();

        $past_count = Booking::where('customer_id', $customer->id)
            ->whereDate('check_out', '<', now())
            ->count();

        $total_paid = Booking::where('customer_id', $customer->id)
            ->sum('total_price');

        $cancellation_count = Booking::where('customer_id', $customer->id)
            ->where('status', BookingStatus::CANCELLED)
            ->count();

        return inertia('Customer/Dashboard', [
            'upcoming_booking' => $upcoming_booking ? BookingResource::make($upcoming_booking) :null,
            'recent_bookings'  => BookingResource::collection($recent_bookings),
            'upcoming_count'   => $upcoming_count,
            'past_count'       => $past_count,
            'total_paid'       => $total_paid,
            'cancellation_count' => $cancellation_count,
            'statuses' => BookingStatus::asSelect()
        ]);
    }
}
