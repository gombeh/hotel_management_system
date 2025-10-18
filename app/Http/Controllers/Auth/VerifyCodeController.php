<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VerifyCodeController extends Controller
{
    public function verifyCodeForm()
    {
        return inertia('Auth/VerifyCode');
    }

    public function verifyCode(Request $request)
    {
        ['code' => $code] = $request->validate([
            'code' => 'required|integer',
        ]);

        $customer = auth('customer')->user();

        if (!OtpService::verifyCode($customer, $code)) {
            throw ValidationException::withMessages([
                'code' => 'Code is not valid.',
            ]);
        }

        $customer->update([
            'email_verified_at' => now(),
        ]);

        return redirect()->intended(route('completeRegisterForm'));
    }

    public function resendCode()
    {
        $customer = auth('customer')->user();

        OtpService::sendVerifyCode($customer);

        return redirect()->back();
    }
}
