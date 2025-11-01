<?php
namespace App\Enums;

use App\Traits\BaseEnum;

enum PaymentType: string
{
    use BaseEnum;
    case DEPOSIT ='deposit';
    case REFUND = 'refund';
}
