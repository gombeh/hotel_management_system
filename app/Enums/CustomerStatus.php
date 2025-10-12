<?php
namespace App\Enums;

use App\Attributes\Display;
use App\Traits\BaseEnum;

enum CustomerStatus: string
{
    use BaseEnum;

    #[Display('Active', 'bg-success-lt', true, true)]
    case Active = "active";

    #[Display('Inactive', 'bg-danger-lt', false, false)]
    case Inactive = "inactive";

    public static function default(): object
    {
        return self::Inactive;
    }
}
