<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface TelegramHandler
{
    public function run(Request $request): void;
}
