<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\UniqueConstraintViolationException;

class ProfilesSeeder extends Seeder
{
  public function run(): void
  {
    $profiles = ['technologist', 'director', 'innovator', 'analyst'];
    $icons = [
      'technologist' => 'CpuIcon',
      'director' => 'BriefcaseIcon',
      'innovator' => 'LightBulbIcon',
      'analyst' => 'ChartBarIcon'
    ];
    $description = [
      'technologist' => 'A technologist is a professional who is skilled in the use of technology to solve problems and complete tasks.',
      'director' => 'A director is a person who is responsible for the activities of a company or organization.',
      'innovator' => 'An innovator is a person who introduces new methods, ideas, or products.',
      'analyst' => 'An analyst is a person who is skilled in the use of data to solve problems and make decisions.'
    ];
    foreach ($profiles as $profile) {
      Profile::firstOrCreate(['title' => $profile, 'desc' => $description[$profile], 'icon' => $icons[$profile], 'created_by' => User::first()->id]);
    }
  }
}
