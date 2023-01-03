<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    //
    protected $rememberTokenName = '';

    protected $guarded = [];

    // 用户有哪些角色
    public function roles() {
        return $this->belongsToMany(
            \App\AdminRole::class,
            'admin_role_user',
            'user_id',
            'role_id'
        )->withPivot(['user_id', 'role_id']);
    }

    // 判断是否有给定的角色
    public function isInRole($roles) {
//        return !!$this->roles()->intersect($roles)->count();
        return $roles->intersect($this->roles)->count();
//        return $this->roles->contains($roles);
    }

    // 给用户分配角色
    public function assignRole($role) {
        return $this->roles()->save($role);
    }

    // 取消用户的角色
    public function deleteRole($role) {
        return $this->roles()->detach($role);
    }

    // 用户是否有权限
    public function hasPermission($permission) {
        return $this->isInRole($permission->roles);
    }
}
