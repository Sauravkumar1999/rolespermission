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
        Role::insert([
            ['guard_name' => 'web', 'name' => 'admin', 'display_name' => 'Admin'],
            ['guard_name' => 'web', 'name' => 'user', 'display_name' => 'User'],
        ]);
    }
}
