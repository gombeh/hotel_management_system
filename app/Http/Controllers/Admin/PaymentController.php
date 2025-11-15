<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Models\Customer;
use App\Models\Payment;
use App\Services\Filters\FilterDate;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource('App\Models\Payment,booking', 'payment,booking');
    }

    public function index(Request $request)
    {
        $limit = $request->limit;
        $user = auth()->user();
        $customers = Customer::all()->pluck('full_name', 'id');

        $payments = QueryBuilder::for(Payment::class)
            ->with(['booking.customer'])
            ->allowedFilters([
                AllowedFilter::exact('type'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('payment_method'),
                AllowedFilter::exact('customer_id', 'booking.customer_id'),
                AllowedFilter::custom('paid_at', new FilterDate),
            ])
            ->allowedSorts([
                'amount',
                'type',
                'status',
                'payment_method',
                'paid_at',
                'created_at'
            ])
            ->latest()
            ->paginate($limit)
            ->withQueryString()
            ->through(fn($payment) => $payment->setAttribute('access', [
                'edit' => $user->can('update', $payment),
            ]));

        return inertia('Admin/Payment/List', [
            'types' => PaymentType::asSelect(),
            'methods' => PaymentMethod::asSelect(),
            'statuses' => PaymentStatus::asSelect(),
            'payments' => PaymentResource::collection($payments),
            'customers' => $customers,
            'filters' => request()->input('filters') ?? (object)[],
            'sorts' => request()->input('sorts') ?? "",
            'limit' => $limit,
        ]);
    }
}
