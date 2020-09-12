<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'country';
    protected $primaryKey = 'country_id';
    
    /**
     * Get all of the posts for the country.
     */
    public function blogs()
    {
        return $this->hasManyThrough('App\Blog', 'App\Author', 'country_id', 'author_id', 'country_id');
    }
}
