<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCriteria extends Model
{
    protected $table = 'event_criteria';

    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
