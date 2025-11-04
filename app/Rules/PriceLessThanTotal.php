<?php

namespace App\Rules;

use App\Enums\PaymentStatus;
use App\Models\Booking;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Translation\PotentiallyTranslatedString;

class PriceLessThanTotal implements ValidationRule
{

    public function __construct(private Booking $booking, private ?int $paymentId = null)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string, ?string=): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $paymentPrice = $this->booking->payments()->whereIn('status', [PaymentStatus::PENDING, PaymentStatus::PAID])
            ->when($this->paymentId, fn(Builder $query) => $query->whereNot('id', $this->paymentId))
            ->sum('amount');

        $paymentPrice += $value;
        if ($paymentPrice > $this->booking->total_price) {
            $fail($attribute . ' ' . $attribute . ' is less than or equal to total price.');
        }
    }
}
