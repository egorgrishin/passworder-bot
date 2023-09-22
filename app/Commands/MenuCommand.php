<?php

namespace App\Commands;

use App\Contracts\CommandInterface;
use App\Dto;
use App\Enums\MenuButton;
use App\Enums\Stage;
use App\Helpers\Chat;
use App\Helpers\Telegram\Telegram;

class MenuCommand implements CommandInterface
{
    public function run(Dto $dto): void
    {
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
