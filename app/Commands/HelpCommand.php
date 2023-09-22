<?php

namespace App\Commands;

use App\Contracts\CommandInterface;
use App\Helpers\Telegram\Telegram;
use Illuminate\Http\Request;

class HelpCommand implements CommandInterface
{
    public function run(Request $request): void
    {
        Telegram::send([
            'chat_id' => $request->input('message.chat.id'),
            'text'    => 'Помощь',
        ]);
    }
}
