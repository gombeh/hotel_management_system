<?php

use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Landing\LandingController;

Route::get('/', LandingController::class)->middleware('verified.customer')->name('home');


Route::get('/login', [AuthenticateController::class, 'loginForm'])->name('loginForm');
Route::post('/login', [AuthenticateController::class, 'store'])->name('login');

Route::get('/register', [RegisterController::class, 'registerForm'])->name('registerForm');
Route::post('/register', [RegisterController::class, 'store'])->name('register');


Route::middleware(['auth:customer', 'verified.customer'])->group(function () {
    Route::delete('/logout', [AuthenticateController::class, 'delete'])->name('logout');

    Route::get('/verify-code', [RegisterController::class, 'verifyCodeForm'])->name('verifyCodeForm');
    Route::post('/verify-code', [RegisterController::class, 'verifyCode'])->name('verifyCode');
    Route::post('/resend-code', [RegisterController::class, 'resendCode'])->name('resendCode');

    Route::get('/complete-register', [RegisterController::class, 'completeRegisterForm'])->name('completeRegisterForm');
    Route::post('/complete-register', [RegisterController::class, 'completeRegister'])->name('completeRegister');

    Route::post('/back-register', [RegisterController::class, 'backRegister'])->name('backRegister');
});

