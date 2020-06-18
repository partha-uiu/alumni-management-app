<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeContent extends Model
{
    protected $table = 'home_contents';
    protected $guarded = [
        'id'
    ];
}
