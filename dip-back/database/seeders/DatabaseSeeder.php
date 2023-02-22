<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CountrySeeder;
use Database\Seeders\DegreeSeeder;
use Database\Seeders\GroupSeeder;
use Database\Seeders\LanguageSeeder;
use Database\Seeders\OrganizationSeeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\PositionSeeder;
use Database\Seeders\RankSeeder;
use Database\Seeders\TypeSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\AuthorSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,
            DegreeSeeder::class,
            GroupSeeder::class,
            LanguageSeeder::class,
            OrganizationSeeder::class,
            DepartmentSeeder::class,
            PositionSeeder::class,
            RankSeeder::class,
            TypeSeeder::class,
            UserSeeder::class,
            AuthorSeeder::class,
        ]);
    }
}
