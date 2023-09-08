<?php

namespace App\Middleware;

use App\Exceptions\AddingChatError;
use App\Helpers\Hasher;
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
            $request->offsetSet('hash', Hasher::make($chat_id));
        }

        return $next($request);
    }
}
