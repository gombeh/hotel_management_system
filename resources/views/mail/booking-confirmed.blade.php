@component('mail::message')
# Booking Confirmation

Hello **{{ $booking->customer->full_name }}**,
Thank you for your reservation.
Your booking and payment have been successfully completed.

---

## **Booking Details**
**Reservation ID:** `#{{ $booking->ref_number }}`<br>
**Room:** {{ $booking->rooms[0]->type->name }}<br>
**Check-in:** {{ $booking->check_in->format('Y-m-d')}} 14:00<br>
**Check-out:** {{ $booking->check_out->format('Y-m-d')}} 14:00<br>
**Guests:** {{ $booking->guests }}<br>

---

## **Payment Information**
**Status:** Paid <br>
**Amount Paid:** {{ number_format($booking->payments[0]->amount) }} USD<br>
**Payment Date:** {{ $booking->payments[0]->paid_at->format('Y-m-d H:i') }}<br>
**Transaction ID:** {{ $booking->payments[0]->reference ?? 'N/A' }}<br>

---

@component('mail::button', ['url' => route('bookings.success', $booking->id)])
    View Reservation
@endcomponent

If you need to make changes or cancel your reservation, please use the button above or contact support.

Thanks,
**{{ config('app.name') }}**
@endcomponent
