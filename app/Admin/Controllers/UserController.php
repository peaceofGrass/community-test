<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\AdminUser;
use App\AdminRole;

class UserController extends Controller
{
    public function index() {
        $users = AdminUser::paginate(10);
        return view('admin.user.index', compact('users'));
    }

    public function create() {
        return view('admin.user.create');
    }

    public function store() {
        $this->validate(request(), [
            'name' => 'required|min:3',
            'password' => 'required|min:6|max:20'
        ]);

        $name = request('name');
        $password = bcrypt(request('password'));

        AdminUser::create(compact('name', 'password'));
        return redirect('/admin/users');
    }

    public function role(AdminUser $user) {
        $roles = \App\AdminRole::all();
        $myRoles = $user->roles;
        return view('admin.user.role', compact(['roles', 'myRoles', 'user']));
    }

    public function roleStore(AdminUser $user) {
        $this->validate(request(), [
            'roles' => 'required|array'
        ]);

        $roles = AdminRole::findMany(request('roles'));
        $myRoles = $user->roles;

        // 新加的角色
        $addRoles = $roles->diff($myRoles);
        foreach($addRoles as $role) {
            $user->assignRole($role);
        }

        // 要删的角色
        $removeRoles = $myRoles->diff($roles);
        foreach($removeRoles as $role) {
            $user->deleteRole($role);
        }

        return redirect('/admin/users');
    }
}