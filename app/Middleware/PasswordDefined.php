<?php

namespace App\Middleware;

use App\Dto;
use App\Enums\Stage;
use App\Exceptions\PasswordNotDefined;
use App\Helpers\Chat;
use Closure;

class PasswordDefined
{
    /**
     * Handle an incoming request.
     * @throws PasswordNotDefined
     */
    public function handle(Dto $dto, Closure $next): mixed
    {
        $chat = Chat::getInstance();
        if ($chat->stage === Stage::SetPassword->value) {
            return $next($dto);
        }

        if ($chat->password === null) {
            throw new PasswordNotDefined($dto);
        }

        return $next($dto);
    }
}
