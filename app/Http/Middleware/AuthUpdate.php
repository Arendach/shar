<?php

namespace App\Http\Middleware;

use Closure;

class AuthUpdate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (is_auth()){
            setcookie('session', $_COOKIE['session'], time() + settings('other.time_auth'));
        }

        return $next($request);
    }
}
