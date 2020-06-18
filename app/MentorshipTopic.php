<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MentorshipTopic extends Model
{
    protected $table = 'mentorship_topics';

    public function users()
    {
        return $this->belongsToMany('App\User', 'mentorship_topic_user')->withTimestamps();
    }

}
