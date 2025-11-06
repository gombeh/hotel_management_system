<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Rules\ActiveCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgetPasswordController extends Controller
{
    public function forgetPasswordForm()
    {
        if (auth('customer')->check()) {
            return redirect()->route('home');
        }

        return inertia('Customer/Auth/ForgetPassword');
    }

    public function forgetPassword(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', new ActiveCustomer],
        ]);

        $status = Password::broker('customers')->sendResetLink($data);

        if($status !== Password::ResetLinkSent) {
            throw ValidationException::withMessages([
                'email' => __($status),
            ]);
        }

        return  back()->with('message', __($status));
    }

}
