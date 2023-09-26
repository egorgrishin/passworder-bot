<?php

namespace App\Middleware;

use App\Enums\Stage;
use App\Exceptions\SessionEnded;
use App\Helpers\Chat;
use App\Request;
use Closure;
use Illuminate\Support\Facades\Hash;

class SessionIsActive
{
    /**
     * Handle an incoming request.
     * @throws SessionEnded
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $chat = Chat::getInstance();
        if ($chat->stage !== Stage::WaitingPassword->value) {
            return $next($request);
        }
        if (Hash::check($request->dto->data, $chat->password)) {
            Chat::setStage(Stage::Menu);
            return $next($request);
        }

        throw new SessionEnded($request->dto);
    }
}
