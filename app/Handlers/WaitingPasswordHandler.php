<?php

namespace App\Handlers;

use App\Contracts\TelegramHandler;
use App\Helpers\Telegram\Telegram;
use Illuminate\Http\Request;

class WaitingPasswordHandler implements TelegramHandler
{
    public function run(Request $request): void
    {
        Telegram::send([
            'chat_id'      => $request->input('message.chat.id'),
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
