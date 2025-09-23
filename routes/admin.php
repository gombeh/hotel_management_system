<?php

use App\Http\Controllers\Admin\AuthenticateController;
use App\Http\Controllers\Admin\BedTypeController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin/dashboard');
Route::get('/login', [AuthenticateController::class, 'loginForm'])->name('admin.loginForm');
Route::post('/login', [AuthenticateController::class, 'store'])->name('login');

Route::middleware(['auth'])->group(function() {

   Route::delete('/logout', [AuthenticateController::class, 'delete'])->name('logout');
   Route::get('/dashboard', DashboardController::class)->name('dashboard');

   Route::resource('/users', UserController::class)->except('show', 'edit', 'create');

   Route::resource('/roles', RoleController::class)->except('show', 'edit', 'create');
   Route::getAuth('roles/{role}/permissions', [RolePermissionController::class, 'index'])->name('roles.permissions.index');
   Route::putAuth('roles/{role}/permissions', [RolePermissionController::class, 'update'])->name('roles.permissions.update');

   Route::resource('countries', CountryController::class)->except('show', 'edit', 'create');
   Route::resource('bedTypes', BedTypeController::class)->except('show', 'edit', 'create');

});
