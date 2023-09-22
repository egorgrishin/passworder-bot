<?php

namespace App\Contracts;

use App\Dto;

interface CommandInterface
{
    public function run(Dto $dto);
}
