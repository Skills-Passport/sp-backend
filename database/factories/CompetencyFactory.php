<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Competency>
 */
class CompetencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => "Fake Competency #{$this->faker->unique()->numberBetween(1, 100)}",
            'desc' => $this->faker->sentence,
            'overview' => $this->faker->paragraph,
        ];
    }
}
