<?php

use App\Http\Controllers\Customer\Auth\AuthenticateController;
use App\Http\Controllers\Customer\Auth\ForgetPasswordController;
use App\Http\Controllers\Customer\Auth\RegisterController;
use App\Http\Controllers\Customer\Auth\ResetPasswordController;
use App\Http\Controllers\Customer\Auth\VerifyCodeController;
use App\Http\Controllers\Landing\BookingController;
use App\Http\Controllers\Landing\LandingController;
use App\Http\Controllers\Landing\RoomTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingController::class)->middleware('verified.customer')->name('home');
Route::get('/rooms', [RoomTypeController::class, 'index'])->name('roomTypes.index');
Route::get('/rooms/{roomType:slug}', [RoomTypeController::class, 'show'])->name('roomTypes.show');


Route::get('/login', [AuthenticateController::class, 'loginForm'])->name('loginForm');
Route::post('/login', [AuthenticateController::class, 'store'])->name('login');

Route::get('/register', [RegisterController::class, 'registerForm'])->name('registerForm');
Route::post('/register', [RegisterController::class, 'store'])->name('register');

Route::get('/forget-password', [ForgetPasswordController::class, 'forgetPasswordForm'])->name('password.request');
Route::post('/forget-password', [ForgetPasswordController::class, 'forgetPassword'])->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'resetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.update');


Route::middleware(['auth:customer', 'verified.customer'])->withoutMiddleware('auth:web')->group(function () {
    Route::delete('/logout', [AuthenticateController::class, 'delete'])->name('logout');

    Route::get('/verify-code', [VerifyCodeController::class, 'verifyCodeForm'])->name('verifyCodeForm');
    Route::post('/verify-code', [VerifyCodeController::class, 'verifyCode'])->name('verifyCode');
    Route::post('/resend-code', [VerifyCodeController::class, 'resendCode'])->name('resendCode');

    Route::get('/complete-register', [RegisterController::class, 'completeRegisterForm'])->name('completeRegisterForm');
    Route::post('/complete-register', [RegisterController::class, 'completeRegister'])->name('completeRegister');

    Route::post('/back-register', [RegisterController::class, 'backRegister'])->name('backRegister');

    Route::get('/bookings/{roomType:slug}/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
});

