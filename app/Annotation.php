<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Annotation extends Model
{
    protected $table = 'annotation';

    protected $fillable = [
        'summary'
    ];

    public function setp() {
        return $this->morphOne('App\Setp', 'detail');
    }
}
