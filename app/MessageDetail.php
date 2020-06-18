<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageDetail extends Model
{
    public function message()
    {
        return $this->belongsTo('App\Message');
    }

    public function parent()
    {
        return $this->belongsTo('User', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('User', 'parent_id');
    }

}
