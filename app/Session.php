<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    public function profiles()
    {
        return $this->hasMany('App\Profile');
    }

    public function poll()
    {
        return $this->hasMany('App\Poll');
    }
}
