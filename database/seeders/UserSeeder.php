<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([[
            "name" => "superuser",
            "email" => "vitukivan05@gmail.com",
            "password" => Hash::make("qwerty1234")
        ],[
            "name" => "gestuser",
            "email" => "test@test.com",
            "password" => Hash::make("pT60qvYt")
        ]]);
    }
}
