<?php

namespace App\Http\Middleware;

use Closure;

class SetSessionCookie
{
    public function handle($request, Closure $next)
    {
        if(!$request->is('admin/*')) {
            config(['session.cookie' => 'customer_session']);
        }

        return $next($request);
    }
}
