<?php

namespace App\Handlers\Main;

use App\Contracts\TelegramHandler;
use App\Dto;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SetPasswordHandler implements TelegramHandler
{
    public function run(Dto $dto): void
    {
        DB::table('chats')
            ->where('hash', $dto->hash)
            ->update([
                'password'         => Hash::make($dto->data),
                'last_activity_at' => Date::now()->toDateTimeString(),
                'stage'            => 'menu',
            ]);
    }
}
