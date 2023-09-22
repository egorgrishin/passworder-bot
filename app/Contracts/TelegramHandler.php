<?php

namespace App\Contracts;

use App\Dto;

interface TelegramHandler
{
    public function run(Dto $dto): void;
}
