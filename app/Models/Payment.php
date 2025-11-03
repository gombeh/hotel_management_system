<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use Illuminate\Database\Eloquent\Model;

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
}
