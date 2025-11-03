<?php
namespace App\Enums;

use App\Attributes\Display;
use App\Traits\BaseEnum;

enum PaymentType: string
{
    use BaseEnum;
    #[Display('Deposit', 'bg-success-lt')]
    case DEPOSIT ='deposit';

    #[Display('Refund', 'bg-danger-lt')]
    case REFUND = 'refund';
}
