<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Notifications\PasswordChangedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function edit()
    {
        return inertia('Customer/Profile/ChangePassword');
    }

    public function update(Request $request)
    {
        $customer = auth('customer')->user();

        $data = $request->validate([
            'current_password' => ['required','string', function ($attribute, $value, $fail) use($customer) {
                if (!Hash::check($value, $customer->password)) {
                    $fail(__('The current password is incorrect.'));
                }
            }],
            'password' => 'required|string|min:8|confirmed|different:current_password'
        ]);

        $customer->update(['password' => $data['password']]);

        $customer->notify(new PasswordChangedNotification(
            request()->ip(),
            request()->header('User-Agent'),
            route('password.request')
        ));

        return redirect()->back()->with('message', 'Password changed successfully.');
    }
}
