<?php

namespace App;

use App\Commands\HelpCommand;
use App\Commands\MenuCommand;
use App\Contracts\CommandInterface;
use App\Enums\Stage;
use App\Handlers\MenuHandler;
use App\Handlers\SetPasswordHandler;
use App\Handlers\WaitingPasswordHandler;
use App\Helpers\Chat;
use Illuminate\Http\Request;

class Start
{
    private const COMMANDS = [
        '/menu' => MenuCommand::class,
        '/help' => HelpCommand::class,
    ];

    private const STAGES = [
        Stage::SetPassword->value     => SetPasswordHandler::class,
        Stage::WaitingPassword->value => WaitingPasswordHandler::class,
        Stage::Menu->value            => MenuHandler::class,
    ];

    public function start(Request $request): void
    {
        $message = $request->input('message.text');

        $this->messageIsCommand($message)
            ? $this->runCommandHandler($request)
            : $this->runStageHandler($request);
    }

    private function messageIsCommand(string $message): bool
    {
        return array_key_exists($message, self::COMMANDS);
    }

    public function runCommandHandler(Request $request): void
    {
        $command = $request->input('message.text');

        /** @var CommandInterface $handler */
        $handler = new (self::COMMANDS[$command]);
        $handler->run($request);
    }

    public function runStageHandler(Request $request): void
    {
        $chat = Chat::getInstance();

        /** @var CommandInterface $handler */
        $handler = new (self::STAGES[$chat->stage]);
        $handler->run($request);
    }
}
