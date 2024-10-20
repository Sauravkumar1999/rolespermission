<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // User Permissions
            [
                'guard_name'     => 'web',
                'name'           => 'user.create',
                'display_name'   => 'Create User',
                'desc'    => 'Allows the user to create a new user.'
            ],
            [
                'guard_name'     => 'web',
                'name'           => 'user.show',
                'display_name'   => 'View User',
                'desc'    => 'Allows the user to view user details.'
            ],
            [
                'guard_name'     => 'web',
                'name'           => 'user.update',
                'display_name'   => 'Update User',
                'desc'    => 'Allows the user to update user information.'
            ],
            [
                'guard_name'     => 'web',
                'name'           => 'user.delete',
                'display_name'   => 'Delete User',
                'desc'    => 'Allows the user to delete a user.'
            ],
            [
                'guard_name'     => 'web',
                'name'           => 'user.permission.show',
                'display_name'   => 'View User Permissions',
                'desc'    => 'Allows the user to view permissions assigned to a user.'
            ],
            [
                'guard_name'     => 'web',
                'name'           => 'user.permission.update',
                'display_name'   => 'Update User Permissions',
                'desc'    => 'Allows the user to update permissions assigned to a user.'
            ],

            // Role Permissions
            [
                'guard_name'     => 'web',
                'name'           => 'role.create',
                'display_name'   => 'Create Role',
                'desc'    => 'Allows the user to create a new role.'
            ],
            [
                'guard_name'     => 'web',
                'name'           => 'role.show',
                'display_name'   => 'View Role',
                'desc'    => 'Allows the user to view role details.'
            ],
            [
                'guard_name'     => 'web',
                'name'           => 'role.update',
                'display_name'   => 'Update Role',
                'desc'    => 'Allows the user to update role information.'
            ],
            [
                'guard_name'     => 'web',
                'name'           => 'role.delete',
                'display_name'   => 'Delete Role',
                'desc'    => 'Allows the user to delete a role.'
            ],
            [
                'guard_name'     => 'web',
                'name'           => 'role.permission.show',
                'display_name'   => 'View Role Permissions',
                'desc'    => 'Allows the user to view permissions assigned to a role.'
            ],
            [
                'guard_name'     => 'web',
                'name'           => 'role.permission.update',
                'display_name'   => 'Update Role Permissions',
                'desc'    => 'Allows the user to update permissions assigned to a role.'
            ],

            // Permission Permissions
            [
                'guard_name'     => 'web',
                'name'           => 'permission.create',
                'display_name'   => 'Create Permission',
                'desc'    => 'Allows the user to create a new permission.'
            ],
            [
                'guard_name'     => 'web',
                'name'           => 'permission.show',
                'display_name'   => 'View Permission',
                'desc'    => 'Allows the user to view permission details.'
            ],
            [
                'guard_name'     => 'web',
                'name'           => 'permission.update',
                'display_name'   => 'Update Permission',
                'desc'    => 'Allows the user to update permission details.'
            ],
            [
                'guard_name'     => 'web',
                'name'           => 'permission.delete',
                'display_name'   => 'Delete Permission',
                'desc'    => 'Allows the user to delete a permission.'
            ],

            // Schedule Permissions
            [
                'guard_name'     => 'web',
                'name'           => 'schedule.show',
                'display_name'   => 'View Schedule',
                'desc'    => 'Allows the user to view the schedule.'
            ],
            [
                'guard_name'     => 'web',
                'name'           => 'schedule.update',
                'display_name'   => 'Update Schedule',
                'desc'    => 'Allows the user to update the schedule.'
            ],
            [
                'guard_name'     => 'web',
                'name'           => 'schedule.delete',
                'display_name'   => 'Delete Schedule',
                'desc'    => 'Allows the user to delete a schedule entry.'
            ],

            // Translation Permissions
            [
                'guard_name'     => 'web',
                'name'           => 'translations.show',
                'display_name'   => 'View Translations',
                'desc'    => 'Allows the user to view translations.'
            ],
            [
                'guard_name'     => 'web',
                'name'           => 'translations.create',
                'display_name'   => 'Create Translation',
                'desc'    => 'Allows the user to create a new translation.'
            ],
            [
                'guard_name'     => 'web',
                'name'           => 'translations.update',
                'display_name'   => 'Update Translation',
                'desc'    => 'Allows the user to update an existing translation.'
            ],
            [
                'guard_name'     => 'web',
                'name'           => 'translations.delete',
                'display_name'   => 'Delete Translation',
                'desc'    => 'Allows the user to delete a translation.'
            ],
            [
                'guard_name'     => 'web',
                'name'           => 'translations.change',
                'display_name'   => 'Change Translation',
                'desc'    => 'Allows the user to change translation settings.'
            ],

            // Chat Permissions
            [
                'guard_name'     => 'web',
                'name'           => 'chat.show',
                'display_name'   => 'View Chat',
                'desc'    => 'Allows the user to view chat messages.'
            ],
            [
                'guard_name'     => 'web',
                'name'           => 'chat.create',
                'display_name'   => 'Create Chat',
                'desc'    => 'Allows the user to create a new chat.'
            ],
        ];


        foreach ($permissions as $permission) {
            Permission::updateOrInsert(
                [
                    'guard_name'   => $permission['guard_name'],
                    'name'         => $permission['name'],
                    'display_name' => $permission['display_name'],
                    'desc'         => $permission['desc']
                ],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
