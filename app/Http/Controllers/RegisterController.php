<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class RegisterController extends Controller
{
    //
    public function index() {
        return view('register/index');
    }

    public function register() {
        $this->validate(request(), [
            'name' => 'required|min:5|max:20|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:20|confirmed'
        ]);

        $data = request(["name", "email"]);
        $data['password'] = bcrypt(request("password"));
        User::create($data);

        return redirect("/login");
    }
}
