<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingChildren extends Model
{
    use HasFactory;
    protected $table = 'booking_children';

    protected $fillable = [
        'age'
    ];
}
