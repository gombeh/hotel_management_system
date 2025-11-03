<?php
namespace App\Enums;

use App\Attributes\Display;
use App\Traits\BaseEnum;

enum PaymentStatus: string
{
    use BaseEnum;

    #[Display('Pending', 'bg-warning-lt')]
    case PENDING ='pending';

    #[Display('Paid', 'bg-success-lt')]
    case PAID = 'paid';

    #[Display('Failed', 'bg-danger-lt')]
    case FAILED = 'failed';

    public static function default(): PaymentStatus
    {
        return PaymentStatus::PENDING;
    }
}
