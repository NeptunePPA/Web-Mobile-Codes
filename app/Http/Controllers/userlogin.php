<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use Cookie;
use App\userClients;
use App\project_clients;
use App\LoginUser;
use Session;


class userlogin extends Controller
{
	
	public function showlogin()
	{
        if(!Auth::user())
        {
            $value = "False";
            if(isset($_COOKIE['neptune']))
            {
                $value = $_COOKIE['neptune'];
            }
            else
            {
                Cookie::queue(Cookie::make('neptune', 'True'));

            }

            return view('auth.userlogin',compact('value'));
        }
        else
        {

            return redirect()->back();
        }
	}
	
	public function dologin(Request $request)
	{
		$rules = array(
			'email' => 'required|email',
			'password' => 'required'
			);
		
		$validator = Validator::make(Input::all(),$rules);
		
		if($validator->fails())
		{
			return Redirect::to('login')->withErrors($validator);
		}
		else
		{
			$userdata = array(
				'email' => Input::get('email'),
				'password' => Input::get('password')
				);
			
			if(Auth::attempt($userdata))
			{
				
				if(Auth::user()->status == "Enabled")
				{
					$user = Auth::user()->roll;
					$agree = Auth::user()->is_agree;
					if($user == 1 || $user == 4)
					{
						Auth::logout();
						return Redirect::to('login')
						->withErrors(['email' =>'Please review your Login credential and/or Password.',]);
					}
					else
					{
						$data1['userId'] = Auth::user()->id;
						if($agree == 1)
						{
					 		//return Redirect('menu');

							$login = new LoginUser();
							$login->fill($data1);
							if($login->save()){

								return Redirect('selectclient');
							}
							
							/* -- 03/05/2017 -- */
							
						}
						else
						{
							$login = new LoginUser();
							$login->fill($data1);
							if($login->save()){

								return Redirect('agree');
							}
						}
					}
				}
				else
				{
					Auth::logout();
					return Redirect::to('login')
					->withErrors(['email' =>'This users is disabled from Neptune-PPA.',]);
				}
			}
			else
			{
				return Redirect::to('login')
				->withErrors(['email' =>'Login details are not correct.',]);
			}
		}
	}
	
	public function logout()
	{
		Auth::logout();
		Session::flush();
		return Redirect::to('login');
		
	}
	
	public function agree()
	{
		return view('pages.frontend.agree');
	}
	
	public function agreeconditions()
	{
		$agreebutton = Input::get('agreebutton');
		if($agreebutton == "Agree")
		{
			$id = Auth::user()->id;
			$updatedata = array('is_agree'=>'1');
			DB::table('users')->where('id','=',$id)->update($updatedata);
			if (Auth::user()->roll == 5) {
                return Redirect::to("repcasetracker");
            } else {
                return Redirect::to("selectclient");
            }
		}
		else
		{
			Auth::logout();
			return Redirect::to('login');
		}
	}


	/*After login continue with next step 03/05/2017 */
	public function logincontinue(Request $request){

		$data['clients'] = $request['clients'];

		if(Auth::user()->roll == 2)
		{
			$data['projects'] = $request['projects'];
		}
		$details = $data;

		$request->session()->put('details', $details);
		return redirect::to('menu');



	}
	public function clients()
	{
		
		$clients = ['0' => 'Select Client'] + userClients::leftJoin('clients','clients.id','=','user_clients.clientId')
		->where('user_clients.userId','=',Auth::user()->id)
		->pluck('clients.client_name','clients.id')
		->all();
		if (Auth::user()->roll == 5) {
                return Redirect::to("repcasetracker");
            } else {
               return view('pages.frontend.login.selectclients',compact('clients'));
            }
		
	}

	public function getprojects(Request $request){

		$clientid = $request['clientid'];
		$getprojectname = project_clients::where('client_name',$clientid)->get();
		foreach ($getprojectname as $row) {
			$row->project = $row->projectname->project_name;
		}
		$data = $getprojectname;
		if(count($data)){
			return[
			'value' => $data,
			'status' => TRUE
			];
		}
		else
		{
			return[
			'value' => 'No Result Found',
			'status' => FALSE
			];
		}
	}
}
