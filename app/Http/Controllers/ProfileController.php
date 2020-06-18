<?php

namespace App\Http\Controllers;

use App\Country;
use App\Degree;
use App\EducationalDetail;
use App\Http\Requests\UpdatePasswordRequest;
use App\MentorshipTopic;
use App\Session;
use App\User;
use App\UserMeta;
use App\UserType;
use App\WorkExperience;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Image;

class ProfileController extends Controller
{
    public function index($id)
    {
        $currentUserId = Auth::id();
        $user = User::findOrFail($id);

        if (($user) && ($user->id != $currentUserId)) {
            abort(404);
        }

        $userProfile = User::with('profile', 'userMetas')->find($id);

        $educationalDetails = EducationalDetail::where('user_id', $id)->get();
        $workDetails = WorkExperience::where('user_id', $id)->get();

        $q = User::with('profile');

        $fellowGraduates = false;

        if ($userProfile->profile->session) {
            $userSession = $userProfile->profile->session->name;
            $q->where(function ($q) use ($userSession, $userProfile) {
                $q->whereHas('profile', function ($q) use ($userSession, $userProfile) {
                    $q->where('user_id', '!=', $userProfile->id);
                    $q->whereHas('session', function ($q) use ($userSession) {
                        $q->where('name', $userSession);
                    });
                });
            });

            $q->whereHas('userType', function ($query) {
                $query->where('name', 'alumni');
            })->where('is_approved', 1)->where('is_deleted', 0);

            $fellowGraduates = $q->latest()->get();
        }
        
        $userMetas = UserMeta::UserMetas();

        return view('profiles.index')
            ->with('educationalDetails', $educationalDetails)
            ->with('workDetails', $workDetails)
            ->with('fellowGraduates', $fellowGraduates)
            ->with('userProfile', $userProfile)
            ->with('userMetas', $userMetas);;
    }

    public function edit($id)
    {
        $currentUserId = Auth::id();
        $user = User::findOrFail($id);

        if (($user) && ($user->id != $currentUserId)) {
            abort(404);
        }

        $profile = User::with('profile')->find($id);
        $degrees = Degree::all();
        $mentorshipTopics = MentorshipTopic::all();
        $countries = Country::all();
        $sessions = Session::all();
        $userTypes = UserType::all();
        $educationalDetails = EducationalDetail::where('user_id', $id)->get();
        $workDetails = WorkExperience::where('user_id', $id)->get();

        $userMetas = $profile->userMetas->pluck('value')->toArray();
        $selectedMentorshipTopics = $profile->metorshipTopics->pluck('id')->toArray();

        return view('profiles.edit')
            ->with('degrees', $degrees)
            ->with('countries', $countries)
            ->with('sessions', $sessions)
            ->with('userTypes', $userTypes)
            ->with('mentorshipTopics', $mentorshipTopics)
            ->with('userMetas', $userMetas)
            ->with('selectedMentorshipTopics', $selectedMentorshipTopics)
            ->with('educationalDetails', $educationalDetails)
            ->with('workDetails', $workDetails)
            ->with('profile', $profile);
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);

        if ($request->hasFile('profile_photo_url')) {
            $profile = $user->profile;
           
            $profileImage = $request->file('profile_photo_url');
            $saveImage = Image::make($profileImage->getRealPath())->fit(150);

            $profileImageSaveAsName = time() . Auth::id() . "-profile." . $profileImage->getClientOriginalExtension();
            
            Storage::put("public/profile/". $profileImageSaveAsName,  (string) $saveImage->encode());
           
            $profile->profile_photo_url = "profile/" . $profileImageSaveAsName;
            $profile->save();

            return redirect()->back()->with('success', 'Profile photo been successfully updated !');
        }

        if ($request->has('basic_info')) {

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->user_type_id = $request->user_type_id;
            $user->save();

            $profile = $user->profile;

            $profile->address = $request->address;
            $profile->session_id = $request->session_id;
            $profile->dist_state = $request->dist_state;
            $profile->country_id = $request->country_id;
            $profile->summary = $request->summary;
            $profile->save();

            $basicInfo = "active";

            return redirect()->back()->with('success', 'Information has been successfully updated !')->with('basicInfo', $basicInfo );
        }

