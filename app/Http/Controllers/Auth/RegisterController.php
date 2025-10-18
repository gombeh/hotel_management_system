<?php

namespace App\Http\Controllers\Auth;

use App\Enums\CustomerStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CompleteRegisterRequest;
use App\Models\Customer;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function registerForm()
    {
        if (auth('customer')->check()) {
            return redirect()->route('home');
        }
        return inertia('Auth/Register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => [
                'required', 'email', 'max:255', Rule::unique('customers', 'email')
                    ->where(fn($query) => $query->where('is_complete', 1))
            ]
        ]);

        $customer = Customer::createOrFirst($data);

        auth('customer')->login($customer);

        if(!$customer->isVerified()) OtpService::sendVerifyCode($customer);

        return redirect()->intended(route('verifyCodeForm'));
    }

    public function completeRegisterForm()
    {
        return inertia('Auth/CompleteRegister');
    }

    public function completeRegister(CompleteRegisterRequest $request)
    {
        $customer = auth('customer')->user();

        $data = $request->validated();
        $data = [
            ...$data,
            'is_complete' => true,
            'status' => CustomerStatus::Active,
        ];

        $customer->update($data);

        return redirect()->intended(route('home'));
    }

    public function backRegister()
    {
        $customer = auth('customer')->user();
        auth('customer')->logout();
        return redirect()->route('register')->with('old', ['email' => $customer->email]);
    }
}
