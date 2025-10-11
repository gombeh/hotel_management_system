<?php
namespace App\Enums;

use App\Attributes\Display;
use App\Traits\BaseEnum;

enum Sex: string
{
    use BaseEnum;

    #[Display('Male', 'bg-success-lt', true)]
    case Male = "male";

    #[Display('Female', 'bg-info-lt')]
    case Female = "female";
}
