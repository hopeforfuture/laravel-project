<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';
    
    public function author() {
        return $this->belongsTo('App\Author', 'author_id');
    }  
}
