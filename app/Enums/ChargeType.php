<?php
namespace App\Enums;

use App\Attributes\Display;
use App\Traits\BaseEnum;

enum ChargeType: string
{
    use BaseEnum;

    #[Display('Room', 'bi-house')]
    case ROOM ='room';

    #[Display('Meal Plan', 'bi-egg-fried')]
    case MEAL_PLAN = 'meal_plan';

    #[Display('Service',)]
    case SERVICE = 'service';

    #[Display('Cancellation Fee')]
    case CANCELLATION_FEE = 'cancellation_fee';

    #[Display('Tax', 'bi-bank')]
    case TAX = 'tax';
}
