<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FeedbackRequest>
 */
class FeedbackRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomDigitNot(0),
            'skill_id' => $this->faker->randomDigitNot(0),
            'created_by' => $this->faker->randomDigitNot(0),
            'sent_to_email' => $this->faker->email,
        ];
    }
}
