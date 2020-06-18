<?php

namespace App\Http\Controllers;

use App\Mail\EmailConfirmation;
use App\User;
use App\Country;
use App\Degree;
use App\EducationalDetail;
use App\MentorshipTopic;
use App\Session;
use App\UserMeta;
use App\UserType;
use App\UserActivity;
use App\WorkExperience;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

use Image;

class AlumniDirectoryController extends Controller
{
    public function index(Request $request)
    {
        $q = User::with('profile', 'userMetas')->whereHas('userType', function ($query) {
            $query->where('name', 'alumni')
                ->orWhere('name', 'student')
                ->orWhere('name', 'faculty-stuff');
        })->where('is_approved', 1)->where('is_deleted', 0);


        if ($request->filled('q')) {

            $searchText = $request->q;

            $q->where(function ($query) use ($searchText) {
                $query->where('first_name', 'like', '%' . $searchText . '%');
                $query->orWhere('last_name', 'like', '%' . $searchText . '%');
                $query->orWhere('email', 'like', '%' . $searchText . '%');
                $query->orWhereHas('profile', function ($query) use ($searchText) {
                    $query->where('company_institute', 'like', '%' . $searchText . '%');
                });
            });
        }

        $willingToHelp = $request->get('willing_to_help', []);

        if (count($willingToHelp) > 0 && $request->willing_to_help[0] != null) {
            foreach ($willingToHelp as $key => $val) {
                $q->where(function ($query) use ($val) {
                    $query->whereHas('userMetas', function ($query) use ($val) {
                        $query->where('value', '=', $val);
                    });
                });
            }

            $mentorshipTopics = $request->get('mentorship_topic', []);

            if (count($mentorshipTopics)) {
                $q->whereHas('metorshipTopics', function ($query) use ($mentorshipTopics) {
                    $query->whereIn('mentorship_topic_id', $mentorshipTopics);

                });
            }
        } else {
            $request->merge(['willing_to_help' => []]);
        }

        if ($request->filled('graduated')) {
            $graduatedSession = $request->graduated;

            $q->where(function ($query) use ($graduatedSession) {
                $query->whereHas('profile.session', function ($query) use ($graduatedSession) {
                    $query->where('name', $graduatedSession);
                });
            });
        }

        if ($request->filled('location')) {
            $location = $request->location;
            $q->where(function ($query) use ($location) {

                $query->orWhereHas('profile', function ($query) use ($location) {
                    $query->where('address', 'like', '%' . $location . '%');
                });
                $query->orWhereHas('profile', function ($query) use ($location) {
                    $query->where('dist_state', 'like', '%' . $location . '%');
                });
                $query->orWhereHas('profile.country', function ($query) use ($location) {
                    $query->where('name', 'like', '%' . $location . '%');
                });
            });
        }

        if ($request->filled('affiliation')) {
            $affiliation = $request->affiliation;
            if ($affiliation != 'all') {
                $q->where(function ($query) use ($affiliation) {
                    $query->whereHas('userType', function ($query) use ($affiliation) {
                        $query->where('name', $affiliation);

                    });
                });
            }
        }

        $qSessions = $request->get('session_id', []);
        if (isset($qSessions[0]) && $qSessions[0] != 'all') {
            if (count($qSessions)) {

                if ($qSessions != 'all') {

                    $sessions = $qSessions;

                    $q->where(function ($query) use ($sessions) {

                        $query->whereHas('profile.session', function ($query) use ($sessions) {
                            $query->whereIn('id', $sessions);

                        });
                    });
                }
            } else {
                $request->merge(['session_id' => []]);
            }
        }
        else {
            $request->merge(['session_id' => ['all']]);
        }

        if ($request->filled('work')) {

            $work = $request->work;

            $q->where(function ($query) use ($work) {
                $query->whereHas('profile', function ($query) use ($work) {
                    $query->where('company_institute', 'like', '%' . $work . '%');
                    $query->orWhere('position', 'like', '%' . $work . '%');

                });
            });
        }

        $alumni = $q->latest()->paginate(10);

        $allAlumni = User::with('profile', 'userMetas')->whereHas('userType', function ($query) {
            $query->where('name', '!=', null);
        })->where('verified', 1)->latest();

        if ($request->filled('q')) {
            $searchText = $request->q;

            $allAlumni->where(function ($query) use ($searchText) {
                $query->where('first_name', 'like', '%' . $searchText . '%');
                $query->orWhere('last_name', 'like', '%' . $searchText . '%');
                $query->orWhere('email', 'like', '%' . $searchText . '%');
                $query->orWhereHas('profile', function ($query) use ($searchText) {
                    $query->where('company_institute', 'like', '%' . $searchText . '%');
                    $query->orWhere('blood_group', 'like', '%' . $searchText . '%');
                });
            });
        }

        if ($request->filled('status')) {

            $status = $request->status;

            if ($status == 'approved') {
                $allAlumni->where('is_approved', '=', 1)
                    ->where('is_deleted', '=', 0);
            } elseif ($status == 'pending') {
                $allAlumni->where('is_approved', '=', 0)
                    ->where('is_deleted', '=', 0);

            } elseif ($status == 'deleted') {
                $allAlumni->where('is_deleted', '=', 1);

            }
        }

        if ($request->filled('affiliation')) {
            if ($affiliation != 'all') {
                $affiliation = $request->affiliation;
                $allAlumni->where(function ($query) use ($affiliation) {
                    $query->whereHas('userType', function ($query) use ($affiliation) {
                        $query->where('name', $affiliation);

                    });
                });
            }
        }

        if ($request->filled('graduated')) {
            $graduatedSession = $request->graduated;

            $allAlumni->where(function ($query) use ($graduatedSession) {
                $query->whereHas('profile.session', function ($query) use ($graduatedSession) {
                    $query->where('name', $graduatedSession);
                });
            });
        }

        $willingToHelp = $request->get('willing_to_help', []);

        if (count($willingToHelp) && $request->willing_to_help[0] != null) {
            foreach ($willingToHelp as $key => $val) {
                $allAlumni->where(function ($query) use ($val) {

                    $query->whereHas('userMetas', function ($query) use ($val) {
                        $query->where('value', '=', $val);

                    });
                });
            }

            $mentorshipTopics = $request->get('mentorship_topic', []);

            if (count($mentorshipTopics)) {
                $allAlumni->whereHas('metorshipTopics', function ($query) use ($mentorshipTopics) {
                    $query->whereIn('mentorship_topic_id', $mentorshipTopics);

                });
            }
        } else {
            $request->merge(['willing_to_help' => []]);
        }

        $allSessions = Session::all();
        $mentorshipTopics = MentorshipTopic::all();

        $qSessions = $request->get('session_id', []);

        if (isset($qSessions[0]) && $qSessions[0] != 'all') {

            if (count($qSessions)) {
                $sessions = $qSessions;
                $allAlumni->where(function ($query) use ($sessions) {

                    $query->whereHas('profile.session', function ($query) use ($sessions) {
                        $query->whereIn('id', $sessions);

                    });
                });

            } else {
                $request->merge(['session_id' => []]);
            }
        }
        else {
            $request->merge(['session_id' => ['all']]);
        }


        if ($request->filled('location')) {

            $location = $request->location;

            $allAlumni->where(function ($query) use ($location) {
                $query->orWhereHas('profile', function ($query) use ($location) {
                    $query->where('address', 'like', '%' . $location . '%');
                });
                $query->orWhereHas('profile', function ($query) use ($location) {
                    $query->where('dist_state', 'like', '%' . $location . '%');
                });
                $query->orWhereHas('profile.country', function ($query) use ($location) {
                    $query->where('name', 'like', '%' . $location . '%');
                });
            });
        }

        if ($request->filled('work')) {

            $work = $request->work;

            $allAlumni->where(function ($query) use ($work) {
                $query->whereHas('profile', function ($query) use ($work) {
                    $query->where('company_institute', 'like', '%' . $work . '%');
                    $query->orWhere('position', 'like', '%' . $work . '%');
                });
            });
        }

        $userMetas = UserMeta::UserMetas();

        $allAlumni = $allAlumni->paginate(10);

        return view('alumni-directory.index')
            ->with('alumni', $alumni)
            ->with('allAlumni', $allAlumni)
            ->with('sessions', $allSessions)
            ->with('mentorshipTopics', $mentorshipTopics)
            ->with('userMetas', $userMetas);
    }

