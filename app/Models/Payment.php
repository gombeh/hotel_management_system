<?php

namespace App\Models;

use App\Enums\BookingPayment;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'amount',
        'type',
        'payment_method',
        'status',
        'reference',
        'note',
        'paid_at',
    ];


    protected $casts = [
        'amount' => 'integer',
        'paid_at' => 'datetime',
        'type' => PaymentType::class,
        'payment_method' => PaymentMethod::class,
        'status' => PaymentStatus::class,
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }


    public static function booted(): void
    {
        static::saved(function (Payment $payment) {
            $booking = $payment->booking;
            $paidAmount = $booking->payments()->where('status', PaymentStatus::PAID)->sum('amount');

            $depositAmount = $payment->paid_at
                ? $payment->amount + $booking->deposit_amount
                : $paidAmount;

            $booking->update([
                'deposit_amount' => $depositAmount,
                'payment_status' =>$paidAmount > 0
                    ? ($depositAmount === $booking->total_price ? BookingPayment::PAID  : BookingPayment::PARTIALLY_PAID)
                    : BookingPayment::PENDING,
            ]);
        });
    }
}
