<?php

namespace App\Services\Permission;

use App\Traits\Permission\CreateAction;
use App\Traits\Permission\DeleteAction;
use App\Traits\Permission\ListAction;
use App\Traits\Permission\UpdateAction;

abstract class CrudPolicy extends BasePolicy
{
    use ListAction, CreateAction, UpdateAction, DeleteAction;
}
