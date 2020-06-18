<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobRequest;

use App\Http\Requests\UpdateJobRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserActivity;
use App\Job;
use App\Session;
use App\Institution;
use App\Department;
use Carbon\Carbon;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $q = Job::query();

        if ($request->filled('q')) {

            $searchKeyword = $request->q;

            $q->where(function ($query) use ($searchKeyword) {
                $query->where('job_title', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('company_name', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('position', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('vacancy', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('location', 'like', '%' . $searchKeyword . '%');
            });
        }

        if ($request->filled('type')) {

            $jobType = $request->type;

            if($jobType!="All") {
                $q->where('job_type', 'like', '%' . $jobType . '%');
            }
        }

        if ($request->filled('status')) {

            $status = $request->status;

            if ($status == 'approved') {
                $q->where('is_approved', '=', 1);
            } elseif ($status == 'pending') {
                $q->where('is_approved', '=', 0);

            }
        }

        $allJobs = $q->latest()->paginate(10);

        $jobs = $q->filteredJobs($q)->where('is_approved', 1)->latest()->paginate(10);
    
        return view('jobs.index')->with('jobs', $jobs)->with('allJobs', $allJobs);
    }

    public function create()
    {
        $latestJobs = Job::where('is_approved', 1)->latest()->take(5)->get();

        $sessions = Session::all();
        $department = Department::first();
        $institution = Institution::first();


        return view('jobs.create')->with('latestJobs', $latestJobs)
                                  ->with('sessions',  $sessions)
                                  ->with('department', $department)
                                  ->with('institution', $institution);
    }

    public function store(StoreJobRequest $request)
    {
        $userId = Auth::id();

        $job = new Job;
        $job->user_id = $userId;
        $job->job_title = $request->job_title;
        $job->company_name = $request->company_name;
        $job->vacancy = $request->vacancy;
        $job->job_type = $request->job_type;
        $job->location = $request->location;
        $job->url = $request->url;
        $job->description = $request->description;
        $job->educational_requirements = $request->educational_requirements;
        $job->job_requirements = $request->job_requirements;
        $job->salary_range = $request->salary_range;
        $job->other_benefits = $request->other_benefits;

        if( $request->session_id =='all')
            
            {
               $job->session_id = null;
             }
        else
             {
               $job->session_id = $request->session_id;

             }
        $job->department_id = $request->department_id;
        $job->institution_id = $request->institution_id;

        $job->post_date = Carbon::createFromFormat('d-m-Y', $request->post_date)->format('Y-m-d');
        $job->end_date = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
        $job->apply_instruction = $request->apply_instruction;

        if ($request->hasFile('image_url')) {
            $jobImage = $request->file('image_url');
            $jobImageSaveAsName = time() . Auth::id() . "-job." . $jobImage->getClientOriginalExtension();
            $jobImage->storeAs('public/job', $jobImageSaveAsName);
            $job->image_url = "job/" . $jobImageSaveAsName;
        }

        $user = Auth::user();

        if ($user->hasAnyRole('super-admin|admin|editor|faculty-stuff')) {
            $job->is_approved = '1';
        }

        $job->save();
        
        if ($user->hasAnyRole('super-admin|admin|editor|faculty-stuff')) {
            UserActivity::logActivity(Auth::user()->id, 'job_approved', ['relatable_type' => 'App\Job','relatable_id'=> $job->id]);

        }

        UserActivity::logActivity(Auth::user()->id, 'job_created', ['relatable_type' => 'App\Job','relatable_id'=>  $job->id]);

        return redirect()->back()->with('success', 'Job has been successfully added');
    }

    public function show($id)
    {
        $job = Job::find($id);
        $latestJobs = Job::where('is_approved', 1)->latest()->take(5)->get();

        return view('jobs.show')
            ->with('job', $job)
            ->with('latestJobs', $latestJobs);
    }

    public function edit($id)
    {
        $job = Job::find($id);
        $latestJobs = Job::where('is_approved', 1)->latest()->take(5)->get();

        return view('jobs.edit')
            ->with('job', $job)
            ->with('latestJobs', $latestJobs);
    }

    public function update($id, UpdateJobRequest $request)
    {
        $job = Job::find($id);
        $job->job_title = $request->job_title;
        $job->company_name = $request->company_name;
        $job->vacancy = $request->vacancy;
        $job->job_type = $request->job_type;
        $job->location = $request->location;
        $job->url = $request->url;
        $job->description = $request->description;
        $job->educational_requirements = $request->educational_requirements;
        $job->job_requirements = $request->job_requirements;
        $job->salary_range = $request->salary_range;
        $job->other_benefits = $request->other_benefits;

        $job->post_date = Carbon::createFromFormat('d-M-Y', $request->post_date)->format('Y-m-d');
        $job->end_date = Carbon::createFromFormat('d-M-Y', $request->end_date)->format('Y-m-d');
        $job->apply_instruction = $request->apply_instruction;

        $user = Auth::user();
        if ($user->hasAnyRole('super-admin|admin|editor|faculty-stuff')) {
            $job->is_approved = '1';
        }

        $job->save();

        return redirect()->back()->with('success', 'Job has been updated!');
    }

    public function destroy($id)
    {
        Job::find($id)->delete();

        return redirect()->back()->with('success', 'Job has been successfully deleted!');
    }

    public function approve($id)
    {

        Job::where('id', $id)->update(['is_approved' => 1, 'approved_by' => Auth::id()]);

        UserActivity::logActivity(Auth::user()->id, 'job_approved', ['relatable_type' => 'App\Job','relatable_id'=> $id]);



        return redirect()->back()->with('success', 'Job has been successfully approved !');
    }

    public function batchAction(Request $request)
    {
        $action = $request->action;
        $ids = $request->ids;
        $arrayIds = explode(",", $ids);

        if ($action == 'approve') {
            Job::whereIn('id', $arrayIds)->update(['is_approved' => 1, 'approved_by' => Auth::id()]);
         
        foreach($arrayIds as $arrayId) {
              UserActivity::logActivity(Auth::user()->id, 'job_approved', ['relatable_type' => 'App\Job','relatable_id'=> $arrayId]);
       
           }

        } elseif ($action == 'disapprove') {
            Job::whereIn('id', $arrayIds)->update(['is_approved' => 0, 'approved_by' => null]);
        } elseif ($action == 'delete') {
            Job::whereIn('id', $arrayIds)->delete();
        }

        return redirect()->back()->with('success', 'Action Successfully Done !');
    }

}
