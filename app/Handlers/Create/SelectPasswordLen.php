<?php

namespace App\Handlers\Create;

use App\Contracts\TelegramHandler;
use App\Dto;
use App\Enums\Stage;
use App\Helpers\Chat;
use App\Helpers\Generator;
use App\Helpers\Telegram\Telegram;
use Illuminate\Support\Facades\DB;

class SelectPasswordLen implements TelegramHandler
{
    public function run(Dto $dto): void
    {
        if (!is_numeric($dto->data)) {
            Telegram::send([
                'chat_id' => $dto->chat_id,
                'text'    => "Некорректная длина пароля, попробуйте еще раз",
            ]);
            return;
        }

        $length = (int) $dto->data;
        if ($length < 8) {
            Telegram::send([
                'chat_id' => $dto->chat_id,
                'text'    => "Пароль не может быть короче 8 символов. Введите другую длину пароля",
            ]);
            return;
        }

        $password = (new Generator())->create($length);
        $this->updateCredentials($dto, $password);
        Telegram::send([
            'chat_id' => $dto->chat_id,
            'text'    => "Данные сохранены",
        ]);
        Chat::setStage(Stage::Menu);
    }

    private function updateCredentials(Dto $dto, string $password): void
    {
        DB::table('credentials')
            ->where('chat_hash', $dto->hash)
            ->where('is_saved', 0)
            ->update([
                'password' => $password,
                'is_saved' => 1,
            ]);
    }
}
