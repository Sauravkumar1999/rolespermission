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
            ['guard_name' => 'web', 'name' => 'user.create'],
            ['guard_name' => 'web', 'name' => 'user.show'],
            ['guard_name' => 'web', 'name' => 'user.update'],
            ['guard_name' => 'web', 'name' => 'user.delete'],
            ['guard_name' => 'web', 'name' => 'user.permission.show'],
            ['guard_name' => 'web', 'name' => 'user.permission.update'],

            // Role Permissions
            ['guard_name' => 'web', 'name' => 'role.create'],
            ['guard_name' => 'web', 'name' => 'role.show'],
            ['guard_name' => 'web', 'name' => 'role.update'],
            ['guard_name' => 'web', 'name' => 'role.delete'],
            ['guard_name' => 'web', 'name' => 'role.permission.show'],
            ['guard_name' => 'web', 'name' => 'role.permission.update'],

            // Permission Permissions
            ['guard_name' => 'web', 'name' => 'permission.create'],
            ['guard_name' => 'web', 'name' => 'permission.show'],
            ['guard_name' => 'web', 'name' => 'permission.edit'],
            ['guard_name' => 'web', 'name' => 'permission.delete'],

            // Schedule Permissions
            ['guard_name' => 'web', 'name' => 'schedule.update'],
            ['guard_name' => 'web', 'name' => 'schedule.delete'],

            // Translation Permissions
            ['guard_name' => 'web', 'name' => 'translations.show'],
            ['guard_name' => 'web', 'name' => 'translations.create'],
            ['guard_name' => 'web', 'name' => 'translations.update'],
            ['guard_name' => 'web', 'name' => 'translations.delete'],
            ['guard_name' => 'web', 'name' => 'translations.change'],

            // Chat Permissions
            ['guard_name' => 'web', 'name' => 'chat.show'],
            ['guard_name' => 'web', 'name' => 'chat.create'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrInsert(
                ['guard_name' => $permission['guard_name'], 'name' => $permission['name']],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
