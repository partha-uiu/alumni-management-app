<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
	protected $guarded = ['id'];
    public $timestamps = false;

    public static function logActivity($userId, $activityType, $args = [])
    {
    	$now = Carbon::now()->toDateTimeString();

        $args['user_id'] = $userId;
        $args['activity_type'] = $activityType;
        

        if(isset($_SERVER['REMOTE_ADDR'])) {
            $args['ip_address'] = $_SERVER['REMOTE_ADDR'];

        }



        $args['created_at'] = $now;

        return self::create($args);
    }

    public function relatable()
    {
        return $this->morphTo();
    }
}
