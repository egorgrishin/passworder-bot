<?php

namespace App\Middleware;

use App\Dto;
use App\Helpers\Chat;
use Closure;
use Illuminate\Support\Facades\Log;

class SendMessageByStage
{
    /**
     * Handle an incoming request.
     */
    public function handle(Dto $dto, Closure $next)
    {
        $response = $next($dto);
        Chat::commitChanges();
        Log::debug('closing');
    }
}
