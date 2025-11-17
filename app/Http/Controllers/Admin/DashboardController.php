<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Enums\RoomStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;

class DashboardController extends Controller
{
    public function __invoke()
    {

        // Today Check-ins
        $today_checkins = Booking::whereDate('check_in', now())
            ->reserved()
            ->count();

        // Today Check-outs
        $today_checkouts = Booking::whereDate('check_out', now())
            ->checkedIn()
            ->count();

        // Pending Payments
        $pending_payments = Booking::where('payment_status', PaymentStatus::PENDING)->count();

        // Active Guests
        $active_guests = Booking::checkedIn()->count();

        // Room Status Overview
        $room_status = [
            'available' => Room::where('status', RoomStatus::Available)->count(),
            'occupied'  => Room::where('status', RoomStatus::Occupied)->count(),
            'out_of_service'  => Room::where('status', RoomStatus::Maintenance)->count(),
        ];

        // Revenue Summary (today / week / month)
        $revenue = [
            'today' => Payment::whereDate('paid_at', now())
                ->paid()
                ->sum('amount'),

            'week' => Payment::whereBetween('paid_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->paid()
                ->sum('amount'),

            'month' => Payment::whereMonth('paid_at', now()->month)
                ->paid()
                ->sum('amount'),
        ];

        // Latest bookings
        $latest_bookings = Booking::with('customer')
            ->latest()
            ->take(10)
            ->get();

        return inertia('Admin/Dashboard', [
            'today_checkins'   => $today_checkins,
            'today_checkouts'  => $today_checkouts,
            'pending_payments' => $pending_payments,
            'active_guests'    => $active_guests,
            'room_status'      => $room_status,
            'revenue'          => $revenue,
            'latest_bookings'  => BookingResource::collection($latest_bookings),
            'statuses' => BookingStatus::asSelect(),
        ]);
    }
}
