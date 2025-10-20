<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Rules\ActiveCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    public function resetPasswordForm(Request $request, string $token)
    {
        if (auth('customer')->check()) {
            return redirect()->route('home');
        }

        return inertia('Auth/ResetPassword', [
            'email' => $request->email,
            'token' => $token
        ]);
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', new ActiveCustomer],
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::broker('customers')->reset(
            $data,
            function (Customer $customer, string $password) {
                $customer->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));

                $customer->save();
            }
        );

        if($status !== Password::PasswordReset) {
            throw ValidationException::withMessages([
                'email' => __($status),
            ]);
        }

        return redirect()->intended(route('login'))->with('message', __($status));
    }

}
