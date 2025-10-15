<?php

namespace App\Http\Controllers\Auth;

use App\Enums\CustomerStatus;
use App\Enums\VerificationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CompleteRegisterRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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
                    ->where(fn ($query)  => $query->whereNotNull('email_verified_at'))
            ]
        ]);

        $customer = Customer::createOrFirst($data);

        auth('customer')->login($customer);

        $customer->verifications()->create([
            'code' => $code = fake()->randomNumber(5, true),
            'type' => VerificationType::Email,
            'expired_at' => now()->addMinutes(5),
        ]);

        info('code: ' . $code);

        return redirect()->intended(route('verifyCodeForm'));
    }

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

        $verification = $customer->verifications()->where('code', $code)->first();

        if (!$verification && $verification->expired_at <= now()) {
            throw ValidationException::withMessages([
                'code' => 'Code is not valid.',
            ]);
        }
        return redirect()->intended(route('completeRegisterForm'));
    }

    public function resendCode()
    {
        $customer = auth('customer')->user();

        $customer->verifications()->create([
            'code' => $code = fake()->randomNumber(5, true),
            'type' => VerificationType::Email,
            'expired_at' => now()->addMinutes(5),
        ]);

        info('code: ' . $code);

        return redirect()->back();
    }

    public function completeRegisterForm()
    {
        return inertia('Auth/CompleteRegister');
    }

    public function completeRegister(CompleteRegisterRequest $request)
    {
        $data = $request->validated();
        $data['email_verified_at'] = now();
        $data['status'] = CustomerStatus::Active;

        $customer = auth('customer')->user();

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
