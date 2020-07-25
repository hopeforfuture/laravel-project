<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use Notifiable;
	
	protected $table = 'members';
	
    protected $guard = 'member';
	
    protected $fillable = ['name', 'email', 'password', 'job_role', 'avatar'];
	
	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';
}