        if ($request->has('personal_info')) {

            if (count($request->degree_id)) {

                $educationDataCount = count($request->degree_id);

                $now = Carbon::now()->toDateTimeString();

                $educationDetails = [];

                for ($i = 0; $i < $educationDataCount; $i++) {

                    $educationDetails[$i]['user_id'] = $id;
                    $educationDetails[$i]['field_of_study'] = $request->field_of_study[$i];
                    $educationDetails[$i]['degree_id'] = $request->degree_id[$i];
                    $educationDetails[$i]['passing_year'] = $request->passing_year[$i];
                    $educationDetails[$i]['institution'] = $request->institution[$i];
                    $educationDetails[$i]['created_at'] = $now;
                    $educationDetails[$i]['updated_at'] = $now;
                }

                EducationalDetail::where('user_id', $id)->delete();

                EducationalDetail::insert($educationDetails);
            }

            if (count($request->company_name)) {

                $workDataCount = count($request->company_name);

                $now = Carbon::now()->toDateTimeString();

                $workDetails = [];

                for ($i = 0; $i < $workDataCount; $i++) {

                     if (!empty($request->company_name[$i])) {

                         $workDetails[$i]['user_id'] = $id;
                         $workDetails[$i]['company_name'] = $request->company_name[$i];
                         $workDetails[$i]['job_title'] = $request->job_title[$i];
                         $workDetails[$i]['duration'] = $request->duration[$i];
                         $workDetails[$i]['created_at'] = $now;
                         $workDetails[$i]['updated_at'] = $now;
                     }

                }

                WorkExperience::where('user_id', $id)->delete();

                WorkExperience::insert($workDetails);
            }

            $profile = $user->profile;

            $profile->company_institute = $request->company_institution;
            $profile->position = $request->position;
            $profile->blood_group = $request->blood_group;

            if ($request->filled('dob')) {
                $profile->dob = Carbon::createFromFormat('d-m-Y', $request->dob)->format('Y-m-d');
            }
            
            $profile->contact_no = $request->contact_no;
            $profile->registration_number = $request->registration_number;
            $profile->save();

            $personalInfo = "active";

            return redirect()->back()->with('success', 'Information has been successfully updated  !')->with('personalInfo', $personalInfo );

        }

        if ($request->has('user_meta')) {

            $countMeta = count($request->willing_to_help);
            if (count($request->willing_to_help) && $request->willing_to_help[0] != null) {

                $now = Carbon::now()->toDateTimeString();

                $metaData = [];

                for ($i = 0; $i < $countMeta; $i++) {
                    $metaData[$i]['user_id'] = $id;
                    $metaData[$i]['key'] = 'willing_to_help';
                    $metaData[$i]['value'] = $request->willing_to_help[$i];
                    $metaData[$i]['created_at'] = $now;
                    $metaData[$i]['updated_at'] = $now;
                }

                UserMeta::where('user_id', $id)->delete();

                UserMeta::insert($metaData);
            } else {
                UserMeta::where('user_id', $id)->delete();
            }

            if (count($request->willing_to_help) && in_array("willing_to_be_mentor", $request->willing_to_help)) {
                if ($request->mentorship_topic && count($request->mentorship_topic)) {
                    $user = User::find($id);
                    $user->metorshipTopics()->sync($request->mentorship_topic);
                }
            } else {
                $user->metorshipTopics()->detach();
            }

            $wHelp = "active";

            return redirect()->back()->with('success', 'Information has been successfully updated !')->with('wHelp', $wHelp );

        }

        return redirect()->back()->with('error', 'Nothing is found to be updated !');

    }

    public function editPassword()
    {
        return view('profiles.password-update');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return redirect()->back()->with('error', 'Old password does not match');
        }

        $user = Auth::user();
        $user->password = bcrypt($request->new_password);
        $user->save();

        return redirect()->route('settings.personal')->with('success', 'Password has been updated');
    }

}
