<?php

namespace Database\Seeders;

// use Database\Seeders\Userseeder;
use Database\Seeders\CompanyProfileSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call(Userseeder::class);
        // $this->call(CompanyProfileSeeder::class);
        $this->call(SphSettingsSeeder::class);
    }
}
