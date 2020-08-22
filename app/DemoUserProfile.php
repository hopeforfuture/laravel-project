<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DemoUserProfile extends Model
{
    protected $table = 'demo_user_profile';
    protected $fillable = ['user_id', 'user_contact', 'user_address'];
}
