<?php

namespace App\Middleware;

use App\Dto;
use App\Enums\Stage;
use App\Exceptions\SessionEnded;
use App\Helpers\Chat;
use Closure;
use Illuminate\Support\Facades\Hash;

class SessionIsActive
{
    /**
     * Handle an incoming request.
     * @throws SessionEnded
     */
    public function handle(Dto $dto, Closure $next): mixed
    {
        $chat = Chat::getInstance();
        if (
            $chat->stage !== Stage::WaitingPassword->value ||
            Hash::check($dto->data, $chat->password)
        ) {
            Chat::setStage(Stage::Menu);
            return $next($dto);
        }

        throw new SessionEnded($dto);
    }
}
