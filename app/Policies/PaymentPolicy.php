<?php

namespace App\Policies;

use App\Enums\PaymentStatus;
use App\Models\Booking;
use App\Models\User;
use App\Services\Permission\BasePolicy;
use App\Traits\Permission\UpdateAction;

class PaymentPolicy extends BasePolicy
{
    use UpdateAction;

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
        $paymentPrice = (int)$booking->payments()
            ->whereIn('status', [PaymentStatus::PENDING, PaymentStatus::PAID])
            ->sum('amount');

        if ($paymentPrice === $booking->total_price) {
            return false;
        }
        return $this->defaultValidation($user, __FUNCTION__);
    }

    public function all(User $user): bool
    {
        return $this->defaultValidation($user, __FUNCTION__);
    }

}
