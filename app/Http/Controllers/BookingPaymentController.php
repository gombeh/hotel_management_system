<?php

namespace App\Http\Controllers;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Http\Requests\Admin\Booking\Payment\CreateRequest;
use App\Http\Requests\Admin\Booking\Payment\EditRequest;
use App\Http\Resources\BookingResource;
use App\Http\Resources\PaymentResource;
use App\Models\Booking;
use App\Models\Payment;

class BookingPaymentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource('App\Models\Payment,booking', 'payment,booking');
    }

    public function index(Booking $booking)
    {
        $user = auth()->user();
        $booking->load('customer');
        $payments = $booking->payments()->get();

        $payments->map(fn ($payment) => $payment->setAttribute('access', [
            'edit' => $user->can('update', $payment),
            'delete' => $user->can('delete', $payment),
        ]));

        return inertia('Admin/Booking/Payment/List', [
            'booking' => BookingResource::make($booking),
            'types' => PaymentType::asSelect(),
            'methods' => PaymentMethod::asSelect(),
            'statuses' => PaymentStatus::asSelect(),
            'payments' => PaymentResource::collection($payments),
            'access' => [
                'createPayment' => $user->can('create', [Payment::class, $booking]),
            ]
        ]);
    }

    public function store(CreateRequest $request, Booking $booking)
    {
        $data = $request->validated();

        $data['paid_at'] = $data['status'] === PaymentStatus::PAID->value ? now() : null;
        $data['type'] = PaymentType::DEPOSIT;

        $booking->payments()->create($data);

        return redirect()->back()->with('message', 'Payment created.');
    }


    public function update(EditRequest $request, Payment $payment)
    {
        $data = $request->validated();

        $payment->fill($data);

        if($payment->isDirty('status')) {
            $payment->paid_at = $data['status'] === PaymentStatus::PAID->value
                ? now()
                : null;
        }

        $payment->save();

        return redirect()->back()->with('message', 'Payment updated.');
    }


    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->back()->with('message', 'Payment deleted.');
    }
}
