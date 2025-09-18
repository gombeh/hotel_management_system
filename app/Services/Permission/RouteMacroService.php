<?php

namespace App\Services\Permission;


use Illuminate\Support\Facades\Route;

class RouteMacroService
{
    public static function handle(): void
    {
        Route::macro("postAuth", function (string $uri, $action) {
            /** @var $this Route */
            return $this->post($uri, $action)->middleware('authorize');
        });
        Route::macro("putAuth", function (string $uri, $action) {
            /** @var $this Route */
            return $this->put($uri, $action)->middleware('authorize');
        });
        Route::macro("patchAuth", function (string $uri, $action) {
            /** @var $this Route */
            return $this->patch($uri, $action)->middleware('authorize');
        });
        Route::macro("getAuth", function (string $uri, $action) {
            /** @var $this Route */
            return $this->get($uri, $action)->middleware('authorize');
        });
        Route::macro("deleteAuth", function (string $uri, $action) {
            /** @var $this Route */
            return $this->delete($uri, $action)->middleware('authorize');
        });
    }

}
