<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forward extends Model
{
    protected $table = 'forward';

    protected $fillable = [
        'target_page_id'
    ];

    public function setp() {
        return $this->morphOne('App\Setp', 'detail');
    }
}
