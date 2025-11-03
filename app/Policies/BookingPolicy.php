<?php

namespace App\Policies;

use App\Services\Permission\BasePolicy;
use App\Traits\Permission\CreateAction;
use App\Traits\Permission\ListAction;
use App\Traits\Permission\ViewAction;

class BookingPolicy extends BasePolicy
{
    use ListAction, ViewAction, CreateAction;
}
