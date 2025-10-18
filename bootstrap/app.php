<?php

use App\Http\Middleware\CustomerIsVerified;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\IsAuthorize;
use App\Http\Middleware\PaginationValidation;
use App\Providers\AuthProvider;
use App\Providers\DatabaseSessionProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware(['web'])
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            HandleInertiaRequests::class,
        ]);

        $middleware->alias([
            'authorize' => IsAuthorize::class,
            'pagination.validation' => PaginationValidation::class,
            'verified.customer' => CustomerIsVerified::class
        ]);

        $middleware->redirectGuestsTo(function (Request $request) {
            if($request->is('admin/*')) {
                return route('admin.login');
            }
            return route('login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->withProviders([
        DatabaseSessionProvider::class,
        AuthProvider::class,
    ])->create();
