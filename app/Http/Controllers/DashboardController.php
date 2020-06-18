<?php

namespace App\Http\Controllers;

use App\Donation;
use App\Event;
use App\HomeContent;
use App\Job;
use App\News;
use App\User;
use App\UserMeta;
use App\Poll;
use DB;
use Carbon\Carbon;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasAnyRole('super-admin|admin')) {
            $events = Event::latest()->limit(5)->get();

            $jobs = Job::latest()->limit(5)->get();

            $donations = Donation::latest()->limit(5)->get();

            $alumni = User::with('profile')->whereHas('userType', function ($query) {
                $query->where('name', 'Alumni');
            })->latest()->limit(10)->get();

            $home = HomeContent::first();

            $totalAlumni = User::with('profile')->whereHas('userType', function ($query) {
                $query->where('name', 'alumni');
            })->where('is_approved', 1)->where('is_deleted', 0)->get();

            $totalStudent = User::with('profile')->whereHas('userType', function ($query) {
                $query->where('name', 'student');
            })->where('is_approved', 1)->where('is_deleted', 0)->get();

             $totalFacultyStuff = User::with('profile')->whereHas('userType', function ($query) {
                $query->where('name', 'faculty-stuff');
            })->where('is_approved', 1)->where('is_deleted', 0)->get();


            $totalJobs = Job::where('is_approved', 1)->get();
            $totalDonations = Donation::where('is_approved', 1)->get();
            $totalEvents = Event::where('is_approved', 1)->get();
            $totalNews = News::all();
            $totalMentors = UserMeta::where('value', 'willing_to_be_mentor')->get();
            $totalPolls = Poll::all();
            $registrationGraphQuery = User::with('profile')

                    ->selectRaw("CONCAT_WS('-',MONTH(created_at),YEAR(created_at)) as monthyear,count(*) AS registrationCount")
            
                    ->groupBy(DB::raw("monthyear"))
                    ->where('is_approved', 1)
                    ->where('is_deleted', 0)
                    ->where('user_type_id', '!=', null)
                     ->orderBy(DB::raw("monthyear"),'desc')
                    ->take(5)
                    ->get();

            $registerGraphArray = array();

            foreach ($registrationGraphQuery as $registrationGraphQueryVal)
            {
                $registerGraphArray[] = array(Carbon::createFromFormat('m-Y', $registrationGraphQueryVal->monthyear)->format('M-Y'), $registrationGraphQueryVal->registrationCount);
            }

            $registerGraphArray = array_reverse($registerGraphArray);

            return view('dashboard-admin.index')->with('events', $events)
                ->with('jobs', $jobs)
                ->with('donations', $donations)
                ->with('alumni', $alumni)
                ->with('home', $home)
                ->with('totalAlumni', $totalAlumni)
                ->with('totalStudent', $totalStudent)
                ->with('totalFacultyStuff',$totalFacultyStuff)
                ->with('totalMentors', $totalMentors)
                ->with('totalJobs', $totalJobs)
                ->with('totalDonations', $totalDonations)
                ->with('totalEvents', $totalEvents)
                ->with('totalNews', $totalNews)
                ->with('totalPolls', $totalPolls)
                ->with('registerGraphArray', $registerGraphArray);

        } else {
      
        $user = Auth::user();

        $q = Event::query();

        $approvedEvents = $q->filteredEvents()->where('is_approved',1)->latest()->limit(3)->get();
    
        $q = Job::query(); 
        $approvedJobs = $q->filteredJobs()->where('is_approved',1)->latest()->limit(3)->get();
        
        $q = Donation::query(); 
        $approvedDonations = $q->filteredDonations()->where('is_approved',1)->latest()->limit(3)->get();

        $alumni = User::with('profile')->whereHas('userType', function ($query) {
                 $query->where('name', 'alumni')
                    ->orWhere('name', 'student');
                     })
                    ->where('is_approved', 1)
                    ->where('is_deleted', 0)
                    ->latest()
                    ->get();

            $home = HomeContent::first();


            return view('dashboard-alumni.index')
                
                     ->with('alumni', $alumni)
                     ->with('home', $home)
                     ->with('approvedEvents', $approvedEvents)
                     ->with('approvedJobs', $approvedJobs)
                     ->with('approvedDonations', $approvedDonations);
        }
    }

}
