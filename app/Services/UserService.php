<?php

namespace App\Services;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserService
{
    public function permissionGroup(User $user)
    {
        if ($user && $user->permissions()->count() > 0) {
            $permissions = $user->permissions()->get();
            return $permissions;
        }
        return collect([]);
    }

    public function permissionRoleGroup(Role $role)
    {
        // dd($role->permissions()->count());
        if ($role && $role->permissions()->count() > 0) {
            $permissions = $role->permissions()->get();
            return $permissions;
        }
        return collect([]);
    }

    public function permissionAll()
    {
        return Permission::all();
    }
}
