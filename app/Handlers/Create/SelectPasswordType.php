<?php

namespace App\Handlers\Create;

use App\Contracts\TelegramHandler;
use App\Dto;
use App\Enums\Password;
use App\Enums\Stage;
use App\Helpers\Chat;
use App\Helpers\Telegram\Telegram;

class SelectPasswordType implements TelegramHandler
{
    public function run(Dto $dto): void
    {
        if ($dto->data == Password::Enter->value) {
            Telegram::send([
                'chat_id' => $dto->chat_id,
                'text'    => "Введите пароль. Для пропуска введите @skip",
            ]);
            Chat::setStage(Stage::SetPassword);
        } elseif ($dto->data == Password::Generate->value) {
            Telegram::send([
                'chat_id' => $dto->chat_id,
                'text'    => "Введите длину пароля. Желательно 32, но не менее 8",
            ]);
            Chat::setStage(Stage::Menu);
        }
    }
}
