<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingChildren extends Model
{
    protected $table = 'booking_children';

    protected $fillable = [
        'age'
    ];
}
