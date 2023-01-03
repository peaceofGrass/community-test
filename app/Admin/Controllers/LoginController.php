<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index() {
        return view('admin.login.index');
    }

    public function login() {
        $this->validate(request(), [
            'name' => 'required|min:3',
            'password' => 'required|min:6|max:20'
        ]);

        $user = \request(['name', 'password']);

        if (\Auth::guard('admin')->attempt($user)) {
            return redirect("/admin/home");
        }
        return \Redirect::back()->withErrors("이름과 비밀번호 일치하지 않음.");
    }

    public function logout() {
        \Auth::guard('admin')->logout();
        return redirect("/admin/login");
    }
}