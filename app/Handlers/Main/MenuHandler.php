<?php

namespace App\Handlers\Main;

use App\Contracts\TelegramHandler;
use App\Dto;
use App\Enums\MenuButton;
use App\Enums\Stage;
use App\Helpers\Chat;
use App\Helpers\Telegram\Telegram;

class MenuHandler implements TelegramHandler
{
    public function run(Dto $dto): void
    {
        if ($dto->data === MenuButton::Add->name) {
            $this->addNewResource($dto);
        }
    }

    private function addNewResource(Dto $dto): void
    {
        Telegram::send([
            'chat_id' => $dto->chat_id,
            'text'    => 'Введите название ресурса',
        ]);
        Chat::setStage(Stage::SetTitle);
    }
}
