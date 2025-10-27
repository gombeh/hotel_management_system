<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $fillable = [
        'ref_number',
        'customer_id',
        'adults',
        'status',
        'children',
        'check_in',
        'check_out',
        'smoking_preference',
        'meal_plan_id',
        'special_requests',
        'total_price',
        'partial_amount'
    ];

    protected $casts = [
        'status' => \App\Enums\BookingStatus::class,
        'check_in' => 'date',
        'check_out' => 'date',
        'total_price' => 'integer',
        'partial_amount' => 'integer'
    ];

    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class, 'booking_rooms');
    }

    public function statuses(): HasMany
    {
        return $this->hasMany(BookingStatus::class);
    }

    public function charges(): HasMany
    {
        return $this->hasMany(BookingCharge::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(BookingChildren::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public static function booted(): void
    {
        static::creating(function (Booking $booking) {
            $booking->ref_number = fake()->randomNumber(5, true);
        });
    }
}
