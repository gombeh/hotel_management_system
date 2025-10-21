<?php

namespace App\Enums;

use App\Traits\BaseEnum;

enum BookingStatus: string
{
    use BaseEnum;

    case PENDING = "pending";
    case RESERVED = "reserved";
    case CHECK_IN = "checked_in";
    case CHECK_OUT = "checked_out";
    case CANCELLED = "cancelled";
    case EXPIRED = "expired";


    public static function default(): object
    {
        return BookingStatus::PENDING;
    }
}
