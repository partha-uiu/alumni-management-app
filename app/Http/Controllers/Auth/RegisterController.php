<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
//use Validator;
use App\Degree;
use App\Department;
use App\EducationalDetail;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterFirstStepReview;
use App\Institution;
use App\MentorshipTopic;
use App\Profile;
use App\UserMeta;
use App\UserType;
use App\SocialAccount;
use App\HomeContent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Country;
use App\User;
use App\Session;
use Illuminate\Auth\Events\Registered;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Storage;
use Image;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function index()
    {
        $alumni = User::with('profile')->whereHas('userType', function ($query) {
            $query->where('name', 'alumni')
                ->orWhere('name', 'faculty-stuff')
                ->orWhere('name', 'student')
                ->where('is_approved', 1);
        })->latest()->limit(12)->get();

        return view('home.index')
            ->with('alumni', $alumni);
    }

    public function firstStep()
    {
        if (!session()->has('profile')) {
            $profileCollection = collect();
            session()->put('profile', $profileCollection);
        }

        $home = HomeContent::first();
        if (!$home) {
            $home = false;
        }

        $countries = Country::all();
        $sessions = Session::all();
        $userTypes = UserType::all();
        $department = Department::first();
        $institution = Institution::first();
        $userId = session('profile')->get('user_id');
        $socialAuth = false;

        return view('auth.register-step-1')
            ->with('countries', $countries)
            ->with('userTypes', $userTypes)
            ->with('sessions', $sessions)
            ->with('department', $department)
            ->with('institution', $institution)
            ->with('userId', $userId)
            ->with('socialAuth', $socialAuth)
            ->with('home', $home);
    }

    public function secondStep(Request $request)
    {
        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'dist_state' => 'required',
                'country_id' => 'required',
                'user_type_id' => 'required',
                'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/|confirmed|nullable',
            ],
                [
                    'first_name.required' => 'Please enter your first name',
                    'last_name.required' => 'Please enter your last name',
                    'email.required' => 'Please enter your email',
                    'dist_state.required' => 'Please enter your state/district',
                    'country_id.required' => 'Please enter your country',
                    'user_type_id.required' => 'Please enter your affiliation',
                    'password.required' => 'Password must be 8 digit ,at least one uppercase and contain number and character',
                ]);

            if ($validator->fails()) {

                return redirect()->route('register.step-1')
                    ->withErrors($validator)
                    ->withInput();
            }

            $profile = session()->get('profile');
            $allReq = collect($request->except(['_token', 'profile_photo_url']));

            $profileData = $profile->merge($allReq);

            session()->put('profile', $profileData);

            if ($request->filled('social_avatar')) {
                $url = $request->social_avatar;
                $profileSessionCollection = session()->get('profile');
                $profileSessionCollection->put('picture', $url);
                session()->put('profile', $profileSessionCollection);
            }

            if ($request->hasFile('profile_photo_url')) {

                // $userPhoto = $request->file('profile_photo_url');
                $userPhoto = $request->file('profile_photo_url');

                $saveImage = Image::make($userPhoto->getRealPath())->fit(120);

                $photoSaveAsName = time() . "-photo.". $userPhoto->getClientOriginalExtension();
                
                Storage::put("public/profile/". $photoSaveAsName,  (string) $saveImage->encode());

                $url = "profile/" . $photoSaveAsName;
                
                $profileSessionCollection = session()->get('profile');
                $profileSessionCollection->put('picture', $url);
                session()->put('profile', $profileSessionCollection);
            }

        } else {

            if (!session()->has('profile') || session('profile')->count() == 0) {
                return redirect()->route('register.step-1');
            }
        }
        $home = HomeContent::first();
        if (!$home) {
            $home = false;
        }
        $degrees = Degree::all();


        return view('auth.register-step-2')
            ->with('degrees', $degrees)
            ->with('home', $home);
    }

    public function thirdStep(Request $request)
    {
        $educationSessionCollection = session()->get('profile');

        $educationSessionCollection->put('field_of_study', $request->field_of_study);
        $educationSessionCollection->put('degree_id', $request->degree_id);
        $educationSessionCollection->put('passing_year', $request->passing_year);
        $educationSessionCollection->put('institution', $request->institution);

        session()->put('profile', $educationSessionCollection);

        $professionalAndPersonalSession = session()->get('profile');

        $professionalAndPersonalSession->put('company_institution', $request->company_institution);
        $professionalAndPersonalSession->put('position', $request->position);
        $professionalAndPersonalSession->put('blood_group', $request->blood_group);
        $professionalAndPersonalSession->put('dob', $request->dob);
        $professionalAndPersonalSession->put('contact_no', $request->contact_no);
        $professionalAndPersonalSession->put('registration_number', $request->registration_number);

        session()->put('profile', $professionalAndPersonalSession);

        $mentorshipTopics = MentorshipTopic::all();

        $home = HomeContent::first();
        if (!$home) {
            $home = false;
        }

        $session = session()->get('profile');

        $userType = $session->get('user_type_id');

        $q = UserType::where('id', $userType)->first();

        if ($q->name == "student") {
            return $this->register($request);
        }

        return view('auth.register-step-3')
            ->with('mentorshipTopics', $mentorshipTopics)
            ->with('home', $home);
    }

    protected function validator(array $data)
    {

    }

    public function register(Request $request)
    {

        if (!session()->has('profile') || session('profile')->count() == 0) {
            return redirect()->route('register.step-1');
        }

        event(new Registered($user = $this->create($request->all())));

        if (!$user->verified) {
            DB::beginTransaction();
            try {
                $email = new EmailVerification(new User(['email_token' => $user->email_token, 'first_name' => $user->first_name]));
                Mail::to($user->email)->send($email);
                DB::commit();

                return redirect()->route('register.success')->with('success_msg_email', 'Congratulation ! You have been successfully registered.Please verify your email');;
            } catch (Exception $e) {
                DB::rollback();
                return back();
            }
        } else {
            return redirect()->route('register.success')->with('success_msg_social', 'Congratulation ! You have been successfully registered.Please wait for Admin Approval');;
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $department = Department::first();
        $institution = Institution::first();

        $request = request();

        $session = collect(session('profile'));

        if(!$session) {
            return redirect()->route('register.step-1');
        }

        $email = $session->get('email');

        $user = User::where('email', $email)->first();

        if (!$user) {

            $verified = 0;

            if ($session->get('driver')) {
                $verified = 1;
            }

            $user = User::create([
                'first_name' => $session->get('first_name'),
                'last_name' => $session->get('last_name'),
                'email' => $session->get('email'),
                'user_type_id' => $session->get('user_type_id'),
                'password' => bcrypt($session->get('password')),
                'email_token' => str_random(10),
                'verified' => $verified
            ]);

            $userType = $user->userType->name;

            if ($userType == 'alumni') {  
                $user->assignRole('alumni');
            } elseif ($userType == 'faculty-stuff') {
                $user->assignRole('faculty-stuff');
            } elseif ($userType == 'student') {
                $user->assignRole('student');
            }

        } else {

            $userData = [];
            $userData['first_name'] = $session->get('first_name');
            $userData['last_name'] = $session->get('last_name');
            $userData['email'] = $session->get('email');
            $userData['user_type_id'] = $session->get('user_type_id');
            $userData['password'] = bcrypt($session->get('password'));

            $userUpdate = User::where('email', $email)
                ->update($userData);

            $user = User::where('email', $email)->first();
            $userType = $user->userType->name;

            if ($userType == 'alumni') {
                $user->assignRole('alumni');
            } elseif ($userType == 'faculty-stuff') {
                $user->assignRole('faculty-stuff');
            } elseif ($userType == 'student') {
                $user->assignRole('student');
            }
        }

        if ($session->get('dob')) {
            $dob = Carbon::createFromFormat('d-m-Y', $session->get('dob'))->format('Y-m-d');
        } else {
            $dob = null;
        }

        Profile::create([
            'user_id' => $user->id,
            'address' => $session->get('address'),
            'dist_state' => $session->get('dist_state'),
            'country_id' => $session->get('country_id'),
            'registration_number' => $session->get('registration_number'),
            'profile_photo_url' => $session->get('picture'),
            'session_id' => $session->get('session_id'),
            'department_id' => $department->id,
            'institution_id' => $institution->id,
            'company_institute' => $session->get('company_institution'),
            'position' => $session->get('position'),
            'dob' => $dob,
            'blood_group' => $session->get('blood_group'),
            'contact_no' => $session->get('contact_no'),
        ]);

        $userId = $user->id;


        $degreeId = $session->get('degree_id', []);

        if ($degreeId && count($degreeId) > 0) {


            $educationDataCount = count($degreeId);

            $now = Carbon::now()->toDateTimeString();

            $educationDetails = [];

            for ($i = 0; $i < $educationDataCount; $i++) {

                $educationDetails[$i]['user_id'] = $userId;
                $educationDetails[$i]['field_of_study'] = $session->get('field_of_study')[$i];
                $educationDetails[$i]['degree_id'] = $session->get('degree_id')[$i];
                $educationDetails[$i]['passing_year'] = $session->get('passing_year')[$i];
                $educationDetails[$i]['institution'] = $session->get('institution')[$i];
                $educationDetails[$i]['created_at'] = $now;
                $educationDetails[$i]['updated_at'] = $now;
            }

            EducationalDetail::where('user_id', $userId)->delete();

            EducationalDetail::insert($educationDetails);
        }

        $whlep = $request->get('willing_to_help', []);

        if (count($whlep) > 0) {

            $countMeta = count($whlep);

            $now = Carbon::now()->toDateTimeString();

            $metaData = [];

            for ($i = 0; $i < $countMeta; $i++) {
                $metaData[$i]['user_id'] = $userId;
                $metaData[$i]['key'] = 'willing_to_help';
                $metaData[$i]['value'] = $request->willing_to_help[$i];
                $metaData[$i]['created_at'] = $now;
                $metaData[$i]['updated_at'] = $now;
            }

            UserMeta::where('user_id', $userId)->delete();

            UserMeta::insert($metaData);
        }

        $mentorshipTopics = $request->get('mentorship_topic', []);

        if (count($mentorshipTopics)) {
            $user = User::find($userId);

            $user->metorshipTopics()->sync($mentorshipTopics);
        }

        if ($session->get('driver')) {
            $driver = $session->get('driver');
            $providerUserId = $session->get('providerUserId');
            $accessToken = $session->get('accessToken');

            $account = new SocialAccount([
                'user_id' => $user->id,
                'provider_user_id' => $providerUserId,
                'provider' => $driver,
                'access_token' => $accessToken,
            ]);
            $account->save();
        }

        session()->forget('profile');

        return $user;
    }

    public function verify($token)
    {   // The verified method has been added to the user model and chained here
        // for better readability
        User::where('email_token', $token)->firstOrFail()->verified();

        return redirect()->route('register.verified');
    }

    public function success()
    {
        $home = HomeContent::first();
        if (!$home) {
            $home = false;
        }

        return view('auth.success')->with('home', $home);
    }

    public function verified()
    {
        $home = HomeContent::first();
        if (!$home) {
            $home = false;
        }

        return view('auth.verified')->with('home', $home);
    }

    public function confirmation($id)
    {
        $user = User::findOrFail($id);

        if ($user->is_approved == 0 || $user->verified == 0) {
            return redirect()->route('cse-connect.home')->with('error', 'Your account is invalid !');

        }

        return redirect()->route('cse-connect.home');
    }

}
