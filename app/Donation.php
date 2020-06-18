<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Donation extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function ScopeFilteredDonations($q)
    {
        $user = Auth::user();

        $userSession = 0;
        $userDepartment = 0;
        $userInstitute = 0;
        if($user->profile) {
            $userSession = $user->profile->session_id;
            $userDepartment = $user->profile->department_id;
            $userInstitute = $user->profile->institution_id;
        }

        if ($userSession) {
            $q->where('session_id', $userSession)
                ->orWhereNull('session_id');
        } else {
            $q->whereNull('session_id');
        }

        if ($userDepartment) {
            $q->where('department_id', $userDepartment)
                ->orWhereNull('department_id');
        } else {
            $q->whereNull('department_id');
        }

        if ($userInstitute) {
            $q->where('institution_id', $userInstitute)
                ->orWhereNull('institution_id');
        } else {
            $q->whereNull('institution_id');
        }

        return $q;
    }


    public function activities()
    {
        return $this->morphMany('App\UserActivity', 'activities');
    }
}
