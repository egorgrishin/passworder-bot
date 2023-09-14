<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class Start
{
    public function start(Request $request)
    {
        Log::debug($request->all());
        $chat = $this->getChatByHash($request->input('hash'));
        switch ($chat->stage) {
            case 'set_password':
                $this->setPasswordHandler($request);
                return;
        }
    }

    /**
     * Возвращает чат по хэшу
     */
    private function getChatByHash(string $hash): object
    {
        return DB::table('chats')
            ->where('hash', $hash)
            ->first();
    }

    private function setPasswordHandler(Request $request): void
    {
        $password = $request->input('message.text');
        DB::table('chats')
            ->where('hash', $request->input('hash'))
            ->update([
                'password' => Hash::make($password),
                'last_activity_at' => Date::now()->toDateTimeString(),
            ]);
    }
}
