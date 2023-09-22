<?php

namespace App\Exceptions;

use App\Enums\Stage;
use App\Helpers\Telegram\Telegram;
use Illuminate\Support\Facades\DB;

class PasswordNotDefined extends TelegramException
{
    /**
     * Отправляет сообщение о том что нужно установить пароль
     */
    public function sendMessage(): void
    {
        $this->updateChatStage();
        Telegram::send([
            'chat_id' => $this->dto->chat_id,
            'text'    => 'Пароль не установлен. Введите пароль',
        ]);
    }

    /**
     * Переносит пользователя на этап установки пароля
     */
    private function updateChatStage(): void
    {
        DB::table('chats')
            ->where('hash', $this->dto->hash)
            ->update(['stage' => Stage::SetPassword->value]);
    }
}
