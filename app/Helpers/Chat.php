<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Chat
{
    private static ?object $instance = null;

    private function __construct() {}
    protected function __clone() {}

    public static function setInstance(): void
    {
        if (self::$instance === null) {
            self::$instance = self::getChat();
        }
    }

    public static function getInstance(): ?object
    {
        self::setInstance();
        return self::$instance;
    }

    private static function getChat(): ?object
    {
        $hash = request()->input('hash');
        return DB::table('chats')
            ->where('hash', $hash)
            ->first();
    }
}
