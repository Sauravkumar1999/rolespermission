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
        Permission::insert([
            ['guard_name' => 'web', 'name' => 'user.create'],
            ['guard_name' => 'web', 'name' => 'user.show'],
            ['guard_name' => 'web', 'name' => 'user.edit'],
            ['guard_name' => 'web', 'name' => 'user.delete'],
            ['guard_name' => 'web', 'name' => 'user.premission.show'],
            ['guard_name' => 'web', 'name' => 'user.permission.update'],

            ['guard_name' => 'web', 'name' => 'role.create'],
            ['guard_name' => 'web', 'name' => 'role.show'],
            ['guard_name' => 'web', 'name' => 'role.edit'],
            ['guard_name' => 'web', 'name' => 'role.delete'],
            ['guard_name' => 'web', 'name' => 'role.permission.show'],
            ['guard_name' => 'web', 'name' => 'role.permission.update'],

            ['guard_name' => 'web', 'name' => 'permission.create'],
            ['guard_name' => 'web', 'name' => 'permission.show'],
            ['guard_name' => 'web', 'name' => 'permission.edit'],
            ['guard_name' => 'web', 'name' => 'permission.delete'],
        ]);
    }
}
