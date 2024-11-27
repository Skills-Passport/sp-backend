<?php

namespace Database\Seeders;

use App\Models\Competency;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class CompetenciesSeeder extends Seeder
{
    public function run(): void
    {
        $competencies = ['Design', 'Realize', 'Analyze', 'Manage', 'Advise', 'Management', 'Research'];
        $competency_profiles = [
            'Design' => ['innovator', 'director', 'technologist'],
            'Realize' => ['technologist', 'director'],
            'Analyze' => ['analyst', 'director'],
            'Manage' => ['innovator', 'director'],
            'Advise' => ['technologist', 'director'],
            'Management' => ['innovator', 'director'],
            'Research' => ['technologist', 'director'],
        ];

        foreach ($competencies as $competency) {
            $comp = Competency::firstOrCreate(['title' => $competency, 'overview' => 'A competency is a set of defined behaviors that provide a structured guide enabling the identification, evaluation and development of the behaviors in individual employees.', 'desc' => 'A competency is a set of defined behaviors']);

            $comp->profiles()->attach(Profile::whereIn('title', $competency_profiles[$competency])->get());
        }
    }
}
