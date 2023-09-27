<?php

namespace App\Helpers;

use App\Dto;
use App\Enums\Stage;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class Chat
{
    private static ?object $original = null;
    private static ?object $attributes = null;

    private function __construct() {}
    protected function __clone() {}

    public static function setInstance(string $hash): bool
    {
        if (self::$original === null) {
            self::$attributes = self::getChat($hash);
            self::$original = self::getChat($hash);
        }

        return self::$original !== null;
    }

    public static function getInstance(): ?object
    {
        return self::$original;
    }

    private static function getChat(string $hash): ?object
    {
        return DB::table('chats')
            ->where('hash', $hash)
            ->first();
    }

    public static function setStage(Stage $stage): void
    {
        self::$attributes->stage = $stage->value;
    }

    public static function setOutgoingMessageId(int $message_id): void
    {
        self::$attributes->outgoing_message_id = $message_id;
    }

    public static function commitChanges(Dto $dto): void
    {
        $changes = [
            'last_activity_at' => Date::now()->toDateTimeString(),
        ];

        foreach ((array) self::$attributes as $key => $value) {
            if (self::$original->$key != $value) {
                $changes[$key] = $value;
            }
        }

        DB::table('chats')
            ->where('hash', $dto->hash)
            ->update($changes);
    }
}
