<?php

namespace App;

use App\Helpers\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class Start
{
    public function start(Request $request)
    {
        return response()->json();
        Log::debug($request->all());
        $chat = Chat::getInstance();
        switch ($chat->stage) {
            case 'set_password':
                $this->setPasswordHandler($request);
                return;
        }
    }

    private function setPasswordHandler(Request $request): void
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
