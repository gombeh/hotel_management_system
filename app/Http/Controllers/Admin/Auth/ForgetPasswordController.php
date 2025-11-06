<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgetPasswordController extends Controller
{
    public function forgetPasswordForm()
    {
        if (auth()->check()) {
            return redirect()->route('admin.login');
        }

        return inertia('Admin/Auth/ForgetPassword');
    }

    public function forgetPassword(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::broker('users')->sendResetLink($data);

        if($status !== Password::ResetLinkSent) {
            throw ValidationException::withMessages([
                'email' => __($status),
            ]);
        }

        return  back()->with('message', __($status));
    }

}
