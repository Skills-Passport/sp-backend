<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProfilesSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = ['Technologist', 'Director', 'Innovator', 'Analyst'];
        $icons = [
            'Technologist' => 'MonitorCog',
            'Director' => 'Clapperboard',
            'Innovator' => 'Lightbulb',
            'Analyst' => 'ChartLine',
        ];
        $description = [
            'Technologist' => 'A technologist is a professional who is skilled in the use of technology to solve problems and complete tasks.',
            'Director' => 'A director is a person who is responsible for the activities of a company or organization.',
            'Innovator' => 'An innovator is a person who introduces new methods, ideas, or products.',
            'Analyst' => 'An analyst is a person who is skilled in the use of data to solve problems and make decisions.',
        ];
        $colors = [
            'Technologist' => '#daeaf6',
            'Director' => '#daf1e5',
            'Innovator' => '#fce0e6',
            'Analyst' => '#f1f5c9',
        ];
        foreach ($profiles as $profile) {
            Profile::firstOrCreate(['title' => $profile, 'desc' => $description[$profile], 'icon' => $icons[$profile], 'created_by' => User::first()->id], ['color' => $colors[$profile]]);
        }
    }
}
