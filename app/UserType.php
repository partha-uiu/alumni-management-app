<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    public function user()
    {
        return $this->hasMany('App\User');
    }
}
