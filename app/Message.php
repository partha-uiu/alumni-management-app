<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function messageDetails()
    {
        return $this->hasMany('App\MessageDetail');
    }
}
