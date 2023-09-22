<?php

namespace App\Exceptions;

use App\Enums\Stage;
use App\Helpers\Telegram\Telegram;
use Illuminate\Support\Facades\DB;

class SessionEnded extends TelegramException
{
    /**
     * Отправляет сообщение о том что нужно ввести пароль для работы
     */
    public function sendMessage(): void
    {
        $this->updateChatStage();
        Telegram::send([
            'chat_id' => $this->dto->chat_id,
            'text' => 'Сессия завершена. Для продолжения работы введите пароль',
        ]);
    }

    /**
     * Переносит пользователя на этап установки пароля
     */
    private function updateChatStage(): void
    {
        DB::table('chats')
            ->where('hash', $this->dto->hash)
            ->update(['stage' => Stage::WaitingPassword->value]);
    }
}
