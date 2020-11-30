<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    protected function attemptLogin(Request $request)
    {
        //if (Auth::attempt(['email' => $email, 'password' => $password, 'active' => 1])) {
        $input = $request->input();
        $username = explode('@', $input['email'])[0];

        // Get the user details from database and check if user is exist and active.
        if (filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email',$input['email'])->first();
        } else {
            $user = User::where('username',$input['email'])->first();
        }

        if($user){
            if (!$user->isActive()) {
                throw ValidationException::withMessages([$this->username() => __('User has been desactivated.')]);
            }
        } else {
            throw ValidationException::withMessages([$this->username() => __('Infos de connexion non valides !')]);
        }

        $credentials = [
            'username' => $user->username,
            'email' => $user->username . '' . config('app.ldap_domain'),
            'password' => $input['password']
        ];
        if ($user->is_ldap) {
            if (Auth::guard('ldap')->attempt($credentials)) {
                Auth::login($user);
                // Update du PWD LDAP local
                $ldapaccount = $user->ldapaccount;
                $ldapaccount->update( ['password' => Hash::make($credentials['password'])] );
                //return redirect()->intended('/');
                return $this->sendLoginResponse($request);
            }
        }

        // Or using the default guard you've configured, likely "users"
        if ($user->is_local) {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                return redirect()->intended('/');
            }
        }

        /*if (Auth::attempt(['email' => $input['email'], 'password' => $input['password'] ])) {
            // Authentication passed...
            return redirect()->intended('/');
        }*/
    }
}
