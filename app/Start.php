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
        $this->messageIsCommand($request->dto->data)
            ? $this->runCommandHandler($request->dto)
            : $this->runStageHandler($request->dto);
    }

    private function messageIsCommand(string $message): bool
    {
        return array_key_exists($message, self::COMMANDS);
    }

    public function runCommandHandler(Dto $dto): void
    {
        /** @var CommandInterface $handler */
        $handler = new (self::COMMANDS[$dto->data]);
        $handler->run($dto);
    }

    public function runStageHandler(Dto $dto): void
    {
        $chat = Chat::getInstance();

        /** @var CommandInterface $handler */
        $handler = new (self::STAGES[$chat->stage]);
        $handler->run($dto);
    }
}
