<?php

namespace App\Commands;

use App\Contracts\CommandInterface;
use App\Dto;
use App\Enums\MenuButton;
use App\Enums\Stage;
use App\Helpers\Chat;
use App\Helpers\Telegram\Telegram;

class StartCommand implements CommandInterface
{
    public function run(Dto $dto): void
    {
        Telegram::send([
            'chat_id' => $dto->chat_id,
            'text'    => 'Создайте пароль',
        ]);
        Chat::setStage(Stage::SetChatPassword);
    }
}
