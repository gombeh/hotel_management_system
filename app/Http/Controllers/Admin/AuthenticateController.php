<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;

class AuthenticateController extends Controller
{
    public function loginForm()
    {
        if(auth()->check()){
            return redirect()->route('admin.dashboard');
        }
        return inertia('Admin/Auth/Login');
    }

    public function store(LoginRequest $request){
        $request->authenticate();
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function delete() {
        auth()->logout();
        return redirect()->route('admin.login');
    }
}
