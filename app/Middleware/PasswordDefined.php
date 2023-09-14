<?php

namespace App\Middleware;

use App\Exceptions\PasswordNotDefined;
use App\Helpers\Chat;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PasswordDefined
{
    /**
     * Handle an incoming request.
     * @throws PasswordNotDefined
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $chat = Chat::getInstance();
        Log::debug((array)$chat);
        if ($chat->stage === 'set_password') {
            return $next($request);
        }

        if ($chat->password === null) {
            $chat_id = $request->input('message.chat.id');
            throw new PasswordNotDefined($chat_id, $chat->hash);
        }

        return $next($request);
    }
}
