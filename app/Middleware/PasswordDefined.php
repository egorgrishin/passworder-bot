<?php

namespace App\Middleware;

use Closure;
use Illuminate\Http\Request;

class PasswordDefined
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        return $next($request);
    }
}
