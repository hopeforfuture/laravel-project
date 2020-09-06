<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mechanic extends Model
{
    protected $table = 'mechanics';
    
    public function carOwner()
    {
        return $this->hasOneThrough('App\Owner', 'App\Car', 'mechanic_id', 'car_id');
    }
}
