<?php

namespace App\Middleware;

use App\Enums\Stage;
use App\Helpers\Chat;
use App\Helpers\Telegram\Telegram;
use App\Request;
use Closure;

class Test
{
    public function run(Request $request, Closure $next): mixed
    {
        $chat = Chat::getInstance();
        if (in_array($chat->stage, $this->getConfidentialStages())) {
            Telegram::deleteMessage($request->dto->chat_id, $request->dto->message_id);
        }

        return $next($request);
    }

    private function getConfidentialStages(): array
    {
        return [
            Stage::SetChatPassword->value,
            Stage::SetTitle->value,
            Stage::SetLogin->value,
            Stage::SelectPasswordType->value,
            Stage::SetPasswordLen->value,
            Stage::SetPassword->value,
        ];
    }
}
