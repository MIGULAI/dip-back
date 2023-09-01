<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('degrees')->insert([[
            'DegreeName' => 'none',
        ],[
            'DegreeName' => 'д.пед.н.',
        ],[
            'DegreeName' => 'д.техн.н.',
        ],[
            'DegreeName' => 'к.пед.н.',
        ],[
            'DegreeName' => 'к.техн.н.',
        ]]);
    }
}