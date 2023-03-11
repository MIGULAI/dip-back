<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('specialties')->insert([[
            'SpecialtyName' => 'none',
        ],[
            'SpecialtyName' => 'КН-18-1',
        ],[
            'SpecialtyName' => 'КН-19-1',
        ],[
            'SpecialtyName' => 'КН-20-1',
        ],[
            'SpecialtyName' => 'КН-21-1',
        ],[
            'SpecialtyName' => 'АКІТ-18-2',
        ],[
            'SpecialtyName' => 'КІП-21-2м',
        ],[
            'SpecialtyName' => 'АКІТ-21-2с',
        ]]);
    }
}
