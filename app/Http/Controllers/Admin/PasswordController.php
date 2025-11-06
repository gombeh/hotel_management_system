<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Notifications\PasswordChangedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function edit()
    {
        return inertia('Admin/Profile/ChangePassword');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'current_password' => ['required','string', function ($attribute, $value, $fail) use($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail(__('The current password is incorrect.'));
                }
            }],
            'password' => 'required|string|min:8|confirmed|different:current_password'
        ]);

        $user->update(['password' => $data['password']]);

        $user->notify(new PasswordChangedNotification(
            request()->ip(),
            request()->header('User-Agent'),
            route('admin.password.request')
        ));

        return redirect()->back()->with('message', 'Password changed successfully.');
    }
}
