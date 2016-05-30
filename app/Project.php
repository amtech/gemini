<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'project';

//    protected $fillable = [
//        'id', 'name', 'description', 'url'
//    ];

    public function usecases() {
        $usercases=$this->hasMany('App\Usecase');
        $usercases->orderBy('order');
        return $usercases;
    }
    
}
