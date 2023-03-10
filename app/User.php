<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // 用户的文章列表
    public function posts() {
        return $this->hasMany(\App\Post::class, 'user_id', 'id');
    }

    // 关注我的Fan模型
    public function fans() {
        return $this->hasMany(\App\Fan::class, 'star_id', 'id');
    }

    // 我关注的Fan模型
    public function stars() {
        return $this->hasMany(\App\Fan::class, 'fan_id', 'id');
    }

    // 关注某人
    public function doFan($uid) {
        $star = new \App\Fan();
        $star->star_id = $uid;
        return $this->stars()->save($star);
    }

    // 取关某人
    public function doUnfan($uid) {
        $star = new \App\Fan();
        $star->star_id = $uid;
        return $this->stars()->delete($star);
    }

    // 当前用户是否被某个uid关注
    public function hasFan($uid) {
        return $this->fans()->where('fan_id', $uid)->count();
    }

    // 当前用户是否关注了某个uid
    public function hasStar($uid) {
        return $this->stars()->where('star_id', $uid)->count();
    }

    // 用户收到的通知
    public function notices() {
        return $this->belongsToMany(\App\Notice::class, 'user_notice', 'user_id', 'notice_id')
            ->withPivot(['user_id', 'notice_id']);
    }

    // 给用户增加通知
    public function addNotice($notice) {
        return $this->notices()->save($notice);
    }


}
