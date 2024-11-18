<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $icons = ['LightBulbIcon', 'UserIcon', 'CogIcon', 'AcademicCapIcon', 'BriefcaseIcon', 'ChatAltIcon', 'CodeIcon', 'DocumentTextIcon', 'MailIcon', 'PhoneIcon'];

        return [
            'title' => $this->faker->sentence,
            'desc' => $this->faker->paragraph,
            'created_by' => 1,
            'icon' => $this->faker->randomElement($icons),
        ];
    }
}
