<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use \App\Enums\BookingStatus as BookingStatusEnum;

class   Booking extends Model
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
        'deposit_amount',
        'payment_status'
    ];

    protected $casts = [
        'status' => BookingStatusEnum::class,
        'check_in' => 'date',
        'check_out' => 'date',
        'total_price' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
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

    public function kids(): HasMany
    {
        return $this->hasMany(BookingChildren::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function mealPlan(): BelongsTo
    {
        return $this->belongsTo(MealPlan::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function scopeActiveOverlap($query, $checkIn, $checkOut)
    {
        return $query->where('check_in', '<', $checkOut)
            ->where('check_out', '>', $checkIn)
            ->where('status', [BookingStatusEnum::RESERVED, BookingStatusEnum::CHECK_IN]);
    }

    public static function booted(): void
    {
        static::creating(function (Booking $booking) {
            $booking->ref_number = fake()->randomNumber(5, true);
        });
    }
}
