<?php

namespace App\Middleware;

use App\Dto;
use App\Exceptions\AddingChatError;
use App\Helpers\Chat;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class ChatAddedToDatabase
{
    /**
     * Проверяет существование чата в базе данных
     * @throws AddingChatError
     */
    public function handle(Dto $dto, Closure $next): mixed
    {
        if (Chat::setInstance($dto->hash)) {
            return $next($dto);
        }

        try {
            $this->addChatToDatabase($dto->hash);
            Chat::setInstance($dto->hash);
            return $next($dto);
        } catch (Throwable) {
            throw new AddingChatError($dto);
        }
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
