<?php

namespace App\Exceptions;

use App\Dto;
use Exception;

abstract class TelegramException extends Exception
{
    public function __construct(
        protected Dto $dto,
    ) {
        parent::__construct();
    }

    abstract public function sendMessage(): void;
}
