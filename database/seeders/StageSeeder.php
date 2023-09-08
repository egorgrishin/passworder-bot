<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stages')->insert([
            /* 1  */ ['code' => 'start'],
            /* 2  */ ['code' => 'set_password'],
            /* 3  */ ['code' => 'menu', 'is_default' => true],
            /* 4  */ ['code' => 'add_data'],
            /* 5  */ ['code' => 'write_resource_name'],
            /* 6  */ ['code' => 'write_first_data'],
            /* 7  */ ['code' => 'write_second_data'],
            /* 8  */ ['code' => 'success_adding'],
//            /* 9  */ ['code' => 'add_new_phone_number'],
//            /* 10 */ ['code' => 'write_id'],
//            /* 11 */ ['code' => 'start'],
//            /* 12 */ ['code' => 'start'],
//            /* 13 */ ['code' => 'start'],
//            /* 14 */ ['code' => 'start'],
//            /* 15 */ ['code' => 'start'],
//            /* 16 */ ['code' => 'start'],
//            /* 17 */ ['code' => 'start'],
//            /* 18 */ ['code' => 'start'],
//            /* 19 */ ['code' => 'start'],
//            /* 20 */ ['code' => 'start'],
        ]);
    }
}
