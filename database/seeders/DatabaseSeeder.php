<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CountrySeeder;
use Database\Seeders\DegreeSeeder;
use Database\Seeders\SpecialtySeeder;
use Database\Seeders\LanguageSeeder;
use Database\Seeders\OrganizationSeeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\PositionSeeder;
use Database\Seeders\RankSeeder;
use Database\Seeders\TypeSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\AuthorSeeder;
use Database\Seeders\PublisherSeeder;
use Database\Seeders\GlobalSetupSeeder;
use Database\Seeders\PlanSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            GlobalSetupSeeder::class,
            CountrySeeder::class,
            DegreeSeeder::class,
            SpecialtySeeder::class,
            LanguageSeeder::class,
            OrganizationSeeder::class,
            DepartmentSeeder::class,
            PositionSeeder::class,
            RankSeeder::class,
            TypeSeeder::class,
            UserSeeder::class,
            AuthorSeeder::class,
            PublisherSeeder::class,
            PlanSeeder::class
        ]);
    }
}
