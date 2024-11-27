<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = ['student', 'teacher', 'head-teacher', 'admin'];
        foreach ($users as $user) {
            $this->createUserWithRole($user, $user.'@sp', $user);
        }
    }

    public function createUserWithRole($name, $email, $role)
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
