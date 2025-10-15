<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticateController extends Controller
{
    public function loginForm()
    {
        if (auth('customer')->check()) {
            return redirect()->route('home');
        }
        return inertia('Auth/Login');
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function delete()
    {
        auth('customer')->logout();
        return redirect()->route('home');
    }
}
