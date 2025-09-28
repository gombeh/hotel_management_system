<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PaginationValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $defaultPerPage = config('pagination.per_page');
        $maxPerPage = config('pagination.max_per_page');
        $perPage = (int)$request->get('limit', $defaultPerPage);
        $request->merge(['limit' => $perPage >= 1 ? min($perPage, $maxPerPage) : $defaultPerPage]);
        $request->merge(['page' => max((int)$request->get('page', 1), 1)]);
        return $next($request);
    }
}
