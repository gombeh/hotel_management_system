<?php

namespace App\Models;

use App\Enums\ChargeType;
use Illuminate\Database\Eloquent\Model;

class BookingCharge extends Model
{
    protected $fillable = [
        'charge_type',
        'amount'
    ];

    protected $casts  =[
        'charge_type' => ChargeType::class,
    ];
}
