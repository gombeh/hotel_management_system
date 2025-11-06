<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Facility;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Route::macro('camelResource', function ($uri, $controller) {
            $parameter = Str::camel(Str::singular($uri));
            $name = Str::camel($uri);

            return Route::resource($uri, $controller)
                ->names($name)
                ->parameters([$uri => $parameter]);
        });

        Route::macro('camelApiResource', function ($uri, $controller) {
            $parameter = Str::camel(Str::singular($uri));
            $name = Str::camel($uri);

            return Route::apiResource($uri, $controller)
                ->names($name)
                ->parameters([$uri => $parameter]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        MorphTo::enforceMorphMap([
            'user' => User::class,
            'facility' => Facility::class,
            'roomType' => RoomType::class,
            'customer' => Customer::class,
        ]);

        ResetPassword::createUrlUsing(function (Customer|User $user, string $token) {
            $routeName = $user instanceof User ? 'admin.password.reset' : 'password.reset';

            return route($routeName, ['token' => $token, 'email' => $user->email]);
        });
    }
}
