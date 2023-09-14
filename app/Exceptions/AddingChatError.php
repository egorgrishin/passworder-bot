<?php

namespace App\Exceptions;

use App\Contracts\TelegramException as TelegramInterface;
use App\Helpers\Telegram\Telegram;
use Illuminate\Support\Facades\Http;

class AddingChatError extends TelegramException implements TelegramInterface
{
    public function sendMessage(): void
    {
        Telegram::send([
            'chat_id' => $this->chat_id,
            'text'    => 'Adding error',
        ]);
    }
}