    public function create()
    {
        return view('departments.create');
    }

    public function show($id)
    {
        $alumni = User::with('profile')->find($id);

        $educationalDetails = EducationalDetail::where('user_id', $id)->get();
        $workDetails = WorkExperience::where('user_id', $id)->get();

        $q = User::with('profile', 'userMetas');

        $fellowGraduates = false;

        if ($alumni->profile->session) {
            $userSession = $alumni->profile->session->name;
            $q->where(function ($q) use ($userSession, $alumni) {
                $q->whereHas('profile', function ($q) use ($userSession, $alumni) {
                    $q->where('user_id', '!=', $alumni->id);
                    $q->whereHas('session', function ($q) use ($userSession) {
                        $q->where('name', $userSession);
                    });
                });
            });

            $q->whereHas('userType', function ($query) {
                $query->where('name', 'alumni');
            })->where('is_approved', 1)->where('is_deleted', 0);

            $fellowGraduates = $q->latest()->limit(3)->get();

        }

        $userMetas = UserMeta::UserMetas();

        return view('alumni-directory.show')
            ->with('alumni', $alumni)
            ->with('fellowGraduates', $fellowGraduates)
            ->with('educationalDetails', $educationalDetails)
            ->with('workDetails', $workDetails)
            ->with('userMetas', $userMetas);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:departments'
        ]);

        $department = new Department;
        $department->name = $request->name;
        $department->save();

        return redirect()->back()->with('success', 'Department has been successfully added');
    }

    public function edit($id)
    {
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

        return view('alumni-directory.edit')
            ->with('degrees', $degrees)
            ->with('countries', $countries)
            ->with('sessions', $sessions)
            ->with('userTypes', $userTypes)
            ->with('mentorshipTopics', $mentorshipTopics)
            ->with('userMetas', $userMetas)
            ->with('selectedMentorshipTopics', $selectedMentorshipTopics)
            ->with('educationalDetails', $educationalDetails)
            ->with('profile', $profile)
            ->with('workDetails', $workDetails);
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);

        if ($request->hasFile('profile_photo_url')) {
            $profile = $user->profile;
            $profileImage = $request->file('profile_photo_url');

            $saveImage = Image::make($profileImage->getRealPath())->fit(150);

            $profileImageSaveAsName = time() . Auth::id() . "-profile." . $profileImage->getClientOriginalExtension();

            Storage::put("public/profile/" . $profileImageSaveAsName, (string)$saveImage->encode());

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

            return redirect()->back()->with('success', 'Information has been successfully updated !')->with('basicInfo', $basicInfo);
        }

        if ($request->has('personal_info')) {
            $degreeIdCount = $request->get('degree_id', []);

            if (count($degreeIdCount)) {

                $educationDataCount = count($degreeIdCount);

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

            if (count($request->company_name) && $request->company_name[0] != '') {

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

            return redirect()->back()->with('success', 'Information has been successfully updated  !')->with('personalInfo', $personalInfo);
        }

        if ($request->has('user_meta')) {
            $willingToHelp = $request->get('willing_to_help', []);
            $countMeta = count($willingToHelp);

            if (count($willingToHelp)) {
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

            if (count($willingToHelp) && in_array("willing_to_be_mentor", $willingToHelp)) {
                if (count($request->mentorship_topic)) {
                    $user = User::find($id);
                    $user->metorshipTopics()->sync($request->mentorship_topic);
                }
            } else {
                $user->metorshipTopics()->detach();
            }

            $wHelp = "active";

            return redirect()->back()->with('success', 'Information has been successfully updated  !')->with('wHelp', $wHelp);
        }

        return redirect()->back()->with('error', 'Nothing is found to be updated !');
    }

    public function destroy($id)
    {
        $checkDeletedUser = User::find($id);
        if ($checkDeletedUser->is_deleted == 1) {
            $checkDeletedUser->delete();
        } else {
            User::where('id', $id)->update(['is_deleted' => 1]);
        }

        return redirect()->back()->with('success', 'User has been successfully deleted !');
    }

    public function confirm($id)
    {
        User::where('id', $id)->update(['is_approved' => 1, 'is_deleted' => 0]);

        UserActivity::logActivity(Auth::user()->id, 'user_approved', ['relatable_type' => 'App\User', 'relatable_id' => $id]);


        $user = User::findOrFail($id);
        // Send user confirmation mail
        Mail::to($user->email)->send(new EmailConfirmation($user));

        return redirect()->back()->with('success', 'User has been successfully approved !');
    }

    public function batchAction(Request $request)
    {
        $action = $request->action;
        $ids = $request->ids;
        $arrayIds = explode(",", $ids);

        if ($action == 'delete') {
            User::whereIn('id', $arrayIds)->update(['is_deleted' => 1, 'is_approved' => 0]);
        } elseif ($action == 'approve') {
            User::whereIn('id', $arrayIds)->update(['is_approved' => 1, 'is_deleted' => 0, 'approved_by' => Auth::id()]);
            foreach ($arrayIds as $arrayId) {
                UserActivity::logActivity(Auth::user()->id, 'user_approved', ['relatable_type' => 'App\User', 'relatable_id' => $arrayId]);

            }
        } elseif ($action == 'disapprove') {
            User::whereIn('id', $arrayIds)->update(['is_approved' => 0, 'approved_by' => null]);
        }

        return redirect()->back()->with('success', 'Action Successfully Done !');
    }

}
