<?php

namespace App\Commands;

use App\Contracts\CommandInterface;
use App\Dto;
use App\Helpers\Telegram\Telegram;

class HelpCommand implements CommandInterface
{
    public function run(Dto $dto): void
    {
        Telegram::send([
            'chat_id' => $dto->chat_id,
            'text'    => 'Помощь',
        ]);
    }
}
