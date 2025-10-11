<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MealPlan extends Pivot
{
    protected $table = 'meal_plans';
    protected $fillable = [
        'code',
        'name',
        'description',
        'extra_price',
    ];

    protected $casts = [
        'extra_price' => 'integer',
    ];
}
