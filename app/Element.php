<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    protected $table = 'element';

    protected $fillable = [
        'id', 'selector', 'page_id',
    ];
}
