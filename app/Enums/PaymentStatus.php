<?php
namespace App\Enums;

use App\Traits\BaseEnum;

enum PaymentStatus: string
{
    use BaseEnum;

    case PENDING ='pending';
    case PAID = 'paid';
    case FAILED = 'failed';

    public static function default(): PaymentStatus
    {
        return PaymentStatus::PENDING;
    }
}
