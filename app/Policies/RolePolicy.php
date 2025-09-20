<?php

namespace App\Policies;

use App\Models\User;
use App\Services\Permission\CrudPolicy;
use Spatie\Permission\Models\Role;

class RolePolicy extends CrudPolicy
{
    public function permissions(User $user, Role $role): bool
    {
        return $this->defaultValidation($user, __FUNCTION__);
    }
}
