<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;

class UsersSeeder extends Seeder
{
  public function run(): void
  {
    $users = ['student', 'teacher', 'head-teacher', 'admin'];
    foreach ($users as $user) {
      $this->createUserWithRole($user, $user . '@sp', $user);
    }
  }
  function createUserWithRole($name, $email, $role)
  {
    try {
      $user = User::firstOrCreate(['first_name' => strtoupper($name), 'email' => $email, 'password' => bcrypt('password')] + ['role_id' => Role::where('name', $role)->first()->id]);
    } catch (UniqueConstraintViolationException $e) {
      $user = User::where('email', $email)->first();
    }
    $user->assignRole($role);
  }
}
