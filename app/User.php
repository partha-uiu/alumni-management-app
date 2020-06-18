<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id', 'is_approved'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    public function educationalDetails()
    {
        return $this->hasMany('App\EducationalDetail');
    }

    public function jobs()
    {
        return $this->hasMany('App\Job');
    }

    public function news()
    {
        return $this->hasMany('App\News');
    }

    public function events()
    {
        return $this->hasMany('App\Event');
    }

    public function eventCriteria()
    {
        return $this->hasMany('App\Event');
    }

    public function donations()
    {
        return $this->hasMany('App\Donation');
    }

    public function userType()
    {
        return $this->belongsTo('App\UserType');
    }

    public function userMetas()
    {
        return $this->hasMany('App\UserMeta');
    }

    public function metorshipTopics()
    {
        return $this->belongsToMany('App\MentorshipTopic', 'mentorship_topic_user')->withTimestamps();
    }

    public function socialAccounts()
    {
        return $this->hasMany('App\SocialAccount');
    }

    public function eventRegistration()
    {
        return $this->hasMany('App\EventRegistration');
    }

    public function verified()
    {
        $this->verified = 1;
        $this->email_token = null;
        $this->save();
    }

    public function votes()
    {
        return $this->hasMany('App\Vote');
    }
}
