<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function profiles()
    {
        return $this->hasMany('App\Profile');
    }

    public function polls()
    {
        return $this->hasMany('App\Poll');
    }
}
