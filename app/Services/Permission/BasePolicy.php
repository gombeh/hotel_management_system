<?php

namespace App\Services\Permission;

use App\Models\User;

abstract class BasePolicy
{
    /**
     * @param User $user
     * @param string $actionName
     * @return bool
     */
    public function defaultValidation(User $user, string $actionName): bool
    {
        $permissionName = PermissionService::createNameWherePolicyAndAction($this, $actionName);

        return $user->can($permissionName);
    }

}
