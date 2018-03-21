<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Redirect;
// use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;
use Session;

class AuthController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Registration & Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users, as well as the
      | authentication of existing users. By default, this controller uses
      | a simple trait to add these behaviors. Why don't you explore it?
      |
     */

// use ThrottlesLogins;
use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    //protected $redirectTo = '/admin/clients';



    protected $redirectAfterLogout = 'admin';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function redirectPath() {
        // Logic that determines where to send the user
		
		if(\Auth::user()->status == "Enabled")
		{
			if(\Auth::user()->is_agree == 1)
			{
				if (\Auth::user()->roll == '4') {
					return 'admin/orders';
				} else if (\Auth::user()->roll == 5) {
					return 'admin/repcasetracker';
				} else if (\Auth::user()->roll == 2) {
					return 'admin/clients';
				} else if (\Auth::user()->roll == 1) {
						return 'admin/clients';
				} else if (\Auth::user()->roll == 3) {
                    Session::flash('message', 'Invalid Credentials');
                    Auth::logout();
                    return 'admin';
                }

                 
			
			}
			else
			{
					return 'admin/agreeuser';
			
			}
		}
		else
		{
			Session::flash('message', 'This user is disable from Neptune-PPA Admin');
				Auth::logout();
				return 'admin/login';
		}
		
    }

    public function __construct() {
        // $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    public function getLogin() {
        //return view('login');
    }

    public function postLogin(Request $request) {
   
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');


        if (Auth::attempt($credentials, $request->has('remember'))) {
            if (Auth::user()->status == "Enabled") 
			{    

                

               
			    if(Auth::user()->roll != 3){
                   
					return redirect()->intended($this->redirectPath());
            	} else {
                    Auth::logout();
                    return redirect('admin/login')
                        ->withInput($request->only('email'))
                        ->withErrors([
                            'email' => 'This type of users can not able to login.',
                                ]);
                }
			} 
			else 
			{
                Auth::logout();
                return redirect('admin/login')
                                ->withInput($request->only('email'))
                                ->withErrors([
                                    'email' => 'You have been disabled from Neptune-PPA. Please try to contact with admin.',
                ]);
            }
        }
        return redirect('admin/login')
                        ->withInput($request->only('email'))
                        ->withErrors([
                            'email' => 'These credentials do not match our records.',
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users',
                    'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {
        return User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
        ]);
    }
	
	
	public function agreeuser()
	{
		return view('pages.dfjk');
	}

    
	
}
