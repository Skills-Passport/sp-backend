<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;
use Database\Seeders\RolesSeeder;
use Database\Seeders\UsersSeeder;
use Database\Seeders\ProfilesSeeder;
use Database\Seeders\CompetenciesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Question::factory(10)->create();
        
        $this->call([
            RolesSeeder::class,
            UsersSeeder::class,
            ProfilesSeeder::class,
            CompetenciesSeeder::class,
        ]);
    }
}
