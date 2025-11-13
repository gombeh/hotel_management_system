<?php

namespace App\Http\Controllers\Landing;

use App\Enums\BookingPayment;
use App\Enums\BookingStatus;
use App\Enums\ChargeType;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Http\Resources\RoomTypeResource;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function create(Booking $booking)
    {
        if(!$booking->isPayable() || $booking->customer_id !== auth('customer')->id()){
            abort(403);
        }

        $booking->load('charges')->loadCount('rooms');

        $roomType = $booking->rooms()->first()->type;
        $roomType->load('media', 'bedTypes');

        return inertia('Landing/Checkout', [
            'booking' => BookingResource::make($booking),
            'roomType' => RoomTypeResource::make($roomType),
            'stripeKey' => config('services.stripe.key'),
            'charges' => ChargeType::asSelect(),
        ]);
    }

    /**
     * @throws ApiErrorException
     */
    public function store(Booking $booking)
    {
        if(!$booking->isPayable() || $booking->customer_id !== auth('customer')->id()){
            abort(403);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $intent = PaymentIntent::create([
            'amount' => $booking->total_price * 100,
            'currency' => 'usd',
            'metadata' => [
                'user_id' => auth('customer')->id(),
                'booking_id' => $booking->id,
            ],
            'description' => 'Hotel Booking Payment',
            'automatic_payment_methods' => ['enabled' => true],
        ]);

        $booking->payments()->update(['reference' => $intent->id]);

        return response()->json(['client_secret' => $intent->client_secret]);
    }

    /**
     * @throws ApiErrorException
     */
    public function confirmPayment(Request $request)
    {
        $paymentIntentId = $request->input('payment_intent');

        Stripe::setApiKey(config('services.stripe.secret'));

        $intent = PaymentIntent::retrieve($paymentIntentId);

        if ($intent->status === 'succeeded') {
            DB::Transaction(function () use ($intent) {
                $booking = Booking::find($intent['metadata']['booking_id']);
                $booking->update([
                    'status' => BookingStatus::RESERVED,
                    'payment_status' => BookingPayment::PAID,
                ]);

                $payment = $booking->payments()->first();

                $payment->update([
                    'status' => PaymentStatus::PAID,
                    'paid_at' => now(),
                ]);

                $booking->statuses()->create([
                    'status' => BookingStatus::RESERVED,
                ]);
            });

            return redirect()->intended(route('bookings.success', $intent['metadata']['booking_id']));
        }

        return redirect()->intended(route('payments.failed'));
    }

    public function success(Booking $booking)
    {
        if($booking->isPayable() || $booking->customer_id !== auth('customer')->id()) {
            abort(403);
        }

        $booking->load(['charges'])->loadCount('rooms');
        return inertia('Landing/Success', [
            'booking' => BookingResource::make($booking),
        ]);
    }

    public function failed()
    {
        return inertia('Landing/Failed');
    }
}
