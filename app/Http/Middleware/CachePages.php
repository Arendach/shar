<?php

namespace App\Http\Middleware;

use Closure;

class CachePages
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
