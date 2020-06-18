<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EducationalDetail extends Model
{
    public function degree()
    {
        return $this->belongsTo('App\Degree');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
