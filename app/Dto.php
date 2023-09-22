<?php

namespace App;

use App\Helpers\Hasher;
use Illuminate\Http\Request;

readonly class Dto
{
    public int $chat_id;
    public string $hash;
    public string $data;

    public static function make(Request $request): self
    {
        $dto = new self();
        if (self::isCommonMessage($request)) {
            $dto->chat_id = $request->input('message.chat.id');
            $dto->data = $request->input('message.text', '');
        } else {
            $dto->chat_id = $request->input('callback_query.from.id');
            $dto->data = $request->input('callback_query.data');
        }

        $dto->hash = Hasher::make($dto->chat_id);
        return $dto;
    }

    private static function isCommonMessage(Request $request): bool
    {
        return $request->has('message.chat.id');
    }
}
