<?php

namespace App\Policies;

use App\Services\Permission\CrudPolicy;
use App\Traits\Permission\ViewAction;

class BookingPolicy extends CrudPolicy
{
    use ViewAction;
}
