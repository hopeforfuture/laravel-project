<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';
    protected $fillable = ['title', 'body', 'article_img', 'article_category', 'created_by'];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    public function category() {
        return $this->belongsTo('App\NewsCategory', 'article_category');
    } 
    
    public function tags() {
        return $this->morphToMany('App\Tag', 'taggable');
    }
}
