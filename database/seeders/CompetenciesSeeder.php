<?php

namespace Database\Seeders;

use App\Models\Competency;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Profile;
use Illuminate\Database\UniqueConstraintViolationException;

class CompetenciesSeeder extends Seeder
{
  public function run(): void
  {
    $competencies = ['Design', 'Realize', 'Analyze', 'Manage', 'Advise', 'Management', 'Research'];
    foreach ($competencies as $competency) {
      Competency::firstOrCreate(['title' => $competency, 'overview' => 'A competency is a set of defined behaviors that provide a structured guide enabling the identification, evaluation and development of the behaviors in individual employees.', 'desc' => 'A competency is a set of defined behaviors']);
    }
  }
}
