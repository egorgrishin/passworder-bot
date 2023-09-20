<?php

namespace App\Tasks;

use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class DisableChats
{
    public function __invoke(): void
    {
        $life_time = config('sess.life_time');
        $inactive_date = Date::now()->subMinutes($life_time)->toDateTimeString();
        DB::table('chats')
            ->where('last_activity_at', '<=', $inactive_date)
            ->where('stage', '<>', 'waiting_password')
            ->update([
                'stage' => 'waiting_password',
            ]);
    }
}
