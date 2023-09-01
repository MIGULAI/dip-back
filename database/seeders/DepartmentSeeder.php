<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([[
            'DepartmanName' => 'none',
            'idOrganization' => 1,
        ],[
            'DepartmanName' => 'Кафедра АІС',
            'idOrganization' => 2,
        ],[
            'DepartmanName' => 'ІО центр',
            'idOrganization' => 3,
        ],[
            'DepartmanName' => 'Кафедра ІКС',
            'idOrganization' => 2,
        ]]);
    }
}
