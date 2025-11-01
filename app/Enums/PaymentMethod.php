<?php
namespace App\Enums;

use App\Traits\BaseEnum;

enum PaymentMethod: string
{
    use BaseEnum;
    case CREDIT_CARD ='credit_card';
    case CASH = 'cash';
    case BANK_TRANSFER = 'bank_transfer';
}
