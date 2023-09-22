<?php

namespace App\Exceptions;

use App\Helpers\Telegram\Telegram;
use Illuminate\Http\JsonResponse;
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
            Telegram::send([
                'chat_id' => $request->input('message.chat.id'),
                'text'    => 'Server error',
            ]);
        }
        return response()->json();
    }
}
