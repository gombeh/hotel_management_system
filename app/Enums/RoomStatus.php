<?php
namespace App\Enums;

use App\Attributes\Display;
use App\Traits\BaseEnum;

enum RoomStatus: string
{
    use BaseEnum;

    #[Display('Available', 'bg-success-lt', true)]
    case Available = "available";

    #[Display('Occupied', 'bg-info-lt')]
    case Occupied = "occupied";

    #[Display('Maintenance', 'bg-danger-lt')]
    case Maintenance = "maintenance";
}
