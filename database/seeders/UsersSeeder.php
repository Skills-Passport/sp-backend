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
        $users = [
            [
                'name' => [
                    'first_name' => 'Mr',
                    'last_name' => 'Student',
                ],
                'email' => 'student@sp.nl',
                'role' => 'Student',
                'password' => 'password',
            ],
            [
                'name' => [
                    'first_name' => 'Mr',
                    'last_name' => 'Student2',
                ],
                'email' => 'std2@sp.nl',
                'role' => 'Student',
                'password' => 'password',
            ],
            [
                'name' => [
                    'first_name' => 'Mr',
                    'last_name' => 'Student3',
                ],
                'email' => 'std3@sp.nl',
                'role' => 'Student',
                'password' => 'password',
            ],
            [
                'name' => [
                    'first_name' => 'Mr',
                    'last_name' => 'Teacher',
                ],
                'email' => 'teacher@sp.nl',
                'role' => 'Teacher',
                'password' => 'password',
            ],
            [
                'name' => [
                    'first_name' => 'Ms',
                    'last_name' => 'Marit',
                ],
                'email' => 'marit@sp.nl',
                'role' => 'Teacher',
                'password' => 'happylearning',
            ],
            [
                'name' => [
                    'first_name' => 'Ms',
                    'last_name' => 'Mirjam',
                ],
                'email' => 'mirjam@sp.nl',
                'role' => 'Teacher',
                'password' => 'happylearning',
            ],
            [
                'name' => [
                    'first_name' => 'Mr',
                    'last_name' => 'Admin',
                ],
                'email' => 'admin@sp.nl',
                'role' => 'Admin',
                'password' => 'password',
            ],
            [
                'name' => [
                    'first_name' => 'Mr',
                    'last_name' => 'HeadTeacher',
                ],
                'email' => 'headTeacher@sp.nl',
                'role' => 'Head-teacher',
                'password' => 'password',
            ],
        ];

        foreach ($users as $user) {
            $this->createUserWithRole($user['name'], $user['email'], $user['role'], $user['password']);
        }
    }

    public function createUserWithRole($name, $email, $role, $password): void
    {
        try {
            $user = User::firstOrCreate([
                'first_name' => $name['first_name'],
                'last_name' => $name['last_name'],
                'job_title' => $role,
                'email' => $email,
                'password' => Hash::make($password),
                'image' => 'https://xsgames.co/randomusers/avatar.php?g=male',
            ]);
            $user->assignRole(Role::find(['name' => $role]));
        } catch (UniqueConstraintViolationException $e) {
            $user = User::where('email', $email)->first();
        }
        $user->assignRole($role);
    }
}
