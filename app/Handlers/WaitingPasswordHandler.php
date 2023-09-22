<?php

namespace App\Handlers;

use App\Contracts\TelegramHandler;
use App\Dto;
use App\Helpers\Telegram\Telegram;

class WaitingPasswordHandler implements TelegramHandler
{
    public function run(Dto $dto): void
    {
        Telegram::send([
            'chat_id'      => $dto->chat_id,
            'text'         => 'Тест меню',
            'reply_markup' => [
                'keyboard' => [
                    ['Добавить'],
                ],
                'one_time_keyboard' => true,
                'resize_keyboard' => true,
            ],
        ]);
    }
}
