<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class CustomerIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $customer = auth('customer')->user();

        if (!$customer) return $next($request);

        $currentRoute = Route::currentRouteName();

        $registerRoutes = [
            'verifyCodeForm',
            'verifyCode',
            'resendCode',
            'completeRegisterForm',
            'completeRegister',
            'backRegister',
        ];

        if ($customer->isActive() && in_array($currentRoute, $registerRoutes)) {
            return redirect()->route('home');
        } else if (!$customer->isVerified() && in_array($currentRoute, ['completeRegister', 'completeRegisterForm'])) {
            return redirect()->route('verifyCodeForm');
        } else if ($customer->isIncomplete() && in_array($currentRoute, ['verifyCodeForm', 'verifyCode'])) {
            return redirect()->route('completeRegisterForm');
        } else if (!$customer->isActive() && in_array($currentRoute, $registerRoutes)) {
            return $next($request);
        } else if (!$customer->isVerified()) {
            return redirect()->route('verifyCodeForm');
        } else if ($customer->isIncomplete()) {
            return redirect()->route('completeRegisterForm');
        }
        return $next($request);
    }
}
