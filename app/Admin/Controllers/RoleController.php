<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\AdminUser;
use App\AdminRole;
use App\AdminPermission;

class RoleController extends Controller
{
    public function index() {
        $roles = AdminRole::paginate(10);
        return view('admin.role.index', compact('roles'));
    }

    public function create() {
        return view('admin.role.create');
    }

    public function store() {
        $this->validate(request(), [
            'name' => 'required|min:3',
            'description' => 'required'
        ]);

        AdminRole::create(request(['name', 'description']));
        return redirect('admin/roles');
    }

    public function permission(AdminRole $role) {
        $permissions = AdminPermission::all();
        $myPermissions = $role->permissions;

        return view('admin.role.permission', compact('permissions', 'myPermissions', 'role'));
    }

    public function permissionStore(AdminRole $role) {
        $this->validate(request(), [
            'permissions' => 'required|array'
        ]);

        $permissions = AdminPermission::findMany(request('permissions'));
        $myPermissions = $role->permissions;

        $addPermissions = $permissions->diff($myPermissions);
        foreach($addPermissions as $permission) {
            $role->grantPermission($permission);
        }

        $removePermissions = $myPermissions->diff($permissions);
        foreach($removePermissions as $permission) {
            $role->deletePermission($permission);
        }

//        return back();
        return redirect('admin/roles');
    }
}