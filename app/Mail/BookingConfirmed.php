<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Booking $booking)
    {
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = "Booking Confirmation — Reservation #{$this->booking->ref_number}";

        return $this->subject($subject)
            ->markdown('mail.booking-confirmed');
    }
}
