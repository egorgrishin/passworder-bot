<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Chat
{
    private static ?object $original = null;
    private static ?object $attributes = null;

    private function __construct() {}
    protected function __clone() {}

    public static function setInstance(): void
    {
        if (self::$original === null) {
            self::$attributes = self::$original = self::getChat();
        }
    }

    public static function getInstance(): ?object
    {
        self::setInstance();
        return self::$original;
    }

    private static function getChat(): ?object
    {
        $hash = request()->input('hash');
        return DB::table('chats')
            ->where('hash', $hash)
            ->first();
    }

    public static function setStage(string $stage): void
    {
        self::$attributes->stage = $stage;
    }
}
