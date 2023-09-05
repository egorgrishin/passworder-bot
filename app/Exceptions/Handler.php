<?php

namespace App\Exceptions;

use App\Contracts\TelegramException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     * @throws Throwable
     */
    public function render($request, Throwable $e): JsonResponse
    {
        if ($e instanceof TelegramException) {
            $e->sendMessage();
        } else {
            $url = 'https://api.telegram.org/';
            $bot = 'bot6521726004:AAHh86wPhEu2tg_DJethX90BxmOq4BUw5ks/';

            Http::post($url . $bot . 'sendMessage', [
                'chat_id' => $request->input('message.chat.id'),
                'text'    => 'Server error',
            ]);
        }
        return response()->json();
    }
}
