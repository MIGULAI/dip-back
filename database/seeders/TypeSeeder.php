<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('types')->insert([[
            'TypeName' => 'Теза',
            'TypeShortName' => 'ТДК'
        ],[
            'TypeName' => 'Фахова стаття',
            'TypeShortName' => 'СТ'
        ],[
            'TypeName' => 'Scopus',
            'TypeShortName' => 'SW'
        ],[
            'TypeName' => 'Посібник',
            'TypeShortName' => 'ПМ'
        ]]);
    }
}
