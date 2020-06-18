<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Session;
use Carbon\Carbon;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = Session::all();

        return view('sessions.index')->with('sessions', $sessions);
    }

    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        // $session_name = $request->session_name;
               
        $this->validate($request, [
            'session_name.*' => 'required|unique:sessions,name'
        ]);
      
        if (count($request->session_name)) {

            $sessionDataCount = count($request->session_name);

            $now = Carbon::now()->toDateTimeString();

            $sessionName = [];

            for ($i = 0; $i < $sessionDataCount; $i++) {
                $sessionName[$i]['name'] = $request->session_name[$i];
                $sessionName[$i]['created_at'] = $now;
                $sessionName[$i]['updated_at'] = $now;
            }

            Session::insert($sessionName);
        }
        $sessionsTab = "active";

        return redirect()->back()->with('success', 'Session has been successfully added')->with('sessionsTab', $sessionsTab);
    }

    public function edit($id)
    {
        $session = Session::find($id);

        return view('sessions.edit')
            ->with('session', $session);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'session_name' => 'required|unique:sessions,name'
        ]);

        $session = Session::find($id);
        $session->name = $request->session_name;
        $session->save();

        return redirect()->back()->with('success', 'Session has been updated!');
    }

    public function destroy($id)
    {
        Session::find($id)->delete();
        $sessionsTab = "active";

        return redirect()->back()->with('success', 'Session has been deleted!')->with('sessionsTab', $sessionsTab);
    }

}
