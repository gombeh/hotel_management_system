<?php

namespace App\Traits\Permission;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

trait ViewAction
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Model $model): bool
    {
        return $this->defaultValidation($user, __FUNCTION__);
    }
}
