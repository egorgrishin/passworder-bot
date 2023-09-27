<?php

namespace App\Exceptions;

use App\Helpers\Chat;
use App\Helpers\Telegram\Telegram;
use App\Request;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     * @param Request $request
     * @throws Throwable
     */
    public function render($request, Throwable $e): JsonResponse
    {
        if ($e instanceof TelegramException) {
            $e->sendMessage();
            Chat::commitChanges($request->dto);
        } else {
            Telegram::send([
                'chat_id' => $request->input('message.chat.id'),
                'text'    => 'Server error',
            ]);
        }
        return response()->json();
    }
}
