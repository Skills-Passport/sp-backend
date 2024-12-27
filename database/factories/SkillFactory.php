<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Competency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Skill>
 */
class SkillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => "Fake Skill #{$this->faker->unique()->numberBetween(1, 100)}",
            'desc' => $this->faker->sentence,
            'competency_id' => Competency::inRandomOrder()->first()->id,
            'created_by' => User::inRandomOrder()->first()->id,
        ];
    }
}
