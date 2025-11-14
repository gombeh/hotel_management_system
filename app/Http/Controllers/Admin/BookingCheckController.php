<?php

namespace App\Http\Controllers\Admin;

use App\Attributes\Authorize;
use App\Enums\BookingPayment;
use App\Enums\BookingStatus;
use App\Enums\RoomStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class BookingCheckController extends Controller
{
    #[Authorize("checkIn", 'booking')]
    public function checkIn(Booking $booking)
    {
        if($booking->check_in->gt(now()->startOfDay())) {
            return redirect()->back()->with([
                'message' => 'Check-in can only be done on the booking date.',
                'type' => 'error'
            ]);
        }

        if($booking->status !== BookingStatus::RESERVED) {
            return redirect()->back()->with([
                'message' => 'Only reserved bookings can be checked in.',
                'type' => 'error'
            ]);
        }

        DB::Transaction(function () use ($booking) {
            $booking->update([
                'status' => BookingStatus::CHECK_IN,
            ]);

            $booking->statuses()->create([
                'status' => BookingStatus::CHECK_IN,
            ]);

            $booking->rooms()->update([
                'status' => RoomStatus::Occupied,
            ]);
        });


        return redirect()->back()->with(['message' => 'Booking has been successfully checked in.']);
    }

    #[Authorize("checkOut", 'booking')]
    public function checkOut(Booking $booking)
    {
        if($booking->check_out->gt(now()->startOfDay())) {
            return redirect()->back()->with([
                'message' => 'Check-out can only be done on the booking checkout date.',
                'type' => 'error'
            ]);
        }

        if($booking->status !== BookingStatus::CHECK_IN) {
            return redirect()->back()->with([
                'message' => 'Only bookings that have been checked in can be checked out.',
                'type' => 'error'
            ]);
        }

        if($booking->payment_status !== BookingPayment::PAID) {
            return redirect()->back()->with([
                'message' => 'The customer has not completed full payment.',
                'type' => 'error'
            ]);
        }

        DB::Transaction(function () use ($booking) {
            $booking->update([
                'status' => BookingStatus::CHECK_OUT,
            ]);

            $booking->statuses()->create([
                'status' => BookingStatus::CHECK_OUT,
            ]);

            $booking->rooms()->update([
                'status' => RoomStatus::Available,
            ]);
        });

        return redirect()->back()->with(['message' => 'Booking has been successfully checked out.']);
    }
}
