<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    // 个人设置页面
    public function setting() {
        return view('user/setting');
    }

    // 个人设置行为
    public function settingStore() {
        $this->validate(request(), [
            'name' => 'required|min:3|max:20|unique:users,name,' . \Auth::id() . ',id'
        ]);

        // 这个方法也可以
//        $user['name'] = \request('name');
//        $user['avatar'] = \request('avatar_input');
//
//        User::where('id', \Auth::id())->update($user);

        $user = User::find(\Auth::id());
        $user->name = \request('name');
        $user->avatar = \request('avatar_input');
        $user->save();

        return redirect("/user/" . \Auth::id());
    }

    // 个人中心页面
    public function show(User $user) {

        // 这个人的信息，包含 关注，粉丝，文章数
        $user = User::withCount(['stars', 'fans', 'posts'])->find($user->id);

        // 这个人的文章列表，前10条
        $posts = $user->posts()->orderBy('created_at', 'desc')->take(10)->get();

        // 这个人关注的用户，包含 关注，粉丝，文章数
        $stars = $user->stars();
        $sUsers = User::whereIn('id', $stars->pluck('star_id'))
            ->withCount(['stars', 'fans', 'posts'])->get();

        // 这个人粉丝用户，包含 关注，粉丝，文章数
        $fans = $user->fans();
        $fUsers = User::whereIn('id', $fans->pluck('fan_id'))
            ->withCount(['stars', 'fans', 'posts'])->get();

        return view('user/show', compact(['user', 'posts', 'sUsers', 'fUsers']));
    }

    // 关注用户
    public function fan(User $user) {
        $me = \Auth::user();
        $me->doFan($user->id);

        return [
            'error' => 0,
            'msg'   => '关注成功'
        ];
    }

    // 取关用户
    public function unfan(User $user) {
        $me = \Auth::user();
        $me->doUnfan($user->id);

        return [
            'error' => 0,
            'msg'   => '取关成功'
        ];
    }

    public function avatarUpload(Request $request) {
        $path = $request->file('pic')->storePublicly(md5(time()));
        return asset('storage/' . $path);
    }
}
