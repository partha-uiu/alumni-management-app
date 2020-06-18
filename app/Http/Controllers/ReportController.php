<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Profile;
use App\Job;
use App\News;
use App\Event;
use App\Donation;

class ReportController extends Controller
{
    public function totalAlumni()
    {
        $total_alumni = User::whereHas('userType', function ($query) {
            $query->where('name', '=', 'alumni');
        })->where('is_approved', 1)
            ->where('is_deleted', 0)
            ->count();

        return $total_alumni;
    }

    public function totalJobs()
    {

    }

    public function totalNews()
    {

    }

    public function donations()
    {

    }

    public function events()
    {

    }
}
