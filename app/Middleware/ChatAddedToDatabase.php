<?php

namespace App\Middleware;

use App\Exceptions\AddingChatError;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class ChatAddedToDatabase
{
    /**
     * Проверяет существование чата в базе данных
     * @throws AddingChatError
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $hash = $request->input('hash');
        if ($this->chatAddedToDatabase($hash)) {
            return $next($request);
        }

        try {
            $this->addChatToDatabase($hash);
            return $next($request);
        } catch (Throwable) {
            throw new AddingChatError($request->input('message.chat.id'));
        }
    }

    /**
     * Проверяет наличие чата пользователя с ботом в базе данных
     */
    private function chatAddedToDatabase(string $hash): bool
    {
        return DB::table('chats')
            ->where('hash', $hash)
            ->exists();
    }

    /**
     * Добавляет чат пользователя с ботом в базу данных
     */
    private function addChatToDatabase(string $hash): void
    {
        DB::table('chats')->insert([
            'uuid' => $this->getUuid(),
            'hash' => $hash,
        ]);
    }

    /**
     * Возвращает свободный UUID
     */
    private function getUuid(): string
    {
        do {
            $uuid = Str::uuid()->toString();
        } while ($this->uuidIsBusy($uuid));
        return $uuid;
    }

    /**
     * Проверяет UUID на доступность
     */
    private function uuidIsBusy(string $uuid): bool
    {
        return DB::table('chats')
            ->where('uuid', $uuid)
            ->exists();
    }
}
