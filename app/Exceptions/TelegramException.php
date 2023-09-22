<?php

namespace App\Exceptions;

use Exception;

abstract class TelegramException extends Exception
{
    public function __construct(
        protected int $chat_id,
    ) {
        parent::__construct();
    }

    abstract public function sendMessage(): void;
}
