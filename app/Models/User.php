<?php

namespace App\Models;

use App\Enums\Sex;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles, InteractsWithMedia;


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'sex',
        'email',
        'password',
        'is_super_admin',
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

    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->first_name . " " . $this->last_name
        );
    }

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
        ];
    }

    protected static function booted(): void
    {
        static::deleting(function ($user) {
            if ($user->id === 1) {
                abort(403, 'The root user cannot be deleted.');
            }
        });
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avtar')
            ->useFallbackUrl(url('/assets/images/default-room.webp'))
            ->useFallbackPath(public_path('assets/images/default-room.webp'));
    }
}
