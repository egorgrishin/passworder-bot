<?php

namespace App\Handlers;

use App\Contracts\TelegramHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SetPasswordHandler implements TelegramHandler
{
    public function run(Request $request): void
    {
        $password = $request->input('message.text');
        DB::table('chats')
            ->where('hash', $request->input('hash'))
            ->update([
                'password'         => Hash::make($password),
                'last_activity_at' => Date::now()->toDateTimeString(),
                'stage'            => 'menu',
            ]);
    }
}
