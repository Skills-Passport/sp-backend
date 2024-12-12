<?php

namespace Database\Factories;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feedback>
 */
class FeedbackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => "Fake Feedback #{$this->faker->unique()->numberBetween(1, 100)}",
            'content' => $this->faker->text,
            'skill_id' => Skill::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'created_by' => User::inRandomOrder()->first()->id,
        ];
    }
}
