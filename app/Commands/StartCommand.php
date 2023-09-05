<?php

namespace App\Commands;

use App\Contracts\CommandInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StartCommand implements CommandInterface
{
    public function run(Request $request): JsonResponse
    {
        $chat_id = $request->input('message.chat.id');
        if (!$chat_id) {
            return response()->json();
        }

        $this->addChatToDatabase($chat_id);

        Log::debug($request->all());
        $url = 'https://api.telegram.org/';
        $bot = 'bot6521726004:AAHh86wPhEu2tg_DJethX90BxmOq4BUw5ks/';
        Http::post($url . $bot . 'sendMessage', [
            'chat_id' => '935824965',
            'text' => 'Is a start command',
        ]);
        return response()->json();
    }

    private function addChatToDatabase(int $chat_id): void
    {
        DB::table('chats')->insert([
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
