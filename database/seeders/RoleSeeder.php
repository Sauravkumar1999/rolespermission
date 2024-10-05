<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['guard_name' => 'web', 'name' => 'admin', 'display_name' => 'Admin'],
            ['guard_name' => 'web', 'name' => 'user', 'display_name' => 'User'],
        ];
        foreach ($roles as $role) {
            Role::updateOrInsert(
                ['guard_name' => $role['guard_name'], 'name' => $role['name']],
                [
                    'display_name' => $role['display_name'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
