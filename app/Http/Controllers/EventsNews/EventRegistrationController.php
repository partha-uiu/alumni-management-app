<?php

namespace App\Http\Controllers\EventsNews;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\EventRegistration;
use App\UserActivity;
use Illuminate\Support\Facades\Auth;

class EventRegistrationController extends Controller
{
    public function destroy(Request $request)
    {
    	$id = $request->data;
    	
        $event = EventRegistration::find($id)->delete();

        return redirect()->back()->with('success', 'Invitee has been deleted!');
    }

    public function approve(Request $request)
    {
		$id = $request->data;
		

        EventRegistration::where('id', $id)->update(['status' => 1]);

        UserActivity::logActivity(Auth::user()->id, 'register_event_approved', ['relatable_type' => 'App\EventRegistration', 'relatable_id' => $id]);

        return redirect()->back()->with('success', 'Event has been successfully approved !');
    }

    public function batchAction(Request $request)
    {
        $action = $request->action;
        $ids = $request->ids;
        $arrayIds = explode(",", $ids);


        if ($action == 'approve') {
            EventRegistration::whereIn('id', $arrayIds)->update(['status' => 1]);

            foreach ($arrayIds as $arrayId) {
                UserActivity::logActivity(Auth::user()->id, 'register_event_approved', ['relatable_type' => 'App\EventRegistration', 'relatable_id' => $arrayId]);
            }
        } elseif ($action == 'disapprove') {
            EventRegistration::whereIn('id', $arrayIds)->update(['status' => 0]);
        } elseif ($action == 'delete') {
            EventRegistration::whereIn('id', $arrayIds)->delete();
        }

        return redirect()->back()->with('success', 'Action Successfully Done !');
    }
}
