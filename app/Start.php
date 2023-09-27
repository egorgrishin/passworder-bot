<?php

namespace App;

use App\Commands\HelpCommand;
use App\Commands\MenuCommand;
use App\Commands\StartCommand;
use App\Contracts\CommandInterface;
use App\Enums\Stage;
use App\Handlers\Create\SelectPasswordLen;
use App\Handlers\Create\SelectPasswordType;
use App\Handlers\Create\SetLogin;
use App\Handlers\Create\SetPassword;
use App\Handlers\Create\SetTitle;
use App\Handlers\Main\MenuHandler;
use App\Handlers\Main\SetPasswordHandler;
use App\Handlers\Main\WaitingPasswordHandler;
use App\Helpers\Chat;

class Start
{
    private const COMMANDS = [
        '/start' => StartCommand::class,
        '/menu'  => MenuCommand::class,
        '/help'  => HelpCommand::class,
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
        $handler = new ($this->getStages()[$chat->stage]);
        $handler->run($dto);
    }

    private function getStages(): array
    {
        return [
            Stage::SetChatPassword->value    => SetPasswordHandler::class,
            Stage::WaitingPassword->value    => WaitingPasswordHandler::class,
            Stage::Menu->value               => MenuHandler::class,
            Stage::SetTitle->value           => SetTitle::class,
            Stage::SetLogin->value           => SetLogin::class,
            Stage::SelectPasswordType->value => SelectPasswordType::class,
            Stage::SetPasswordLen->value     => SelectPasswordLen::class,
            Stage::SetPassword->value        => SetPassword::class,
        ];
    }
}
