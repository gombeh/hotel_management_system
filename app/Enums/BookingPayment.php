<?php
namespace App\Enums;

use App\Attributes\Display;
use App\Traits\BaseEnum;

enum BookingPayment: string
{
    use BaseEnum;

    #[Display('Pending', 'bg-danger-lt')]
    case PENDING ='pending';

    #[Display('Partially Paid', 'bg-warning-lt')]
    case PARTIALLY_PAID = 'partially_paid';

    #[Display('Paid', 'bg-success-lt')]
    case PAID = 'paid';

    public static function default(): BookingPayment
    {
        return BookingPayment::PENDING;
    }
}
