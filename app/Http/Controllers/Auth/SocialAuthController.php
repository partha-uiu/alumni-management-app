<?php

namespace App\Http\Controllers\Auth;

use App\Country;
use App\Department;
use App\Institution;
use App\Session;
use App\SocialAccount;
use App\User;
use App\UserType;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * List of providers configured in config/services acts as whitelist
     *
     * @var array
     */
    protected $providers = [
        'facebook',
        'linkedin'
    ];

    /**
     * Show the social login page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
//    public function show()
//    {
//        return view('auth.social');
//    }

    /**
     * Redirect to provider for authentication
     *
     * @param $driver
     * @return mixed
     */
    public function redirectToProvider($driver)
    {
        if (!$this->isProviderAllowed($driver)) {
            return $this->sendFailedResponse("{$driver} is not currently supported");
        }

        try {
            $socialite = Socialite::driver($driver);
            if ($driver == 'linkedin') {
                $socialite->scopes(['r_basicprofile', 'r_emailaddress', 'rw_company_admin', 'w_share']);
            }
            return $socialite->redirect();
        } catch (Exception $e) {
// You should show something simple fail message
            return $this->sendFailedResponse($e->getMessage());
        }
    }

    /**
     * Handle response of authentication redirect callback
     *
     * @param $driver
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback($driver, Request $request)
    {
        if (!$request->has('code') || $request->has('denied')) {
            return redirect('/');
        }
        try {
            $user = Socialite::driver($driver)->user();
        } catch (Exception $e) {

            return $this->sendFailedResponse($e->getMessage());
        }

// check for email in returned user
        return empty($user->email)
            ? $this->sendFailedResponse("No email id returned from {$driver} provider.")
            : $this->loginOrCreateAccount($user, $driver);
    }

    /**
     * Send a successful response
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendSuccessResponse()
    {
        return redirect()->intended('/user/dashboard');
    }

    /**
     * Send a failed response with a msg
     *
     * @param null $msg
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedResponse($msg = null)
    {
        return redirect()->route('cse-connect.home')
            ->withErrors(['msg' => $msg ?: 'Unable to login, try with another provider to login.']);

    }

    protected function loginOrCreateAccount($providerUser, $driver)
    {
        if (!session()->has('profile')) {
            $profileCollection = collect();
            session()->put('profile', $profileCollection);
        }

        // check for already has account
        $account = SocialAccount::whereProvider($driver)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {

            $user = $account->user;

            if (!$user->is_deleted == 0) {
                return redirect()->back()->with('error', "Your account has been deleted");
            }
            Auth::login($user, true);

            return $this->sendSuccessResponse();

        } else {

            $partsOfName = explode(" ", $providerUser->getName());
            $lastName = array_pop($partsOfName);
            $firstName = implode(" ", $partsOfName);

            $userData = collect(
                [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $providerUser->getEmail(),
                    'avatar' => $providerUser->getAvatar(),
                    'driver' => $driver,
                    'providerUserId' => $providerUser->getId(),
                    'accessToken' => $providerUser->token,
                    'socailAuth' => 'socailAuth'
                ]
            );

            session()->put('profile', $userData);

            $countries = Country::all();
            $sessions = Session::all();
            $userTypes = UserType::all();
            $department = Department::first();
            $institution = Institution::first();

            $socialAuth = true;

            return view('auth.register-step-1')
                ->with('countries', $countries)
                ->with('userTypes', $userTypes)
                ->with('sessions', $sessions)
                ->with('department', $department)
                ->with('institution', $institution)
                ->with('socialAuth', $socialAuth);
        }
    }

    /**
     * Check for provider allowed and services configured
     *
     * @param $driver
     * @return bool
     */
    private function isProviderAllowed($driver)
    {
        return in_array($driver, $this->providers) && config()->has("services.{$driver}");
    }
}