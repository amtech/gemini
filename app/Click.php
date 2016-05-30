<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    protected $table = 'click';

    protected $fillable = [
        'selector'
    ];

    public function setp() {
        return $this->morphOne('App\Setp', 'detail');
    }
}
