<?php

namespace App\Middleware;

use App\Enums\Stage;
use App\Exceptions\PasswordNotDefined;
use App\Helpers\Chat;
use App\Request;
use Closure;

class PasswordDefined
{
    /**
     * Handle an incoming request.
     * @throws PasswordNotDefined
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $chat = Chat::getInstance();
        if ($chat->stage === Stage::SetPassword->value) {
            return $next($request);
        }

        if ($chat->password === null) {
            throw new PasswordNotDefined($request->dto);
        }

        return $next($request);
    }
}
