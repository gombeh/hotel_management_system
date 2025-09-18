<?php

namespace App\Traits\Permission;


use App\Models\User;

trait ListAction
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->defaultValidation($user, __FUNCTION__);
    }
}
