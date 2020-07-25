<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'tbtstudents';
	
    protected $fillable = ['name', 'email', 'contact', 'gender', 'roll_no', 'student_class', 'section', 'fav_subjects', 'status'];
	
	const CREATED_AT = 'created';
	
	const UPDATED_AT = 'modified';
}
