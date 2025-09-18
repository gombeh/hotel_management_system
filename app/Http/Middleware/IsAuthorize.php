<?php

namespace App\Http\Middleware;

use App\Attributes\Authorize;
use Closure;
use Exception;
use Illuminate\Http\Request;
use ReflectionException;
use ReflectionMethod;
use Symfony\Component\HttpFoundation\Response;

class IsAuthorize
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     * @throws ReflectionException
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        $route = $request->route();

        $controller = $route->getControllerClass();
        $method = $route->getActionMethod() !== $controller ? $route->getActionMethod() : '__invoke';

        $reflection = new ReflectionMethod($controller, $method);

        $attributes = $reflection->getAttributes(Authorize::class);

        if (!isset ($attributes[0])) {
            throw new Exception("Your method must used authorize attribute");
        }

        $attributes[0]->newInstance();

        return $next($request);
    }
}
