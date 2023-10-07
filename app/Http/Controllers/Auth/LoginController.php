<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    // Google callback
    /*public function callback()
    {
        $user = Socialite::driver('google')->user();
        $this->_registerOrLoginUser($user);
        // Return home after login
        return redirect()->route('home');
    }*/
    public function handleGoogleCallback(){
        try {
            $user = Socialite::driver('google')->user();
            $this->_registerOrLoginUser($user);
            return view('home');
        }
        catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    public function redirectFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // facebook callback
    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            $this->_registerOrLoginUser($user);
            return view('home');
        }
        catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    protected function _registerOrLoginUser($data)
    {
        $user = User::where('email', '=', $data->email)->first();
        if (!$user) {
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->avatar = $data->avatar;
            $user->save();
        }
        Auth::login($user);
    }


}
