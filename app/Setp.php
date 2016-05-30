<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setp extends Model
{
    protected $table = 'setp';

//    protected $fillable = [
//        'id', 'page_id', 'usecase_id', 'name',
//        'element_id',  'precondition', 'type'
//    ];
    public function detail() {
        return $this->morphTo();
    }
}
