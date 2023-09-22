<?php

namespace App\Handlers;

use App\Contracts\TelegramHandler;
use App\Enums\MenuButton;
use Illuminate\Http\Request;

class MenuHandler implements TelegramHandler
{
    public function run(Request $request): void
    {
        $command = $request->input('message.text');
        if ($command === MenuButton::Add->value) {

        }
    }

//    private function handleAdd()
//    {
//
//    }
}
