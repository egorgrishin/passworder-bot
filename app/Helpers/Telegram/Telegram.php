<?php

namespace App\Helpers\Telegram;

use Illuminate\Support\Facades\Http;

class Telegram
{
    private const URL = 'https://api.telegram.org';

    /**
     * Отправляет сообщение от бота в Telegram
     */
    public static function send(int $chat_id, string $text): void
    {
        $token = env('TELEGRAM_BOT_TOKEN');

        Http::post(self::URL . "/bot$token/sendMessage", [
            'chat_id' => $chat_id,
            'text'    => $text,
        ]);
    }
}
