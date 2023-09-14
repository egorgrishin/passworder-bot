<?php

namespace App;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Start
{
    public function start(Request $request)
    {
        Log::debug($request->all());
//        $chat = $this->getChatByHash($request->input('hash'));
//        switch ($chat->stage) {
//            case
//        }
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
}
