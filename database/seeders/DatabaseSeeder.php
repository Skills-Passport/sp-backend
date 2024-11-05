<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;
use Database\Seeders\UsersSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Question::factory(10)->create();
        
        $this->call([
            rolesSeeder::class,
            UsersSeeder::class,
            ProfilesSeeder::class,
            CompetenciesSeeder::class,
        ]);
    }
}
