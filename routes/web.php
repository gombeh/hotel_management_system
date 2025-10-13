<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Landing\LandingController;

Route::get('/', LandingController::class)->name('home');
