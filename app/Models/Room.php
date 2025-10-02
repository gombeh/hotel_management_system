<?php

namespace App\Models;

use Database\Factories\RoomFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    /** @use HasFactory<RoomFactory> */
    use HasFactory;

    protected $fillable = [
        'room_number',
        'room_type_id',
        'floor_number',
        'status',
        'smoking_preference'
    ];
}
