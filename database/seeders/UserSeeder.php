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
            array_merge($this->getCommonUserData(), ['name' => 'Admin Admin'])
        );

        $user = User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            array_merge($this->getCommonUserData(), ['name' => fake()->name()])
        );

        $admin->syncRoles('admin')->syncPermissions(Permission::pluck('name'));
        Role::findByName('admin')->syncPermissions(Permission::pluck('name'));

        $chatPermissions = Permission::whereIn('name', ['chat.show', 'chat.create'])->pluck('name');

        $user->syncRoles('user')->syncPermissions($chatPermissions);

        User::factory(40)->create();
    }

    private function getCommonUserData(): array
    {
        return [
            'email_verified_at' => now(),
            'phone'             => fake()->unique()->phoneNumber(),
            'profile'           => fake()->imageUrl(200, 200, 'people', true),
            'status'            => 1,
            'password'          => Hash::make('password'),
        ];
    }
}
