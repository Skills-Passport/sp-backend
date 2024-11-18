<?php

namespace Database\Factories;

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
            'user_id' => $this->faker->randomNumber(),
            'skill_id' => $this->faker->randomNumber(),
            'content' => $this->faker->sentence,
            'rating' => $this->faker->randomNumber(),
            'created_by' => $this->faker->randomNumber(),
            'created_by_email' => $this->faker->email,
            'is_approved' => $this->faker->boolean,
        ];
    }
}
