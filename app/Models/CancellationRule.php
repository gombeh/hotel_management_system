<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CancellationRule extends Model
{
    protected $fillable = [
        'min_days_before',
        'max_days_before',
        'penalty_percent',
        'description',
    ];

    protected $casts = [
        'min_days_before' => 'integer',
        'max_days_before' => 'integer',
        'penalty_percent' => 'integer',
    ];
}
