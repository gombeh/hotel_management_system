<?php

namespace App\Enums;

use App\Attributes\Display;
use App\Traits\BaseEnum;

enum BookingStatus: string
{
    use BaseEnum;

    #[Display('Pending', 'bg-primary-lt')]
    case PENDING = "pending";
    #[Display('Reserved', 'bg-success-lt')]
    case RESERVED = "reserved";
    #[Display('Check In', 'bg-info-lt')]
    case CHECK_IN = "checked_in";

    #[Display('Check Out', 'bg-warning-lt')]
    case CHECK_OUT = "checked_out";

    #[Display('Check Out', 'bg-danger-lt')]
    case CANCELLED = "cancelled";

    #[Display('Expired', 'bg-dark-lt')]
    case EXPIRED = "expired";


    public static function default(): object
    {
        return BookingStatus::PENDING;
    }
}
