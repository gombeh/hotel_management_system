<?php

namespace App\Traits\Permission;

use App\Models\User;

trait CreateAction
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool {
        return $this->defaultValidation($user, __FUNCTION__);
    }

}
