<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use App\Services\Permission\BasePolicy;
use App\Traits\Permission\CreateAction;
use App\Traits\Permission\ListAction;
use App\Traits\Permission\ViewAction;

class BookingPolicy extends BasePolicy
{
    use ListAction, ViewAction, CreateAction;

    public function checkIn(User $user, Booking $booking): bool
    {
        return $this->defaultValidation($user, __FUNCTION__);
    }

    public function checkOut(User $user, Booking $booking): bool
    {
        return $this->defaultValidation($user, __FUNCTION__);
    }
}
