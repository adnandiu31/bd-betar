<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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
     * @return string
     * @var string
     */
    public function redirectTo()
    {
        switch (Auth::user()->role->slug) {
            case 'admin':
                return route('admin.dashboard');
                break;
            case 'director-general':
                return route('directorGeneral.dashboard');
                break;
            case 'main-engineer':
                return route('mainEngineer.dashboard');
                break;
            case 'central-engineer':
                return route('centralEngineer.dashboard');
                break;
            case 'intent-officer':
                return route('intentOfficer.dashboard');
                break;
            case 'station-head':
                return route('stationHead.dashboard');
                break;
            case 'station-incharge':
                return route('stationIncharge.dashboard');
                break;
            case 'storekeeper':
                return route('storekeeper.dashboard');
                break;
            default:
                return route('home');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * The user has been authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $user->update([
            'last_login_at' => now()
        ]);
        // Show greetings.
        notify()->success("Hey $user->name, Welcome Back!", 'Success');
    }

    /**
     * The user has logged out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        // Show success msg.
        notify()->success('You have successfully logged out!', 'Success');
    }

}
