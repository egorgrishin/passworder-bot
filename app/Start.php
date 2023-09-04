<?php

namespace App;

use Illuminate\Http\Client\Factory;
use Illuminate\Http\Response;

class Start
{
    public function start(): Response
    {
        $url = 'https://api.telegram.org/';
        $bot = 'bot6521726004:AAHh86wPhEu2tg_DJethX90BxmOq4BUw5ks/';
        (new Factory())->post($url . $bot . 'sendMessage', [
            'chat_id' => '935824965',
            'text' => 'Hi!',
        ]);

        return response();
    }
}
