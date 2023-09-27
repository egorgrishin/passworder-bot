<?php

namespace App\Commands;

use App\Contracts\CommandInterface;
use App\Dto;
use App\Enums\MenuButton;
use App\Enums\Stage;
use App\Helpers\Chat;
use App\Helpers\Telegram\Telegram;

class NewMessageCommand implements CommandInterface
{
    public function run(Dto $dto): void
    {
        $chat = Chat::getInstance();
        Telegram::deleteMessage($dto->chat_id, $chat->last_message_id);
        Chat::setOutgoingMessageId(null);
        Telegram::send([
            'chat_id'      => $dto->chat_id,
            'text'         => 'Выберите действие',
            'reply_markup' => [
                'inline_keyboard'   => [
                    [
                        [
                            'text'          => MenuButton::Add->value,
                            'callback_data' => MenuButton::Add->name,
                        ],
                    ],
                    [
                        [
                            'text'          => MenuButton::Find->value,
                            'callback_data' => MenuButton::Find->name,
                        ],
                    ],
                ],
                'one_time_keyboard' => true,
                'resize_keyboard'   => true,
            ],
        ]);
        Chat::setStage(Stage::Menu);
    }
}
