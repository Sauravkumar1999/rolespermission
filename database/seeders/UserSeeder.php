<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Admin',
                'email_verified_at' => now(),
                'phone' => fake()->unique()->phoneNumber(),
                'profile' => fake()->imageUrl(200, 200, 'people', true),
                'status' => 1,
                'password' => Hash::make('password'),
            ]
        );
        $admin->syncRoles(['admin']);

        $admin->syncPermissions(Permission::all()->pluck('name'));
        $adminRole = Role::findByName('admin');
        $adminRole->syncPermissions(Permission::all()->pluck('name'));
        User::factory(40)->create();
    }
}
