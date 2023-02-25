<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class GlobalSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('global_setups')->insert([[
            'SetupName' => 'authorsPublCount',
            'SetupValue' => '7'
        ],[
            'SetupName' => 'authoSuccess',
            'SetupValue' => 'false'
        ],[
            'SetupName' => 'thesesNumber',
            'SetupValue' => '1',
        ],[
            'SetupName' => 'thesesYears',
            'SetupValue' => '1',
        ],[
            'SetupName' => 'paNumber',
            'SetupValue' => '1',
        ],[
            'SetupName' => 'paYears',
            'SetupValue' => '1',
        ],[
            'SetupName' => 'scopusNumber',
            'SetupValue' => '1',
        ],[
            'SetupName' => 'scopusYears',
            'SetupValue' => '3',
        ],[
            'SetupName' => 'manualsNumber',
            'SetupValue' => '1',
        ],[
            'SetupName' => 'manualsYears',
            'SetupValue' => '5',
        ]]);
    }
}
