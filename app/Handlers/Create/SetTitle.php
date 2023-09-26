<?php

namespace App\Handlers\Create;

use App\Contracts\TelegramHandler;
use App\Dto;
use App\Enums\Stage;
use App\Helpers\Chat;
use App\Helpers\Telegram\Telegram;
use Illuminate\Support\Facades\DB;

class SetTitle implements TelegramHandler
{
    public function run(Dto $dto): void
    {
        $this->createCredentials($dto);
        Telegram::send([
            'chat_id' => $dto->chat_id,
            'text'    => "Введите email/номер телефона/логин или что-то другое",
        ]);
        Chat::setStage(Stage::SetLogin);
    }

    private function createCredentials(Dto $dto): void
    {
        DB::table('credentials')->insert([
            'chat_hash' => $dto->hash,
            'title'     => $dto->data,
        ]);
    }
}
