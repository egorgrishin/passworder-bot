<?php

namespace App\Middleware;

use App\Helpers\Chat;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SendMessageByStage
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        Chat::commitChanges();
        Log::debug('closing');
    }
}
