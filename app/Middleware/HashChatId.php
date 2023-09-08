<?php

namespace App\Middleware;

use App\Exceptions\AddingChatError;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HashChatId
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $chat_id = $request->input('message.chat.id');
        if (!empty($chat_id)) {
            $request->offsetSet('message.chat.hash', hash('xxh128', $chat_id));
        }

        Log::debug($request->all());
        throw new AddingChatError($chat_id);

        return $next($request);
    }
}
