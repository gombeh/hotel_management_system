<?php

use App\Http\Controllers\Admin\AuthenticateController;
use App\Http\Controllers\Admin\BedTypeController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\CancellationRuleController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\MealPlanController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BookingPaymentController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin/dashboard');
Route::get('/login', [AuthenticateController::class, 'loginForm'])->name('loginForm');
Route::post('/login', [AuthenticateController::class, 'store'])->name('login');

Route::middleware(['auth'])->group(function () {

    Route::delete('/logout', [AuthenticateController::class, 'delete'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::apiResource('/users', UserController::class)->except('show')
        ->middlewareFor('index', 'pagination.validation');

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

    Route::post('booking/rooms-types', [BookingController::class, 'roomTypes'])->name('booking.roomTypes');
    Route::post('booking/prices', [BookingController::class, 'prices'])->name('booking.prices');

    Route::post('media/upload', [MediaController::class, 'upload'])->name('media.upload');
    Route::delete('media/{media}/delete', [MediaController::class, 'delete'])->name('media.delete');
});
