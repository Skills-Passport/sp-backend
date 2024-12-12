<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EndorsementRequest>
 */
class EndorsementRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'skill_id' => 1,
            'created_by' => 1,
            'sent_to_email' => $this->faker->email,
            'is_approved' => false,
            'data' => [
                'content' => "Fake Endorsement Request #{$this->faker->unique()->numberBetween(1, 100)}",
                'rating' => $this->faker->numberBetween(1, 5),
                'questions' => [
                    [
                        'question' => $this->faker->sentence,
                        'answer' => $this->faker->sentence,
                    ],
                    [
                        'question' => $this->faker->sentence,
                        'answer' => $this->faker->sentence,
                    ],
                    [
                        'question' => $this->faker->sentence,
                        'answer' => $this->faker->sentence,
                    ],
                ],
            ],
        ];
    }
}
