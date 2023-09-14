<?php

namespace App\Middleware;

use App\Exceptions\PasswordNotDefined;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasswordDefined
{
    /**
     * Handle an incoming request.
     * @throws PasswordNotDefined
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $chat = $this->getChatByHash(
            $hash = $request->input('hash')
        );

        if ($chat->password === null) {
            $chat_id = $request->input('message.chat.id');
            throw new PasswordNotDefined($chat_id, $hash);
        }

        return $next($request);
    }

    /**
     * Возвращает чат по хэшу
     */
    private function getChatByHash(string $hash): object
    {
        return DB::table('chats')
            ->where('hash', $hash)
            ->first();
    }
}
