<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->hasAnyRole('admin|super-admin')) {
            return redirect()->route('admin.home');
        }

        return redirect()->route('feed');
    }

    public function credentials(Request $request)
    {
        return [
            'email' => $request->email,
            'password' => $request->password,
            'verified' => 1,
            'is_deleted' => 0
        ];
    }

    public function showLoginForm()
    {
        return redirect()->route('cse-connect.home');
    }

}
