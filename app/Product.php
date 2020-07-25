<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
	
    protected $fillable = ['name', 'details', 'price', 'product_image'];
	
	const CREATED_AT = 'created';
	
	const UPDATED_AT = 'modified';
}
