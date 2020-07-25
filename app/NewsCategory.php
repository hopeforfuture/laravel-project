<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    protected $table = 'news_categories';
	
    protected $fillable = ['category_name', 'category_details', 'category_image'];
	
    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';
}
