<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            'Course/Programme',
            'Internship',
            'Workshop',
            'Seminar',
            'Conference',
            'Group project',
            'Hackathon',
            'Competition',
            'Exhibition',
            'Presentation',
            'Symposium',
        ];
        foreach ($events as $event) {
            Event::firstOrCreate(['title' => $event]);
        }
    }
}
