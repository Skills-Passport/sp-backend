<?php

namespace Database\Factories;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Endorsement>
 */
class EndorsementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'title' => "Fake Endorsement #{$this->faker->unique()->numberBetween(1, 100)}",
            'skill_id' => Skill::inRandomOrder()->first()->id,
            'content' => $this->faker->sentence,
            'rating' => $this->faker->numberBetween(1, 4),
            'created_by' => User::inRandomOrder()->first()->id,
            'created_by_email' => null,
            'approved_at' => $this->faker->dateTimeThisYear,
        ];
    }
}
