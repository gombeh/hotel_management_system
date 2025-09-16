<?php

use App\Http\Controllers\Admin\AuthenticateController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin/dashboard');
Route::get('/login', [AuthenticateController::class, 'loginForm'])->name('admin.loginForm');
Route::post('/login', [AuthenticateController::class, 'store'])->name('login');

Route::middleware(['auth'])->group(function() {
   Route::get('/dashboard', DashboardController::class)->name('dashboard');
   Route::resource('/users', UserController::class)->except('show', 'edit', 'create');
});
