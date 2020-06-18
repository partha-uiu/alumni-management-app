<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Option;
use App\Session;
use App\Department;
use App\Institution;

class Poll extends Model
{
    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function institution()
    {
        return $this->belongsTo('App\Institution');
    }

    public function session()
    {
        return $this->belongsTo('App\Session');
    }

    public function options()
    {
        return $this->hasMany('App\Option');
    }
}
