<?php

namespace App\Middleware;

use App\Exceptions\SessionEnded;
use App\Helpers\Chat;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class SessionIsActive
{
    /**
     * Handle an incoming request.
     * @throws SessionEnded
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $chat = Chat::getInstance();
        if ($chat->stage === 'set_password' || $this->sessionIsActive($chat->last_activity_at)) {
            return $next($request);
        }

        $chat_id = $request->input('message.chat.id');
        throw new SessionEnded($chat_id, $chat->hash);
    }

    /**
     * Проверяет активность сессии
     */
    private function sessionIsActive(string $last_activity): bool
    {
        $last_activity = Date::parse($last_activity);
        $life_time = config('sess.life_time');

        return $last_activity->addMinutes($life_time) >= Date::now();
    }
}
