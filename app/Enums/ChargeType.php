<?php
namespace App\Enums;

use App\Traits\BaseEnum;

enum ChargeType: string
{
    use BaseEnum;

    case ROOM ='room';
    case MEAL_PLAN = 'meal_plan';
    case SERVICE = 'service';
    case CANCELLATION_FEE = 'cancellation_fee';
    case TAX = 'tax';
}
