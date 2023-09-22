<?php

namespace App\Exceptions;

use App\Helpers\Telegram\Telegram;

class AddingChatError extends TelegramException
{
    public function sendMessage(): void
    {
        Telegram::send([
            'chat_id' => $this->chat_id,
            'text'    => 'Adding error',
        ]);
    }
}
