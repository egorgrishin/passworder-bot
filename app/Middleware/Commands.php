<?php

namespace App\Middleware;

use App\Commands\StartCommand;
use App\Contracts\CommandInterface;
use Closure;
use Illuminate\Http\Request;

class Commands
{
    /**
     * @var class-string<CommandInterface>[]
     */
    private const COMMANDS = [
        '/start' => StartCommand::class,
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $key = $request->input('message.text');
        if (!array_key_exists($key, self::COMMANDS)) {
            return $next($request);
        }

        /** @var CommandInterface $command */
        $command = new (self::COMMANDS[$key]);
        return $command->run($request);
    }
}
