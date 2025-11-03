<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use App\Services\Permission\BasePolicy;
use App\Traits\Permission\DeleteAction;
use App\Traits\Permission\UpdateAction;

class PaymentPolicy extends BasePolicy
{
    use UpdateAction, DeleteAction;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Booking $booking): bool
    {
        return $this->defaultValidation($user, __FUNCTION__);
    }


    /**
     * Determine whether the user can view any models.
     */
    public function create(User $user, Booking $booking): bool
    {
        return $this->defaultValidation($user, __FUNCTION__);
    }


}
