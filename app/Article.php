<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';
    protected $fillable = ['title', 'body', 'article_img', 'article_category'];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
