<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealPlan extends Model
{
    protected $table = 'meal_plans';
    protected $fillable = [
        'code',
        'name',
        'description',
        'adult_price',
        'child_price',
        'infant_price',
    ];

    protected $casts = [
        'adult_price' => 'integer',
        'child_price' => 'integer',
        'infant_price' => 'integer',
    ];
}
