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
        $token = env('TELEGRAM_BOT_TOKEN');

        $response = Http::post(self::URL . "/bot$token/sendMessage", $data);
        if (!$response->successful()) {
            return;
        }
        self::deleteLastOutgoingMessage($data['chat_id']);

        $body = json_decode($response->body(), true);
        if (empty($body['ok']) || empty($body['result'])) {
            return;
        }
        Chat::setOutgoingMessageId($body['result']['message_id']);
    }

    private static function deleteLastOutgoingMessage(int $chat_id): void
    {
        $chat = Chat::getInstance();
        if ($chat->outgoing_message_id) {
            self::deleteMessage($chat_id, $chat->outgoing_message_id);
        }
    }

    public static function deleteMessage(int $chat_id, int $message_id): void
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        Http::post(self::URL . "/bot$token/deleteMessage", [
            'chat_id'    => $chat_id,
            'message_id' => $message_id,
        ]);
    }
}
