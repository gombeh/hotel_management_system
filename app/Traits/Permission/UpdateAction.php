<?php

namespace App\Traits\Permission;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

trait UpdateAction
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Model $model): bool
    {
        return $this->defaultValidation($user, __FUNCTION__);
    }
}
