<?php
namespace App\Services;

use App\Enums\VerificationType;
use App\Mail\SendVerifyCode;
use App\Models\Customer;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    public static function sendVerifyCode(Customer $customer, string $mailClass= SendVerifyCode::class): void
    {
        $customer->verifications()->where('used', false)->update(['used' => true]);
        $customer->verifications()->create([
            'code' => $code = fake()->randomNumber(5, true),
            'type' => VerificationType::Email,
            'expired_at' => now()->addMinutes(5),
        ]);

        Mail::to($customer->email)->send(new $mailClass($customer, $code));
    }

    public static function verifyCode(Customer $customer, string $code): bool
    {
        $verification = $customer->verifications()->where('code', $code)->first();

        $verified = $verification && $verification->expired_at->gte(now()) && !$verification->used;

        if ($verified) {
            $verification->update([
                'used' => true,
            ]);
        }

        return $verified;
    }
}
