<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usecase extends Model
{
    protected $table = 'usecase';

//    protected $fillable = [
//        'id', 'page_id', 'usecase_id', 'name',
//        'element_id',  'precondition', 'type'
//    ];


    public function setps()
    {
        return $this->hasMany('App\Setp');
    }
}
