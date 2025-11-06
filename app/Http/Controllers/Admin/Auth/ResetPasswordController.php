<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    public function resetPasswordForm(Request $request, string $token)
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }

        return inertia('Admin/Auth/ResetPassword', [
            'email' => $request->email,
            'token' => $token
        ]);
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::broker('users')->reset(
            $data,
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        if($status !== Password::PasswordReset) {
            throw ValidationException::withMessages([
                'email' => __($status),
            ]);
        }

        return redirect()->intended(route('admin.login'))->with('message', __($status));
    }

}
