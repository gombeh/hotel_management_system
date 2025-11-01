<?php
namespace App\Enums;

use App\Traits\BaseEnum;

enum BookingPayment: string
{
    use BaseEnum;

    case PENDING ='pending';
    case PARTIALLY_PAID = 'partially_paid';
    case PAID = 'paid';

    public static function default(): BookingPayment
    {
        return BookingPayment::PENDING;
    }
}
