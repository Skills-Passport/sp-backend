<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'student' => [
                'name' => 'Student',
                'permissions' => [
                    'view groups',
                    'view skills',
                    'view feedback',
                    'create feedback',
                    'view endorsements',
                    'create endorsements',
                ],
            ],
            'teacher' => [
                'name' => 'Teacher',
                'permissions' => [
                    // Skill permissions
                    'view skills',
                    'create skills',
                    'update skills',
                    'delete skills',

                    // Group permissions
                    'view groups',
                    'create groups',
                    'update groups',
                    'delete groups',

                    // students permissions
                    'view students',

                    // Profile permissions
                    'view profiles',
                    'create profiles',
                    'update profiles',
                    'delete profiles',

                    // Competency permissions
                    'view competencies',
                    'create competencies',
                    'update competencies',
                    'delete competencies',

                    // Requests permissions
                    'view requests',
                    'give feedback',

                    'view feedbacks',
                    'review feedbacks',
                    'give endorsements',
                ],
            ],
            'head-teacher' => [
                'name' => 'Head-teacher',
                'permissions' => [
                    // Skill permissions
                    'view skills',
                    'create skills',
                    'update skills',
                    'delete skills',

                    // Group permissions
                    'view groups',
                    'create groups',
                    'update groups',
                    'delete groups',

                    // students permissions
                    'view students',

                    // Profile permissions
                    'view profiles',
                    'create profiles',
                    'update profiles',
                    'delete profiles',

                    // Competency permissions
                    'view competencies',
                    'create competencies',
                    'update competencies',
                    'delete competencies',

                    // Requests permissions
                    'view requests',
                    'give feedback',

                    'view feedbacks',
                    'review feedbacks',
                    'give endorsements',
                ],
            ],
            'admin' => [
                'name' => 'Admin',
                'permissions' => [
                    // Skill permissions
                    'view skills',
                    'create skills',
                    'update skills',
                    'delete skills',

                    // Group permissions
                    'view groups',
                    'create groups',
                    'update groups',
                    'delete groups',

                    // students permissions
                    'view students',
                    'view all students',

                    // Profile permissions
                    'view profiles',
                    'create profiles',
                    'update profiles',
                    'delete profiles',

                    // Competency permissions
                    'view competencies',
                    'create competencies',
                    'update competencies',
                    'delete competencies',

                    // Requests permissions
                    'view requests',
                    'review requests',

                    // users permissions
                    'view users',
                    'update users',
                    'delete users',

                    'view feedbacks',
                    'review feedbacks',
                    'give endorsements',
                ],
            ],
        ];

        foreach ($roles as $roleData) {
            $role = Role::firstOrCreate(['name' => $roleData['name']]);

            foreach ($roleData['permissions'] as $permissionName) {
                $permission = Permission::firstOrCreate(['name' => $permissionName]);
                $role->givePermissionTo($permission);
            }
        }
    }
}
