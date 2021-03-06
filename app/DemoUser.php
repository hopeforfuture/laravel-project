<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DemoUser extends Model
{
    protected $table = 'demo_users';
    protected $fillable = ['name', 'email', 'password'];
    
    public function profile() {
        return $this->hasOne('App\DemoUserProfile', 'user_id');
    }
    
    public function roles() {
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id')->withTimestamps();;
    }
}
