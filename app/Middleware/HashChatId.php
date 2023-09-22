<?php

namespace App\Middleware;

use App\Helpers\Hasher;
use Closure;
use Illuminate\Http\Request;

class HashChatId
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $chat_id = $request->input('message.chat.id');
        $request->offsetSet('hash', Hasher::make($chat_id));

        return $next($request);
    }
}
