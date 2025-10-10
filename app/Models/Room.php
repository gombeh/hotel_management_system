<?php

namespace App\Models;

use App\Enums\RoomStatus;
use App\Enums\SmokingPreference;
use Database\Factories\RoomFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    protected $casts = [
        'status' => RoomStatus::class,
        'smoking_preference' => SmokingPreference::class,
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }
}
