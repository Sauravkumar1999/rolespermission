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
        $admin = User::create([
            'name' => 'Admin Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'phone' => fake()->unique()->phoneNumber(),
            'profile' => fake()->imageUrl(200, 200, 'people', true),
            'status' => 1,
            'password' => Hash::make('password'),
        ]);
        $adminrole = Role::first();
        User::factory(40)->create();
        // $admin->givePermissionTo(
        //     Permission::all()->pluck('name')
        // );
        $admin->assignRole(Role::first());
        $adminrole->givePermissionTo(
            Permission::all()->pluck('name')
        );
    }
}
