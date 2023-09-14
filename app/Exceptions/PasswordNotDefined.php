<?php

namespace App\Exceptions;

use App\Contracts\TelegramException as TelegramInterface;
use App\Helpers\Telegram\Telegram;
use Illuminate\Support\Facades\DB;

class PasswordNotDefined extends TelegramException implements TelegramInterface
{
    private string $hash;

    public function __construct(int $chat_id, string $hash)
    {
        parent::__construct($chat_id);
        $this->hash = $hash;
    }

    /**
     * Отправляет сообщение о том что нужно установить пароль
     */
    public function sendMessage(): void
    {
        $this->updateChatStage();
        Telegram::send([
            'chat_id' => $this->chat_id,
            'text' => 'Пароль не установлен. Введите пароль',
        ]);
    }

    /**
     * Переносит пользователя на этап установки пароля
     */
    private function updateChatStage(): void
    {
        DB::table('chats')
            ->where('hash', $this->hash)
            ->update(['stage' => 'set_password']);
    }
}