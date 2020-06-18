<?php

namespace App\Http\Controllers;

use App\Committee;
use App\CommitteeMember;
use App\MentorshipTopic;
use App\User;
use App\Session;
use App\Degree;
use App\Http\Requests\PasswordSettingsUpdateRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function passwordSettings()
    {
        return view('settings.password-settings');
    }

    public function updatePasswordSettings(UpdatePasswordRequest $request)
    {
        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return redirect()->back()->with('error', 'Old password does not match');
        }

        $user = Auth::user();
        $user->password = bcrypt($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password has been updated');
    }

    public function editUserSettings($id, Request $request)
    {
        if (Auth::user()->hasAnyRole('super-admin|admin')) {

            $adminInfo = User::find($id);
            $mentorshipTopics = MentorshipTopic::all();
            $committee = Committee::first();
            $committeeMembers = CommitteeMember::all();
            $sessions = Session::all();
            $degrees = Degree::all();

            return view('settings.admin-settings')->with('adminInfo', $adminInfo)
                ->with('mentorshipTopics', $mentorshipTopics)
                ->with('committee', $committee)
                ->with('committeeMembers', $committeeMembers)
                ->with('sessions', $sessions)
                ->with('degrees', $degrees);
        } else {

        }
    }

    public function updateUserSettings(Request $request, $id)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required'
        ]);

        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return redirect()->back()->with('error', 'Old password does not match');
        }

        $user = User::find($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->new_password);
        $user->save();

        $generalTab = "Active";

        return redirect()->back()->with('success', 'Settings has been updated')->with('generalTab', '$generalTab');
    }


    public function createPassword()
    {
        return view('settings.password-create');
    }

    public function storeNewPassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required'
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password has been created');
    }

}
