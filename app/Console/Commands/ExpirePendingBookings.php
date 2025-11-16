<?php

namespace App\Console\Commands;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Models\Booking;
use DB;
use Illuminate\Console\Command;

class ExpirePendingBookings extends Command
{
    protected $signature = 'bookings:expire-pending';

    protected $description = 'Expire pending bookings with passed lock_until time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expired = 0;

        $bookings = Booking::where('status', BookingStatus::PENDING)
            ->whereNotNull('lock_until_at')
            ->where('lock_until_at', '<', now())
            ->get();

        foreach ($bookings as $booking) {

            DB::transaction(function () use ($booking) {

                $booking->update([
                    'status' => BookingStatus::EXPIRED
                ]);

                $booking->payments()
                    ->where('status', PaymentStatus::PENDING)
                    ->update([
                        'status' => PaymentStatus::FAILED
                    ]);

                $booking->statuses()->create([
                    'status' => BookingStatus::EXPIRED
                ]);
            });

            $expired++;
        }

        $this->info("$expired bookings expired.");

        return Command::SUCCESS;
    }
}
