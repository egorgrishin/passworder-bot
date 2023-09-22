<?php

namespace App\Helpers\Telegram;

use Illuminate\Support\Facades\Http;

class Telegram
{
    private const URL = 'https://api.telegram.org';

    /**
     * Отправляет сообщение от бота в Telegram
     */
    public static function send(array $data)
    {
        $token = env('TELEGRAM_BOT_TOKEN');

        return Http::post(self::URL . "/bot$token/sendMessage", $data);
    }
}
