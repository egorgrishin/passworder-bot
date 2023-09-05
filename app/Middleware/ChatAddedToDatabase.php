<?php

namespace App\Middleware;

use App\Exceptions\AddingChatError;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Throwable;

class ChatAddedToDatabase
{
    /**
     * Handle an incoming request.
     * @throws AddingChatError
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $chat_id = $request->input('message.chat.id');
        if ($this->chatAddedToDatabase($chat_id)) {
            return $next($request);
        }

        try {
            $chat_added = $this->addChatToDatabase($chat_id);
        } catch (Throwable) {
            $chat_added = false;
        }

        if ($chat_added) {
            throw new AddingChatError($chat_id);
        }

        return $next($request);
    }

    private function chatAddedToDatabase(int $chat_id): bool
    {
        return DB::table('chats')
            ->where('hashed_chat_id', Hash::make($chat_id))
            ->exists();
    }

    private function addChatToDatabase(int $chat_id): bool
    {
        return DB::table('chats')->insert([
            'uuid'           => $this->getUuid(),
            'hashed_chat_id' => Hash::make($chat_id),
        ]);
    }

    private function getUuid(): string
    {
        do {
            $uuid = Str::uuid()->toString();
        } while ($this->uuidIsBusy($uuid));
        return $uuid;
    }

    private function uuidIsBusy(string $uuid): bool
    {
        return DB::table('chats')
            ->where('uuid', $uuid)
            ->exists();
    }
}
