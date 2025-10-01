<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class RoomType extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $casts = [
        'price' => 'integer',
        'extra_bed_price' => 'integer'
    ];

    protected $fillable = [
        'name',
        'slug',
        'view',
        'description',
        'size',
        'max_adult',
        'max_children',
        'max_total_guests',
        'price',
        'extra_bed_price',
        'status'
    ];

    public function bedTypes(): BelongsToMany
    {
        return $this->belongsToMany(BedType::class, 'room_type_beds')->withPivot('quantity');
    }

    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'room_type_facility');
    }
}
