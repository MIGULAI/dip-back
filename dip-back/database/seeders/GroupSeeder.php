<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('groups')->insert([[
            'GroupName' => 'none',
        ],[
            'GroupName' => 'КН-18-1',
        ],[
            'GroupName' => 'КН-19-1',
        ],[
            'GroupName' => 'КН-20-1',
        ],[
            'GroupName' => 'КН-21-1',
        ],[
            'GroupName' => 'АКІТ-18-2',
        ],[
            'GroupName' => 'КІП-21-2м',
        ],[
            'GroupName' => 'АКІТ-21-2с',
        ]]);
    }
}
