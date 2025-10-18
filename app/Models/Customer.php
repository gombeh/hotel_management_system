<?php

namespace App\Models;

use App\Enums\CustomerStatus;
use App\Enums\Sex;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Customer extends Authenticatable implements HasMedia
{
    use HasFactory, InteractsWithMedia;

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
        'is_complete'
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

    public function verifications(): HasMany
    {
        return $this->hasMany(CustomerVerification::class,);
    }

    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->first_name . " " . $this->last_name
        );
    }

    public function ScopeComplete(Builder $builder): Builder
    {
        return $builder->where('is_complete', true);
    }

    public function isVerified(): bool
    {
        return $this->email_verified_at !== null;
    }

    public function isIncomplete(): bool
    {
        return !$this->is_complete && $this->isVerified();
    }

    public function isActive(): bool
    {
        return $this->status === CustomerStatus::Active;
    }

    public function isInActive(): bool
    {
        return $this->status === CustomerStatus::Inactive;
    }
}
