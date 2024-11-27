<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'desc' => $this->faker->sentence,
            'created_by' => User::inRandomOrder()->first()->id,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Group $group) {
            $skills = Skill::inRandomOrder()->limit(random_int(1, 5))->get();
            $group->skills()->attach($skills);

            $students = User::where('id', '!=', $group->created_by)
                ->inRandomOrder()
                ->limit(random_int(1, 5))
                ->get();
            foreach ($students as $student) {
                $group->students()->attach($student->id, ['role' => 'student']);
            }
            $creator = User::find($group->created_by);
            if ($creator) {
                $group->teachers()->attach($creator->id, ['role' => 'teacher']);
            }
        });
    }
}
