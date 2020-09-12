<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';
    
    public function author() {
        return $this->belongsTo('App\Author', 'author_id');
    }  
    
    public function asset()
    {
        return $this->morphOne('App\Asset', 'assetable');
    }
    
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }
}
