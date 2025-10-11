<?php

namespace App\Providers;

use App\Models\Facility;
use App\Models\RoomType;
use App\Models\User;
use App\Policies\RolePolicy;
use App\Services\Permission\RouteMacroService;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;
use Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        RouteMacroService::handle();
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
        ]);

        Gate::policy(Role::class, RolePolicy::class);

        Gate::before(function (User $user, string $ability) {
            return $user->is_super_admin ? true : null;
        });
    }
}
