<?php

namespace App\Exceptions;

use Exception;

class TelegramException extends Exception
{
    public function __construct(
        protected int $chat_id,
    ) {
        parent::__construct();
    }
}
