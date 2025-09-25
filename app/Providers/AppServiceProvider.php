<?php

namespace App\Providers;

use App\Models\Facility;
use App\Models\User;
use App\Policies\RolePolicy;
use App\Services\Permission\RouteMacroService;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        RouteMacroService::handle();
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
        ]);

        Gate::policy(Role::class, RolePolicy::class);

        Gate::before(function (User $user, string $ability) {
            return $user->is_super_admin ? true : null;
        });
    }
}
