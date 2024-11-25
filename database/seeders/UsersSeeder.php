<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
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
      $user = User::firstOrCreate([
        'first_name' => strtoupper($name),
        'email' => $email,
        'password' => Hash::make('password'),
      ]);
      $user->assignRole(Role::find(['name' => $role]));
    } catch (UniqueConstraintViolationException $e) {
      $user = User::where('email', $email)->first();
    }
    $user->assignRole($role);
  }
}
