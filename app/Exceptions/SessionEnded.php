<?php

namespace App\Exceptions;

use App\Contracts\TelegramException as TelegramInterface;
use App\Helpers\Telegram\Telegram;
use Illuminate\Support\Facades\DB;

class SessionEnded extends TelegramException implements TelegramInterface
{
    private string $hash;

    public function __construct(int $chat_id, string $hash)
    {
        parent::__construct($chat_id);
        $this->hash = $hash;
    }

    /**
     * Отправляет сообщение о том что нужно ввести пароль для работы
     */
    public function sendMessage(): void
    {
        $this->updateChatStage();
        Telegram::send([
            'chat_id' => $this->chat_id,
            'text' => 'Сессия завершена. Для продолжения работы введите пароль',
        ]);
    }

    /**
     * Переносит пользователя на этап установки пароля
     */
    private function updateChatStage(): void
    {
        DB::table('chats')
            ->where('hash', $this->hash)
            ->update(['stage' => 'menu']);
    }
}
