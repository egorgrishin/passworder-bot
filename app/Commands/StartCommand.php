<?php

namespace App\Commands;

use App\Contracts\CommandInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StartCommand implements CommandInterface
{
    public function run(Request $request): JsonResponse
    {

        Log::debug($request->all());
        $url = 'https://api.telegram.org/';
        $bot = 'bot6521726004:AAHh86wPhEu2tg_DJethX90BxmOq4BUw5ks/';
        Http::post($url . $bot . 'sendMessage', [
            'chat_id' => '935824965',
            'text' => 'Is a start command',
        ]);
        return response()->json();
    }
}
