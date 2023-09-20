<?php

namespace App\Middleware;

use App\Exceptions\SessionEnded;
use App\Helpers\Chat;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;

class SessionIsActive
{
    /**
     * Handle an incoming request.
     * @throws SessionEnded
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $chat = Chat::getInstance();
        $text = $request->input('message.text', '');

        if ($chat->stage !== 'waiting_password' || Hash::check($text, $chat->password)) {
            Chat::setStage('menu');
            return $next($request);
        }

        $chat_id = $request->input('message.chat.id');
        throw new SessionEnded($chat_id, $chat->hash);
    }
}
