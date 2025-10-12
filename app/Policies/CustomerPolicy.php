<?php

namespace App\Policies;

use App\Services\Permission\CrudPolicy;
use App\Traits\Permission\ViewAction;

class CustomerPolicy extends CrudPolicy
{
    use ViewAction;
}
