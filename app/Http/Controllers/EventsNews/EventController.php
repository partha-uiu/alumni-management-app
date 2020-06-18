<?php

namespace App\Http\Controllers\EventsNews;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreEventRequest;
use App\Event;
use App\Session;
use App\Institution;
use App\Department;
use App\UserActivity;
use App\EventCriteria;
use App\EventRegistration;
use App\Degree;
use App\EducationalDetail;
use App\Http\Requests\UpdateEventRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $q = Event::query();

        if ($request->filled('q')) {

            $searchKeyword = $request->q;

            $q->where(function ($query) use ($searchKeyword) {
                $query->where('title', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('description', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('location', 'like', '%' . $searchKeyword . '%');
            });
        }

        if ($request->filled('event_date')) {

            $date = Carbon::createFromFormat('d-m-Y', $request->event_date)->format('Y-m-d');

            $q->where('start_date', 'like', '%' . $date . '%');
        }

        if ($request->filled('status')) {

            $status = $request->status;

            if ($status == 'approved') {
                $q->where('is_approved', '=', 1);
            } elseif ($status == 'pending') {
                $q->where('is_approved', '=', 0);

            }
        }
        
        $allEvents = $q->latest()->paginate(10);

        $approvedEvents = $q->filteredEvents($q)->where('is_approved', 1)->latest()->paginate(10);

        return view('events.index')->with('allEvents', $allEvents)->with('approvedEvents', $approvedEvents);
    }

    public function create()
    {
        $latestEvents = Event::where('is_approved', 1)->latest()->take(5)->get();

        $sessions = Session::all();
        $degrees = Degree::all();
        $department = Department::first();
        $institution = Institution::first();

        return view('events.create')->with('latestEvents', $latestEvents)
            ->with('sessions', $sessions)
            ->with('degrees', $degrees)
            ->with('department', $department)
            ->with('institution', $institution);
    }

    public function store(StoreEventRequest $request)
    {
        $userId = Auth::id();

        $event = new Event;
        $event->user_id = $userId;
        $event->title = $request->title;

        $event->department_id = $request->department_id;

        if ($request->session_id == 'all') {
            $event->session_id = null;
        } else {
            $event->session_id = $request->session_id;

        }
        
        $event->institution_id = $request->institution_id;

        $event->description = $request->description;
        $event->start_date = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');

        $st = preg_replace('/\s*:\s*/', ':', $request->start_time);

        $event->start_time = date("H:i", strtotime($st));

        $event->end_date = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
        $et = preg_replace('/\s*:\s*/', ':', $request->end_time);
        $startDate = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
        
      


        $event->end_time = date("H:i", strtotime($et));
        $event->location = $request->location;
        $event->link = $request->link;

        $event->event_type = $request->event_type; // Public or Private
        if($request->filled('visibility')){
            $event->visibility = $request->visibility; //Invited or Open for all
        }
        else {
            $event->visibility = 0;
        }
        
        $event->need_registration = $request->need_registration;
        $event->is_featured = $request->is_featured;

        $user = Auth::user();

        if ($user->hasAnyRole('super-admin|admin|editor|faculty-stuff')) {
            
            $event->is_approved = 1;

        }
       
        $event->save();

        if ($user->hasAnyRole('super-admin|admin|editor|faculty-stuff')) {
            
            UserActivity::logActivity(Auth::user()->id, 'event_approved', ['relatable_type' => 'App\Event', 'relatable_id' => $event->id]);

        }

        if ($request->visibility == 1) {

            if (count($request->eventSessions)) {

                $countSession = count($request->eventSessions);

                $eventData = [];

                $now = Carbon::now()->toDateTimeString();

                for ($i = 0; $i < $countSession; $i++) {
                    
                    $eventData[$i]['user_id'] = $userId;
                    $eventData[$i]['event_id'] = $event->id;
                    $eventData[$i]['type'] = 'session';
                    $eventData[$i]['value'] = $request->eventSessions[$i];
                    $eventData[$i]['created_at'] = $now;
                    $eventData[$i]['updated_at'] = $now;

                }

                EventCriteria::insert($eventData);
            }


            if (count($request->eventDegrees)) {

                $countDegree = count($request->eventDegrees);

                $eventData = [];

                $now = Carbon::now()->toDateTimeString();

                for ($i = 0; $i < $countDegree; $i++) {
                    $eventData[$i]['user_id'] = $userId;
                    $eventData[$i]['event_id'] = $event->id;
                    $eventData[$i]['type'] = 'degree';
                    $eventData[$i]['value'] = $request->eventDegrees[$i];
                    $eventData[$i]['created_at'] = $now;
                    $eventData[$i]['updated_at'] = $now;

                }
                EventCriteria::insert($eventData);
            }
        }

        UserActivity::logActivity(Auth::user()->id, 'event_created', ['relatable_type' => 'App\Event', 'relatable_id' => $event->id]);

        return redirect()->back()->with('success', 'Event has been added');
    }

    public function show($id)
    {
        $event = Event::find($id);
        $latestEvents = Event::where('is_approved', 1)->latest()->take(5)->get();
        
        $alreadyRegistered =  EventRegistration::with('user.profile')->where('user_id', Auth::id())
                                                ->where('event_id', $id)
                                                ->first();
        
        if(!$alreadyRegistered) {
            $alreadyRegistered = false;
        }

        $needRegistration = Event::where('need_registration', 1)->find($id);
      
        $inviteesUsers =  EventRegistration::with('user.profile')
                                       ->where('event_id', $id)
                                       ->where('status', 1)
                                       ->get();
        
                          
        $allInvitees =  EventRegistration::with('user.profile')->where('event_id', $id)
                                                               ->where('status', 0)
                                                               ->get();
        
                          
        $checkInvitees =  EventRegistration::with('user.profile')->where('event_id', $id)
                                            ->where('status', 1)
                                            ->first();

        $checkEventStatus = Event::whereHas('eventRegistrations', function ($query) use ($id) {
            $query->where('event_id', $id);
        })->first();

        if(!$checkEventStatus) {
            $checkEventStatus = false; 
        }

        return view('events.show')
               ->with('event', $event)
               ->with('alreadyRegistered', $alreadyRegistered)
               ->with('latestEvents', $latestEvents)
               ->with('inviteesUsers', $inviteesUsers)
               ->with('allInvitees', $allInvitees)
               ->with('checkInvitees', $checkInvitees)
               ->with('needRegistration', $needRegistration)
               ->with('checkEventStatus', $checkEventStatus);
    }

    public function edit($id)
    {
        $event = Event::find($id);
        $latestEvents = Event::where('is_approved', 1)->latest()->take(5)->get();

        
        $sessions = Session::all();
        $degrees = Degree::all();
        $eventCriterias = EventCriteria::where('event_id', $id)->get();

        return view('events.edit')
            ->with('event', $event)
            ->with('latestEvents', $latestEvents)
            ->with('sessions', $sessions)
            ->with('degrees', $degrees)
            ->with('eventCriterias', $eventCriterias);
    }

    public function update($id, UpdateEventRequest $request)
    {
        $userId = Auth::id();

        $event = Event::find($id);
        $event->user_id = $userId;
        $event->title = $request->title;

        $event->department_id = $request->department_id;

        if ($request->session_id == 'all') {
            $event->session_id = null;
        } else {
            $event->session_id = $request->session_id;

        }
        
        $event->institution_id = $request->institution_id;

        $event->description = $request->description;
        $event->start_date = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');

        $st = preg_replace('/\s*:\s*/', ':', $request->start_time);

        $event->start_time = date("H:i", strtotime($st));

        $event->end_date = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
        $et = preg_replace('/\s*:\s*/', ':', $request->end_time);

        $event->end_time = date("H:i", strtotime($et));
        $event->location = $request->location;
        $event->link = $request->link;

        $event->event_type = $request->event_type; // Public or Private
        if($request->filled('visibility')){
            $event->visibility = $request->visibility; //Invited or Open for all
        }
        else {
            $event->visibility = 0;
        }
        
        $event->need_registration = $request->need_registration;
        $event->is_featured = $request->is_featured;

        $user = Auth::user();

        if ($user->hasAnyRole('super-admin|admin|editor|faculty-stuff')) {
            
            $event->is_approved = 1;


        }

        $event->save();
       

        if ($request->visibility == 1) {
            
            if (count($request->eventSessions)) {

                $countSession = count($request->eventSessions);

                $eventData = [];

                $now = Carbon::now()->toDateTimeString();

                for ($i = 0; $i < $countSession; $i++) {
                    $eventData[$i]['user_id'] = $userId;
                    $eventData[$i]['event_id'] = $event->id;
                    $eventData[$i]['type'] = 'session';
                    $eventData[$i]['value'] = $request->eventSessions[$i];
                    $eventData[$i]['created_at'] = $now;
                    $eventData[$i]['updated_at'] = $now;

                }
                EventCriteria::where('event_id', $id)->where('type', 'session')->delete();
               
                EventCriteria::insert($eventData);
            }


            if (count($request->eventDegrees)) {

                $countDegree = count($request->eventDegrees);

                $eventData = [];

                $now = Carbon::now()->toDateTimeString();

                for ($i = 0; $i < $countDegree; $i++) {
                    $eventData[$i]['user_id'] = $userId;
                    $eventData[$i]['event_id'] = $event->id;
                    $eventData[$i]['type'] = 'degree';
                    $eventData[$i]['value'] = $request->eventDegrees[$i];
                    $eventData[$i]['created_at'] = $now;
                    $eventData[$i]['updated_at'] = $now;

                }

                EventCriteria::where('event_id', $id)->where('type', 'degree')->delete();

                EventCriteria::insert($eventData);
            }
        }

        return redirect()->back()->with('success', 'Event has been successfully updated!');
    }

    public function destroy($id)
    {
        $event = Event::find($id)->delete();

        return redirect()->back()->with('success', 'Event has been deleted!');
    }

    public function approve($id)
    {
        Event::where('id', $id)->update(['is_approved' => 1, 'approved_by' => Auth::id()]);

        UserActivity::logActivity(Auth::user()->id, 'event_approved', ['relatable_type' => 'App\Event', 'relatable_id' => $id]);

        return redirect()->back()->with('success', 'Event has been successfully approved !');
    }

    public function batchAction(Request $request)
    {
        $action = $request->action;
        $ids = $request->ids;
        $arrayIds = explode(",", $ids);

        if ($action == 'approve') {
            Event::whereIn('id', $arrayIds)->update(['is_approved' => 1, 'approved_by' => Auth::id()]);

            foreach ($arrayIds as $arrayId) {
                UserActivity::logActivity(Auth::user()->id, 'event_approved', ['relatable_type' => 'App\Event', 'relatable_id' => $arrayId]);
            }
        } elseif ($action == 'disapprove') {
            Event::whereIn('id', $arrayIds)->update(['is_approved' => 0, 'approved_by' => null]);
        } elseif ($action == 'delete') {
            Event::whereIn('id', $arrayIds)->delete();
        }

        return redirect()->back()->with('success', 'Action Successfully Done !');
    }

    public function activities()
    {
        return $this->morphMany('App\UserActivity', 'activities');
    }

    public function registerEvent($id)
    {
        $eventDetails = Event::find($id);
       
        $user = Auth::user();

        $checkRegister = EventRegistration::where('user_id', $user->id)->where('event_id',$id)->first();

        if($checkRegister){
            return  redirect()->back()->with('error', 'You have alredy registered in this event');
        }

        if(($user->profile->institution_id != ($eventDetails->institution_id))&&($eventDetails->institution_id!=null) )
            {
                return redirect()->back()->with('error', 'You are not valid invitee');

            }

        $currentDate = Carbon::now()->format("Y-m-d");

        if ($currentDate > $eventDetails->end_date ) {
            return redirect()->back()->with('error', 'Event is not valid now');
        }

        if ($eventDetails->need_registration != 1) {
            return redirect()->back()->with('error', 'You don\'t need to register in this event');
        }

        if ($eventDetails->visibility == 1) {

            $eventSessions = [];

            $getEventSessions = EventCriteria::where('event_id', $id)
                ->where('type', 'session')
                ->get();

            foreach ($getEventSessions as $getEventSession) {
                if($getEventSession->value!="All"){
                    $eventSessions[] = $getEventSession->value;
                }
                else{
                    $eventSessions[] = "All";
                }
            }

            $eventDegrees = [];

            $getEventDegrees = EventCriteria::where('event_id', $id)
                ->where('type', 'degree')
                ->get();

            foreach ($getEventDegrees as $getEventDegree) {
                if($getEventDegree->value!="All"){
                    $eventDegrees[] = $getEventDegree->value;
                }
                else{
                    $eventDegrees[] = "All";
                }
            }

            
            $getAllForSessionDegrees = EventCriteria::select('type', 'value')
                ->where('event_id', $id)
                ->where('value', 'All')
                ->get();


            $allType = [];

            if (count($getAllForSessionDegrees) > 1) {
                foreach ($getAllForSessionDegrees as $getAllForSessionDegrees) {
                    $allType[] = $getAllForSessionDegrees->value;
                }
            }

            $userDegreeIds = EducationalDetail::select('degree_id')->where('user_id',Auth::id())->get();

            foreach ($userDegreeIds as $userDegreeId) {
                    {
                        $userDegrees[] = $userDegreeId->degree_id;
                    }
                }

            if (count($allType)) {

                $userId = Auth::id();

                $eventRegister = new EventRegistration;
                $eventRegister->user_id = $userId;
                $eventRegister->event_id= $id;
                $eventRegister->guest_count = 0;
                $eventRegister->payment_status = 1; // 0 - unpaid , 1 - paid
                $eventRegister->payment_amount = 0; //payment amount is 0
                $eventRegister->status = 0; // pending
                $eventRegister->save();

                return redirect()->back()->with('success', 'You have been susccessfully registerd to this event');
            }
            else 
            
            {
                if( 
                    !(((in_array(Auth::user()->profile->session_id, $eventSessions))||(in_array('All', $eventSessions)) )  
                        && 
                    (( ! empty(array_intersect($userDegrees, $eventDegrees)) ) || (in_array('All', $eventDegrees)) ))

                )
                
                {
                    return redirect()->back()->with('error', 'You are not allowed in this event. Thank You.');
                } 
                else 
                {
                    $userId = Auth::id();

                    $eventRegister = new EventRegistration;
                    $eventRegister->user_id = $userId;
                    $eventRegister->event_id= $id;
                    $eventRegister->guest_count = 0;
                    $eventRegister->payment_status = 1; // 0 - unpaid , 1 - paid
                    $eventRegister->payment_amount = 0; //payment amount is 0
                    $eventRegister->status = 0; // pending
                    $eventRegister->save();

                    return redirect()->back()->with('success', 'You have been susccessfully registerd to this event');
                }
            }
        } else {
            $userId = Auth::id();

            $eventRegister = new EventRegistration;
            $eventRegister->user_id = $userId;
            $eventRegister->event_id= $id;
            $eventRegister->guest_count = 0;
            $eventRegister->payment_status = 1; // 0 - unpaid , 1 - paid
            $eventRegister->payment_amount = 0; //payment amount is 0
            $eventRegister->status = 0; // pending
            $eventRegister->save();

            return redirect()->back()->with('success', 'You have been susccessfully registerd to this event');
        }
    }
}
