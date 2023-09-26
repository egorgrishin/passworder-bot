<?php

namespace App\Handlers\Create;

use App\Contracts\TelegramHandler;
use App\Dto;
use App\Enums\Stage;
use App\Helpers\Chat;
use App\Helpers\Telegram\Telegram;
use Illuminate\Support\Facades\DB;

class SetPassword implements TelegramHandler
{
    public function run(Dto $dto): void
    {
        $this->updateCredentials($dto);
        Telegram::send([
            'chat_id' => $dto->chat_id,
            'text'    => "Данные сохранены",
        ]);
        Chat::setStage(Stage::Menu);
    }

    private function updateCredentials(Dto $dto): void
    {
        DB::table('credentials')
            ->where('chat_hash', $dto->hash)
            ->where('is_saved', 0)
            ->update([
                'password' => $dto->data,
                'is_saved' => 1,
            ]);
    }
}
