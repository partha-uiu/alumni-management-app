<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    public static function userMetas()
    {
        $userMeta = [];
        $userMeta['introduce_other_my_connections'] = "Willing to introduce others to my connections";
        $userMeta['open_my_workplace'] = "Willing to open doors at my workplace";
        $userMeta['ans_industry_specific_questions'] = "Willing to answer industry specific questions";
        $userMeta['willing_to_be_mentor'] = "Willing to be a mentor";

        return $userMeta;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}


