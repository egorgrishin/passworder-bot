<?php

namespace App\Middleware;

use App\Helpers\Chat;
use App\Helpers\Telegram\Telegram;
use App\Request;
use Closure;
use Illuminate\Support\Facades\Log;

class SendMessageByStage
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        Chat::commitChanges($request->dto);
        Log::debug('closing');
    }
}
