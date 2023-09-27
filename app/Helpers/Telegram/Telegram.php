<?php

namespace App\Helpers\Telegram;

use App\Helpers\Chat;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        Log::debug(!$response->successful());
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
        if (!$chat->outgoing_message_id) {
            return;
        }

        $token = env('TELEGRAM_BOT_TOKEN');
        Http::post(self::URL . "/bot$token/deleteMessage", [
            'chat_id'    => $chat_id,
            'message_id' => $chat->outgoing_message_id,
        ]);
    }
}
