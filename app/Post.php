<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {

    protected $fillable = ['title', 'content'];

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

}
