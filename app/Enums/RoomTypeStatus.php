<?php
namespace App\Enums;

use App\Attributes\Display;
use App\Traits\BaseEnum;

enum RoomTypeStatus: string
{
    use BaseEnum;

    #[Display('Active', 'bg-success-lt', true, true)]
    case Active = "active";

    #[Display('Inactive', 'bg-danger-lt', false, false)]
    case Inactive = "inactive";
}
