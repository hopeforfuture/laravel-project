<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model {

    protected $table = 'news';
    protected $fillable = ['news_title', 'news_description', 'news_slug', 'news_category_id', 'news_img_thumb'];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

}
