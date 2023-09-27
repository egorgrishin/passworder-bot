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
        $chat = Chat::getInstance();
        if ($chat->last_message_id && self::messageIsExists($data)) {
            self::updateMessage($data);
        } else {
            self::sendMessage($data);
        }
        Chat::setLastMessageText($data['text']);
    }

    private static function messageIsExists(array $data): bool
    {
        $chat = Chat::getInstance();
        $token = env('TELEGRAM_BOT_TOKEN');
        return Http::post(self::URL . "/bot$token/editMessageText", [
            'chat_id'    => $data['chat_id'],
            'message_id' => $chat->last_message_id,
            'text'       => 'Обработка',
        ])->successful();
    }

    private static function updateMessage(array $data): void
    {
        $chat = Chat::getInstance();
        $token = env('TELEGRAM_BOT_TOKEN');
        Http::post(self::URL . "/bot$token/editMessageText", [
            'chat_id'    => $data['chat_id'],
            'message_id' => $chat->last_message_id,
            'text'       => $data['text'],
        ]);

        $update = [
            'chat_id'    => $data['chat_id'],
            'message_id' => $chat->last_message_id,
        ];
        if (!empty($data['reply_markup'])) {
            $update['reply_markup'] = $data['reply_markup'];
        }
        Http::post(self::URL . "/bot$token/editMessageReplyMarkup", $update);
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
