<?php

namespace App\Handlers\Create;

use App\Contracts\TelegramHandler;
use App\Dto;
use App\Enums\Password;
use App\Enums\Stage;
use App\Helpers\Chat;
use App\Helpers\Telegram\Telegram;
use Illuminate\Support\Facades\DB;

class SetLogin implements TelegramHandler
{
    public function run(Dto $dto): void
    {
        $this->updateCredentials($dto);
        Telegram::send([
            'chat_id'      => $dto->chat_id,
            'text'         => 'Выберите действие',
            'reply_markup' => [
                'inline_keyboard'   => [
                    [
                        [
                            'text'          => Password::Enter->value,
                            'callback_data' => Password::Enter->name,
                        ],
                    ],
                    [
                        [
                            'text'          => Password::Generate->value,
                            'callback_data' => Password::Generate->name,
                        ],
                    ],
                ],
                'one_time_keyboard' => true,
                'resize_keyboard'   => true,
            ],
        ]);
        Chat::setStage(Stage::SelectPasswordType);
    }

    private function updateCredentials(Dto $dto): void
    {
        DB::table('credentials')
            ->where('chat_hash', $dto->hash)
            ->where('is_saved', 0)
            ->update([
                'login' => $dto->data,
            ]);
    }
}
