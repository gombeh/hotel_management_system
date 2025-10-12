<?php

namespace App\Models;

use App\Enums\CustomerStatus;
use App\Enums\Sex;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'national_id',
        'email',
        'mobile',
        'email_verified_at',
        'mobile_verified_at',
        'password',
        'sex',
        'birthdate',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'sex' => Sex::class,
            'status' => CustomerStatus::class,
        ];
    }

    public function national(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'national_id', 'id');
    }

    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->first_name . " " . $this->last_name
        );
    }

}
