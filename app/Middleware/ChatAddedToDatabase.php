<?php

namespace App\Middleware;

use App\Exceptions\AddingChatError;
use App\Helpers\Chat;
use App\Helpers\Telegram\Telegram;
use App\Request;
use Closure;
use Illuminate\Support\Facades\DB;
use Throwable;

class ChatAddedToDatabase
{
    /**
     * Проверяет существование чата в базе данных
     * @throws AddingChatError
     */
    public function handle(Request $request, Closure $next): mixed
    {
        Telegram::deleteMessage($request->dto->chat_id, $request->dto->message_id);
        if (Chat::setInstance($request->dto->hash)) {
            return $next($request);
        }

        try {
            $this->addChatToDatabase($request->dto->hash);
            Chat::setInstance($request->dto->hash);
            return $next($request);
        } catch (Throwable) {
            throw new AddingChatError($request->dto);
        }
    }

    /**
     * Добавляет чат пользователя с ботом в базу данных
     */
    private function addChatToDatabase(string $hash): void
    {
        DB::table('chats')->insert([
            'hash' => $hash,
        ]);
    }
}
