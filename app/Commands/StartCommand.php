<?php

namespace App\Commands;

use App\Contracts\CommandInterface;
use App\Helpers\Telegram\Telegram;
use Illuminate\Http\Request;

class StartCommand implements CommandInterface
{
    public function run(Request $request): void
    {
        Telegram::send([
            'chat_id' => '935824965',
            'text' => 'Is a start command',
            'reply_markup' => [
                'keyboard' => ['Добавить', 'Посмотреть'],
            ],
        ]);
    }
}
