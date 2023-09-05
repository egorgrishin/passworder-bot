<?php

namespace App\Exceptions;

use App\Contracts\TelegramException as TelegramInterface;
use Illuminate\Support\Facades\Http;

class AddingChatError extends TelegramException implements TelegramInterface
{
    public function sendMessage(): void
    {
        $url = 'https://api.telegram.org/';
        $bot = 'bot6521726004:AAHh86wPhEu2tg_DJethX90BxmOq4BUw5ks/';

        Http::post($url . $bot . 'sendMessage', [
            'chat_id' => $this->chat_id,
            'text'    => 'Start message',
        ]);
    }
}
