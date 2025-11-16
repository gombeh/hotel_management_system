<?php

use App\Http\Controllers\Admin\Auth\AuthenticateController;
use App\Http\Controllers\Admin\Auth\ForgetPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\BedTypeController;
use App\Http\Controllers\Admin\BookingCancelController;
use App\Http\Controllers\Admin\BookingCheckController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\BookingPaymentController;
use App\Http\Controllers\Admin\CancellationRuleController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\MealPlanController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PasswordController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin/dashboard');
Route::get('/login', [AuthenticateController::class, 'loginForm'])->name('loginForm');
Route::post('/login', [AuthenticateController::class, 'store'])->name('login');

Route::get('/forget-password', [ForgetPasswordController::class, 'forgetPasswordForm'])->name('password.request');
Route::post('/forget-password', [ForgetPasswordController::class, 'forgetPassword'])->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'resetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.update');

Route::middleware(['auth'])->group(function () {

    Route::delete('/logout', [AuthenticateController::class, 'delete'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::apiResource('/users', UserController::class)->except('show')
        ->middlewareFor('index', 'pagination.validation');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::post('/password', [PasswordController::class, 'update'])->name('password.save');

    Route::apiResource('/roles', RoleController::class)->except('show');
    Route::getAuth('roles/{role}/permissions', [RolePermissionController::class, 'index'])->name('roles.permissions.index');
    Route::putAuth('roles/{role}/permissions', [RolePermissionController::class, 'update'])->name('roles.permissions.update');

    Route::apiResource('countries', CountryController::class)->except('show')
        ->middlewareFor('index', 'pagination.validation');
    Route::camelApiResource('bed-types', BedTypeController::class)->except('show');

    Route::apiResource('facilities', FacilityController::class)->except('show');

    Route::camelResource('room-types', RoomTypeController::class)
        ->except('show')
        ->middlewareFor('index', 'pagination.validation');

    Route::apiResource('rooms', RoomController::class)
        ->except('show')
        ->middlewareFor('index', 'pagination.validation');

    Route::camelApiResource('meal-plans', MealPlanController::class)->except('show');
    Route::camelApiResource('cancellation-rules', CancellationRuleController::class)->except('show');

    Route::apiResource('customers', CustomerController::class)
        ->middlewareFor('index', 'pagination.validation');

    Route::resource('bookings', BookingController::class)
        ->middlewareFor('index', 'pagination.validation')
        ->except(['edit', 'update', 'destroy']);

    Route::apiResource('bookings.payments', BookingPaymentController::class)
        ->except(['show', 'destroy'])
        ->shallow();

    Route::post('bookings/rooms-types', [BookingController::class, 'roomTypes'])->name('bookings.roomTypes');
    Route::post('bookings/prices', [BookingController::class, 'prices'])->name('bookings.prices');

    Route::post('/bookings/{booking}/check-in', [BookingCheckController::class, 'checkIn'])
        ->name('bookings.checkin');

    Route::post('/bookings/{booking}/check-out', [BookingCheckController::class, 'checkOut'])
        ->name('bookings.checkout');

    Route::get('/bookings/{booking}/cancellation-fee', [BookingCancelController::class, 'cancellationFee'])
    ->name('bookings.cancellationFee');
    Route::post('/bookings/{booking}/cancel', [BookingCancelController::class, 'cancel'])
        ->name('bookings.cancel');


    Route::get('payments', [PaymentController::class, 'index'])->name('payments.index')
        ->middleware( 'pagination.validation');

    Route::post('media/upload', [MediaController::class, 'upload'])->name('media.upload');
    Route::delete('media/{media}/delete', [MediaController::class, 'delete'])->name('media.delete');
});
