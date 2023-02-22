<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('positions')->insert([[
            'PositionName' => 'none'
        ],[
            'PositionName' => 'студент'
        ],[
            'PositionName' => 'аспірант'
        ],[
            'PositionName' => 'старший викладач'
        ],[
            'PositionName' => 'доцент'
        ],[
            'PositionName' => 'професор'
        ]]);
    }
}
