<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerVerification extends Model
{

    public $timestamps = false;
    protected $fillable = [
          'customer_id',
          'type',
          'code',
          'used',
          'expired_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'expired_at' => 'datetime',
    ];
}
