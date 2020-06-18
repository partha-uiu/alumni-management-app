<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [
        'id', 'visibility_status'
    ];

    protected $appends = ['profile_picture'];

    public function getProfilePictureAttribute()
    {
        if ($this->attributes['profile_photo_url']) {

            $url = $this->attributes['profile_photo_url'];

            if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
                return asset('storage') . '/' . $this->attributes['profile_photo_url'];
            } else {
                return $this->attributes['profile_photo_url'];
            }
        } else {
            return url('images/default-avatar.jpg');
        }
    }

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

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
