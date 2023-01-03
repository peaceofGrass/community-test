<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{

//    public function aaa() {
//        echo 111;
//    }
    //
    public function index() {
//        var_dump(\Auth::viaRemember());
//        var_dump(\Auth::check());
//        var_dump(old());
        return view('login/index', ['is_remember' => \Auth::viaRemember()]);
//        return view('login/index', ['is_remember' => \Auth::check()]);
//        return view('login/index', ['is_remember' => 1]);
    }

    public function login() {
        $this->validate(request(), [
            'email' => 'required|email',
            'password' => 'required|min:6|max:20',
            'is_remember' => 'integer'
        ]);

        $user = \request(['email', 'password']);
        $isRemember = boolval(request('is_remember'));

        if (\Auth::attempt($user, $isRemember)) {
            return redirect("/posts");
        }
        return \Redirect::back()->withErrors("이메일과 비밀번호 일치하지 않음.");
    }

    public function logout() {
        \Auth::logout();
        return redirect("/login");
    }
}
