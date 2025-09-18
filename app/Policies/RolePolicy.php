<?php

namespace App\Policies;

use App\Models\User;
use App\Services\Permission\BasePolicy;
use App\Traits\Permission\CreateAction;
use App\Traits\Permission\ListAction;
use Spatie\Permission\Models\Role;

class RolePolicy extends BasePolicy
{
    use ListAction, CreateAction;
    public function update(User $user, Role $role): bool
    {
        return $role->id !== 1 && $this->defaultValidation($user, __FUNCTION__);
    }


    public function delete(User $user, Role $role): bool
    {
        return $role->id !== 1 && $this->defaultValidation($user, __FUNCTION__);
    }
}
