<?php

namespace App\Helpers\Telegram;

use App\Helpers\Chat;
use Illuminate\Support\Facades\Http;

class Telegram
{
    private const URL = 'https://api.telegram.org';

    /**
     * Отправляет сообщение от бота в Telegram
     */
    public static function send(array $data)
    {
        self::sendMessage($data);
        Chat::setLastMessageText($data['text']);
    }

    private static function sendMessage(array $data)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $response = Http::post(self::URL . "/bot$token/sendMessage", $data);
        if (!$response->successful()) {
            return;
        }

        $body = json_decode($response->body(), true);
        if (empty($body['ok']) || empty($body['result'])) {
            return;
        }
        Chat::setOutgoingMessageId($body['result']['message_id']);
    }

    public static function deleteMessage(int $chat_id, ?int $message_id): void
    {
        if (!$message_id) {
            return;
        }

        $token = env('TELEGRAM_BOT_TOKEN');
        Http::post(self::URL . "/bot$token/deleteMessage", [
            'chat_id'    => $chat_id,
            'message_id' => $message_id,
        ]);
    }
}
