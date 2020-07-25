<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'tblsubjects';
	
    protected $fillable = ['name', 'code', 'status'];
	
	const CREATED_AT = 'created';
	
	const UPDATED_AT = 'modified';
}
