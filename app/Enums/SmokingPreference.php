<?php
namespace App\Enums;

use App\Attributes\Display;
use App\Traits\BaseEnum;

enum SmokingPreference: string
{
    use BaseEnum;

    #[Display('No Preference', 'bg-info-lt', true)]
    case NO_PREFERENCE = "no_preference";

    #[Display('Non Smoking', 'bg-success-lt')]
    case NON_SMOKING = "non_smoking";

    #[Display('Smoking', 'bg-danger-lt')]
    case SMOKING = "smoking";
}
