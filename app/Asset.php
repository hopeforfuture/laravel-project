<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model {

    protected $table = 'assets';

    public function assetable() {
        return $this->morphTo(__FUNCTION__, 'assetable_type', 'assetable_id');
    }

}
