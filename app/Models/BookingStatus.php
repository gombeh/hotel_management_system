<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingStatus extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'status',
        'description'
    ];

    protected $casts = [
        'status' => \App\Enums\BookingStatus::class,
        'created_at' => 'datetime',
    ];
}
