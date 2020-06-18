<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutContent extends Model
{
    protected $table = 'about_contents';
    protected $guarded = [
        'id'
    ];
}
