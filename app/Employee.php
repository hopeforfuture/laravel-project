<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    
    public function asset()
    {
        return $this->morphOne('App\Asset', 'assetable');
    }
}
