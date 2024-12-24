<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'student' => [
                'name' => 'student',
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
                'name' => 'teacher',
                'permissions' => [
                    'view groups',
                    'view skills',
                    'create skills',
                    'edit skills',
                    'delete skills',
                    'view feedbacks',
                    'review feedbacks',
                    'give endorsements',
                    'view students',
                    'view teachers',
                    'create groups',
                    'edit groups',
                    'delete groups',
                ],
            ],
            'head-teacher' => [
                'name' => 'head-teacher',
                'permissions' => [
                    'view groups',
                    'view skills',
                    'create skills',
                    'edit skills',
                    'delete skills',
                    'view feedbacks',
                    'review feedbacks',
                    'give endorsements',
                    'view students',
                    'view teachers',
                    'create groups',
                    'edit groups',
                    'delete groups',
                    'add students',
                    'add teachers',
                ],
            ],
            'admin' => [
                'name' => 'admin',
                'permissions' => [
                    'view groups',
                    'view skills',
                    'view feedback',
                    'create feedback',
                    'view endorsements',
                    'create endorsements',
                    'view students',
                    'view teachers',
                    'create groups',
                    'edit groups',
                    'delete groups',
                    'add students',
                    'add teachers',
                    'view users',
                    'create users',
                    'edit users',
                    'delete users',
                    'view roles',
                    'create roles',
                    'edit roles',
                    'delete roles',
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
