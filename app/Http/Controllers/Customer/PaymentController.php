<?php

namespace App\Http\Controllers\Customer;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $customer  = auth('customer')->user();

        $payments = Payment::with('booking')->whereHas(
            'booking.customer',
            fn ($query) => $query->whereKey($customer->id)
        )->latest()->get();

        return inertia('Customer/Payments', [
            'types' => PaymentType::asSelect(),
            'methods' => PaymentMethod::asSelect(),
            'statuses' => PaymentStatus::asSelect(),
            'payments' => PaymentResource::collection($payments),
        ]);
    }

}
