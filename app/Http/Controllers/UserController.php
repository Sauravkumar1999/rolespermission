<?php

namespace App\Http\Controllers;

use App\DataTables\Editor\PermissionDataTableEditor;
use App\DataTables\Editor\RoleDataTableEditor;
use App\DataTables\Editor\UserDatatableEditor;
use App\DataTables\TableView\PermissionDataTable;
use App\DataTables\TableView\RoleDataTable;
use App\DataTables\TableView\UserDataTable;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function user(UserDataTable $datatable)
    {
        return $datatable->render('dashboard.users.user', ['pageTitle' => trans('user.user')]);
    }

    public function process(Request $request, UserDatatableEditor $editor)
    {
        return $editor->process($request);
    }

    public function role(RoleDataTable $datatable)
    {
        return $datatable->render('dashboard.users.role', ['pageTitle' => trans('role.role')]);
    }

    public function roleProcess(Request $request, RoleDataTableEditor $editor)
    {
        return $editor->process($request);
    }

    public function permission(PermissionDataTable $datatable)
    {
        return $datatable->render('dashboard.users.permission', ['pageTitle' => trans('permission.permission')]);
    }

    public function permissionProcess(Request $request, PermissionDataTableEditor $editor)
    {
        return $editor->process($request);
    }

    public function permissionRoleAll($id)
    {
        $role = Role::findOrFail($id);
        if ($role) {
            $data = mergePermission($this->userService->permissionRoleGroup($role), $this->userService->permissionAll());
            return response()->json(['data' => $data, 'status' => true], 200);
        }
        return response()->json(['status' => false], 200);
    }

    public function permissionRoleUpdate(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        if ($role) {
            $permissionIds = collect($request->all())
                ->where('isChecked', true)
                ->pluck('permissionId');
            $role->permissions()->sync($permissionIds);
            return response()->json(['status' => true], 200);
        }
        return response()->json(['status' => false], 200);
    }

    public function permissionAll($id)
    {
        $user = User::findOrFail($id);
        if ($user) {
            $data = mergePermission($this->userService->permissionGroup($user), $this->userService->permissionAll());
            return response()->json(['data' => $data, 'status' => true], 200);
        }
        return response()->json(['status' => false], 200);
    }

    public function permissionUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user) {
            $permissionIds = collect($request->all())
                ->where('isChecked', true)
                ->pluck('permissionId');
            $user->permissions()->sync($permissionIds);
            return response()->json(['status' => true], 200);
        }
        return response()->json(['status' => false], 200);
    }

    public function Profile()
    {
        $user = Auth::user();
        return view('dashboard.users.profile')->with('user', $user);
    }
}
