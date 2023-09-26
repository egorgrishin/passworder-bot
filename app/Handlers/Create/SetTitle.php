<?php

namespace App\Handlers\Create;

use App\Contracts\TelegramHandler;
use App\Dto;
use App\Enums\Stage;
use App\Helpers\Chat;
use App\Helpers\Telegram\Telegram;

class SetTitle implements TelegramHandler
{
    public function run(Dto $dto): void
    {
        Telegram::send([
            'chat_id' => $dto->chat_id,
            'text'    => "Введите email/номер телефона/логин или что-то другое",
        ]);
        Chat::setStage(Stage::SetLogin);
    }
}
