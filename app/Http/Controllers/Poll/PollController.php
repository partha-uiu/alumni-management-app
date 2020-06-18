<?php

namespace App\Http\Controllers\Poll;

use Illuminate\Http\Request;
use App\Http\Requests\StorePollRequest;

use App\Http\Requests\UpdatePollRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Poll;
use App\Option;
use Carbon\Carbon;
use App\Institution;
use App\Department;
use App\Session;
use App\UserActivity;
use App\Vote;
use DB;

class PollController extends Controller
{
    public function index()
    {
        $polls = Option::with('poll')
                ->selectRaw("created_at,poll_id,count(name) AS pollName,sum(votes) as totalVotes")
                ->groupBy(DB::raw("poll_id,created_at"))
                ->orderBy(DB::raw("created_at"),'desc')
                ->get();

        $user = Auth::id();

        $polls->load('poll.options');

        $allVotes = Vote::with('option')->where('user_id',  $user)->get();

        return view('polls.poll.index')->with('polls', $polls)->with('allVotes' , $allVotes);
    }

    public function create()
    {
        $sessions = Session::all();

        return view('polls.poll.create')->with('sessions', $sessions);
    }

    public function store(StorePollRequest $request)
    {   
        $department = Department::first();
        $institution = Institution::first();

        $poll = new Poll;
        
        $poll->title = $request->title;
        $poll->max_checkable = $request->max_checkable;
        $poll->institution_id = $institution->id;
        $poll->department_id = $department->id;

        if($request->session_id =='all')           
            {
               $poll->session_id = null;
            }
        else
            {
                $poll->session_id = $request->session_id;

            }
        if($request->filled('end_date')){
            $poll->end_date = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
        }
        $poll->save();

        if (count($request->option_name)) {

            $optionDataCount = count($request->option_name);
            if($optionDataCount<$request->max_checkable) {
                
                $request->session()->flash('message', 'Option name must be greater than or equal to the maximum selectable option');
                
                return redirect()->back()->withInput($request->all());
            }

            $now = Carbon::now()->toDateTimeString();

            $optionDetails = [];

            for ($i = 0; $i < $optionDataCount; $i++) {
                if (!empty($request->option_name[$i])) {
                    $optionDetails[$i]['name'] = $request->option_name[$i];
                    $optionDetails[$i]['poll_id'] = $poll->id;
                    $optionDetails[$i]['created_at'] = $now;
                    $optionDetails[$i]['updated_at'] = $now;
                }
            }

            Option::insert($optionDetails);
        }
        UserActivity::logActivity(Auth::user()->id, 'poll_created', ['relatable_type' => 'App\Poll','relatable_id'=>  $poll->id]);

        return redirect()->back()->with('success', 'Poll has been created successfully !');
    }

    public function edit($id)
    {
        $poll = Poll::find($id);
        $sessions = Session::all();
        $options = Option::where('poll_id', $id)->get();

        return view('polls.poll.edit')
                    ->with('poll', $poll)
                    ->with('sessions', $sessions)
                    ->with('options', $options);
    }

    public function update(UpdatePollRequest $request, $id)
    {
        $department = Department::first();
        $institution = Institution::first();

        $poll = Poll::find($id);
        
        $poll->title = $request->title;
        $poll->max_checkable = $request->max_checkable;
        $poll->institution_id = $institution->id;
        $poll->department_id = $department->id;

        if($request->session_id =='all')           
            {
               $poll->session_id = null;
            }
        else
            {
                $poll->session_id = $request->session_id;

            }

        if($request->filled('end_date')){
            $poll->end_date = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
        }
        $poll->save();

        if (count($request->option_name)) {

            $optionDataCount = count($request->option_name);

            $now = Carbon::now()->toDateTimeString();

            $optionDetails = [];

            for ($i = 0; $i < $optionDataCount; $i++) {
                if (!empty($request->option_name[$i])) {
                    $optionDetails[$i]['name'] = $request->option_name[$i];
                    $optionDetails[$i]['poll_id'] = $poll->id;
                    $optionDetails[$i]['created_at'] = $now;
                    $optionDetails[$i]['updated_at'] = $now;
                }
            }
            Option::where('poll_id', $id)->delete();

            Option::insert($optionDetails);
        }

        return redirect()->back()->with('success', 'Poll has been updated successfully !');
    }

    public function destroy($id)
    {
        $polls = Poll::find($id)->delete();

        return redirect()->back()->with('success', 'Poll has been deleted successfully !');
    }

    public function changeStatus(Request $request, $id,$status)
    {
        $polls = Poll::find($id);
        $polls->status = $request->status;
        $polls->save();

        return redirect()->back()->with('success', 'Poll status has been changed !');
    }
}
