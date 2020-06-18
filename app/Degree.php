<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    public function educationalDetails()
    {
        return $this->hasMany('App\EducationalDetail');
    }
}
