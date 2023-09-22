<?php

namespace App\Middleware;

use App\Dto;
use Closure;
use Illuminate\Http\Request;

class HashChatId
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        return $next(Dto::make($request));
    }
}
