<?php

namespace App\Traits\Permission;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;


trait DeleteAction
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Model $model): bool
    {
        return $this->defaultValidation($user, __FUNCTION__);
    }
}
