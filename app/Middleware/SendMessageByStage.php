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
        Telegram::deleteMessage($request->dto->chat_id, $request->dto->message_id);
        Log::debug('closing');
    }
}
