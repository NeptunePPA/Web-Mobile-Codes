<?php

namespace App\Http\Controllers;

use App\UserMail;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\project;
use App\roll;
use App\User;
use Hash;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\clients;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Auth;
use App\manufacturers;
use App\project_clients;
use Mail;
use Session;
use Carbon;
// ScoreCard
use App\ScoreCard;
use App\ScoreCardImage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Month;

use App\userClients;
use App\userProjects;



class users extends Controller
{

    public function index(Request $request)
    {
        $pagesize = $request->get('pagesize');
        if ($pagesize == "") {
            $pagesize = 10;
        }

        $userid = Auth::user()->id;
        /*new update*/
        //$organization = userClients::where('userId',$userid)->select('clientId')->get();
        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');
        }
        if (count($organization) > 0) {
            $users = User::leftJoin('user_clients', 'user_clients.userId', '=', 'users.id')
                ->whereIn('user_clients.clientId', $organization)
                ->select('users.*')
                ->where('users.is_delete', '=', 0)
                ->where('users.roll', '!=', 5)
                ->orderby('users.id', 'DESC')
                ->groupBy('user_clients.userId')
                ->paginate($pagesize);

            $count = count(User::leftJoin('user_clients', 'user_clients.userId', '=', 'users.id')
                ->whereIn('user_clients.clientId', $organization)
                ->select('users.*')
                ->where('users.is_delete', '=', 0)
                ->where('users.roll', '!=', 5)
                ->orderby('users.id', 'DESC')
                ->groupBy('user_clients.userId')->get());

        } else {

            $users = user::select('users.*')
                ->where('is_delete', '=', 0)
                ->orderby('id', '=', 'DESC')
                ->paginate($pagesize);


            $count = user::where('is_delete', '=', 0)->count();

        }
        return view('pages.users', compact('users', 'count', 'pagesize'));
    }

    public function add(Request $request)
    {
        $projects = ['0' => 'Project Name'] + Project::pluck('project_name', 'id')->all();

        $rolls = [NULL => 'Roll'] + roll::pluck('roll_name', 'id')->all();

        $userid = Auth::user()->id;

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');
        }

        if (count($organization) > 0) {
            $clients = ['0' => 'Organization'] + clients::whereIn('id', $organization)->where('is_delete', '=', 0)->pluck('client_name', 'id')->all();
        } else {
            $clients = ['0' => 'Organization'] + clients::where('is_delete', '=', 0)->pluck('client_name', 'id')->all();
        }

        $manufacturers = [NULL => 'Manufactures'] + manufacturers::where('is_delete', '=', 0)->pluck('manufacturer_name', 'id')->all();

        return view('pages.adduser', compact('projects', 'rolls', 'clients', 'manufacturers'));
    }

    public function create(Request $request)
    {

        $role = $request->get('roll');

        $rules = array(
            'name' => 'required',
            'email' => 'required|unique:users,email|email',
            'roll' => 'required|not_in:0',
            'projectname' => 'required|not_in:0',
            'status' => 'required|not_in:0',
            'password' => 'required|alpha_dash|min:6|max:14',
            'password_confirmation' => 'required|same:password',
        );

        switch ($role) {
            case 0 :
            case 1 :
                unset($rules['projectname']);
                $validator = Validator::make($request->all(), $rules);

                $insertdata = array(
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'roll' => $request->get('roll'),
                    'status' => $request->get('status'),
                    'password' => Hash::make($request->get('password')),
                    'is_delete' => '0',
                    'mobile'=>$request->get('mobile'),
                    'title' => $request->get('title'),
                );

                break;
            case 2 :

                // $rules['clients'] = 'required|not_in:0';
                $rules['client_name'] = 'required|not_in:0';
                unset($rules['clients']);
                unset($rules['projectname']);
                $validator = Validator::make($request->all(), $rules);


                $insertdata = array(
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    //'organization' => $request->get('clients'),
                    'roll' => $request->get('roll'),
                    'status' => $request->get('status'),
                    'password' => Hash::make($request->get('password')),
                    'is_delete' => '0',
                    'mobile'=>$request->get('mobile'),
                    'title' => $request->get('title'),
                );


                break;
            case 3 :
                //$rules['clients'] = 'required|not_in:0';
                $rules['client_name'] = 'required|not_in:0';
                $rules['projectname'] = 'required|not_in:0';
                unset($rules['clients']);
                unset($rules['project_name']);
                $validator = Validator::make($request->all(), $rules);

                $insertdata = array(
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    //'organization' => $request->get('clients'),
//                    'projectname' => $request->get('projectname'),
                    'roll' => $request->get('roll'),
                    'status' => $request->get('status'),
                    'password' => Hash::make($request->get('password')),
                    'is_delete' => '0',
                    'mobile'=>$request->get('mobile'),
                    'title' => $request->get('title'),
                );

                break;
            case 4 :

                $rules['clients'] = 'required|not_in:0';
                unset($rules['projectname']);

                $validator = Validator::make($request->all(), $rules);

                $insertdata = array(
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'organization' => $request->get('clients'),
                    'roll' => $request->get('roll'),
                    'status' => $request->get('status'),
                    'password' => Hash::make($request->get('password')),
                    'is_delete' => '0',
                    'mobile'=>$request->get('mobile'),
                    'title' => $request->get('title'),
                );

                break;
            case 5:
                unset($rules['projectname']);
                $rules['client_name'] = 'required|not_in:0';
                $rules['manufacturer'] = 'required|not_in:0';
                $rules['mobile'] = 'required|numeric';
                $rules['title'] = 'required';
                $rules['profilePic'] = 'required';


                $validator = Validator::make($request->all(), $rules);


                $insertdata = array(
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'organization' => $request->get('manufacturer'),
                    'roll' => $request->get('roll'),
//                    'projectname' => $request->get('projectname'),
                    'status' => $request->get('status'),
                    'password' => Hash::make($request->get('password')),
                    'is_delete' => '0',
                    'mobile' => $request->get('mobile'),
                    'title' => $request->get('title')
                );

                break;
            default :
                break;
        }

        if ($validator->fails()) {
            return Redirect::to('admin/users/add')
                ->withErrors($validator)
                ->withInput($request->except('password'));
        } else {


            /*upload profilepic */
            if ($request->hasFile('profilePic')) {
                $image = $request->file('profilePic');
                $destinationpath = public_path() . '/upload/user';
                $extension = $image->getClientOriginalExtension();
                $filename = 'user' . '_' . date('m-d-y_hia') . '_' . rand(11111, 99999) . '.' . $extension;
                $image->move($destinationpath, $filename);
                $insertdata['profilePic'] = $filename;
            }

            $newUser = new user();
            $newUser->fill($insertdata);
            $newUser->save();
            $userid = $newUser->id;

            /*order client insert*/
            if (!empty($request->get('clients'))) {
                $userclient = array('userId' => $userid, 'clientId' => $request->get('clients'),'created_at' => Carbon\Carbon::now(),
                    'updated_at'=> Carbon\Carbon::now());
                $userclient = userClients::insert($userclient);
            }

            /*Project insert*/
            if (!empty($request->get('projectname'))) {
                $userproject = array(
                    'userId' => $userid,
                    'projectId' => $request->get('projectname'),
                    "created_at" => Carbon\Carbon::now(),
                    "updated_at" => Carbon\Carbon::now()

                );
                $userclient = userProjects::insert($userproject);
            }

            /* multi client insert */
            $client_names = $request->get('client_name');
            if (!empty($client_names)) {
                foreach ($client_names as $row) {
                    $user_clients = array(
                        'userId' => $userid,
                        'clientId' => $row,
                        "created_at" => Carbon\Carbon::now(),
                        "updated_at" => Carbon\Carbon::now()
                    );
                    $user_clients = userClients::insert($user_clients);
                }
            }

            /* multi project insert */
            $project_names = $request->get('project_name');
            if (!empty($project_names)) {
                foreach ($project_names as $row) {
                    $user_projects = array(
                        'userId' => $userid,
                        'projectId' => $row,
                        "created_at" => Carbon\Carbon::now(),
                        "updated_at" => Carbon\Carbon::now()

                    );
                    $user_projects = userProjects::insert($user_projects);
                }
            }

            /*Secure Mail User Save*/
            $secure['name'] = $request->get('name');
            $secure['email'] = $request->get('email');
            $secure['phoneNumber'] = $request->get('phoneNumber');
            $secure['password'] = Hash::make($request->get('password'));
            $secure['status'] = 'Enabled';

            $secureuser = new UserMail;
            $secureuser->fill($secure);

            if ($secureuser->save()) {

                $title1 = "Welcome to Neptune-PPA Secure Mail Server - Login Details";
                $email1 = $request->get('email');
                $password1 = $request->get('password');
                $name1 = $request->get('name');
                $data1 = array('title' => $title1, 'password' => $password1,
                    'email' => $email1, 'name' => $name1);

                $mail = Mail::send('emails.securemail_login', $data1, function ($message) use ($data1) {
                    $message->from('admin@neptuneppa.com', 'Neptune-PPA Secure Mail')->subject($data1['title']);
                    $message->to($data1['email']);
                    $message->cc('punit@micrasolution.com');
                });
            }

            if ($newUser) {
                $title = "Welcome to Neptune-PPA - Login Details ";
                $email = $request->get('email');
                $password = $request->get('password');
                $data = array('title' => $title, 'password' => $password,
                    'email' => $email);

                Mail::send('emails.createuser', $data, function ($message) use ($data) {
                    $message->from('admin@neptuneppa.com','Neptune-PPA')->subject($data['title']);
                    $message->to($data['email']);
                    $message->cc('punit@micrasolution.com');
                });
            }

            return redirect::to('admin/users');

        }
    }

    public function edit($id, Request $request)
    {


        $rolls = roll::pluck('roll_name', 'id')->all();

        $userid = Auth::user()->id;

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');

        }
        if (count($organization) > 0) {
            $clients = ['0' => 'Organization'] + clients::whereIn('id', $organization)->where('is_delete', '=', 0)->pluck('client_name', 'id')->all();

        } else {
            $clients = clients::where('is_delete', '=', 0)->pluck('client_name', 'id')->all();

        }
        $manufacturers = manufacturers::where('is_delete', '=', 0)->pluck('manufacturer_name', 'id')->all();

        $users = user::FindOrFail($id);
        $selectedclients = userClients::where('userId', $id)->pluck('clientId')->all();
        $projects = [NULL => 'Project Name'] + Project::leftjoin('project_clients','project_clients.project_id','=','projects.id')->whereIn('project_clients.client_name',$selectedclients)->pluck('projects.project_name', 'projects.id')->all();
        $selectproject = userProjects::where('userId',$id)->value('projectId');
        $selectedprojects = userProjects::where('userId', $id)->pluck('projectId')->all();

        return view('pages.edituser', compact('users', 'clients', 'rolls', 'users', 'projects', 'manufacturers', 'selectedclients', 'selectedprojects','selectproject'));
    }

    public function update($id, Request $request)
    {
        $role = $request->get('roll');
        $password = $request->get('password');

        $rules = array(
            'name' => 'required',
            'email' => 'required',
            'roll' => 'required|not_in:0',
            'projectname' => 'required|not_in:0',
            'status' => 'required|not_in:0'
        );

        if ($password) {
            $rules['password'] = 'required|alpha_dash|min:6|max:14';
            $rules['password_confirmation'] = 'required|same:password';
        }

        switch ($role) {
            case 0 :
            case 1 :

                unset($rules['projectname']);
                $updatedata = array(
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'organization' => "",
                    'projectname' => "",
                    'roll' => $request->get('roll'),
                    'status' => $request->get('status'),
                    'is_delete' => '0',
                    'mobile'=>$request->get('mobile'),
                    'title' => $request->get('title'),
                );
                $validator = Validator::make($request->all(), $rules);

                break;
            case 2 :


                // $rules['clients'] = 'required|not_in:0';
                $rules['client_name'] = 'required|not_in:0';
                unset($rules['clients']);
                unset($rules['projectname']);
                $updatedata = array(
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'organization' => "",
                    'projectname' => "",
                    'roll' => $request->get('roll'),
                    'status' => $request->get('status'),
                    'is_delete' => '0',
                    'mobile'=>$request->get('mobile'),
                    'title' => $request->get('title'),
                );
                $validator = Validator::make($request->all(), $rules);

                break;

            case 3:
                //$rules['clients'] = 'required|not_in:0';
                $rules['client_name'] = 'required|not_in:0';
                $rules['projectname'] = 'required|not_in:0';
                unset($rules['clients']);
                unset($rules['project_name']);
                $updatedata = array(
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'organization' => '',
                    'projectname' => '',
                    'roll' => $request->get('roll'),
                    'status' => $request->get('status'),
                    'is_delete' => '0',
                    'mobile'=>$request->get('mobile'),
                    'title' => $request->get('title'),
                );
                $validator = Validator::make($request->all(), $rules);

                break;
            case 4 :
                $rules['clients'] = 'required|not_in:0';
                unset($rules['projectname']);
                $updatedata = array(
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'organization' => "",
                    'projectname' => "",
                    'roll' => $request->get('roll'),
                    'status' => $request->get('status'),
                    'is_delete' => '0',
                    'mobile'=>$request->get('mobile'),
                    'title' => $request->get('title'),
                );
                $validator = Validator::make($request->all(), $rules);

                break;
            case 5:
                unset($rules['projectname']);
                $rules['manufacturer'] = 'required|not_in:0';
                $rules['mobile'] = 'required|numeric';
                $rules['title'] = 'required';


                $validator = Validator::make($request->all(), $rules);


                $updatedata = array(
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'organization' => $request->get('manufacturer'),
                    'roll' => $request->get('roll'),
//                    'projectname' => $request->get('projectname'),
                    'status' => $request->get('status'),
                    'is_delete' => '0',
                    'mobile' => $request->get('mobile'),
                    'title' => $request->get('title')
                );

                break;
            default :

                break;
        }

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } else {

            if ($password) {
                $updatedata['password'] = Hash::make($request->get('password'));
            }

            /*upload image*/
            if ($request->hasFile('profilePic')) {
                $image = $request->file('profilePic');
                $destinationpath = public_path() . '/upload/user';
                $extension = $image->getClientOriginalExtension();
                $filename = 'user' . '_' . date('m-d-y_hia') . '_' . rand(11111, 99999) . '.' . $extension;
                $image->move($destinationpath, $filename);
                $updatedata['profilePic'] = $filename;

            }


            if ($request->get('roll') == '1') {

                userClients::where('userId', $id)->delete();
                // print_r("expression");
            }


            userProjects::where('userId', $id)->delete();

            /*order client insert*/

            if (!empty($request->get('clients')) && $request->get('roll') != '1' && $request->get('roll') != '2') {
                // Delete current data
                userClients::where('userId', $id)->delete();


                $userclient = array('userId' => $id, 'clientId' => $request->get('clients'));
                $userclient = userClients::insert($userclient);
            }

            /*Project insert*/

            /*Project insert*/
            if (!empty($request->get('projectname')) && $request->get('roll') == 3) {

                userProjects::where('userId', $id)->delete();

                $userproject = array(
                    'userId' => $id,
                    'projectId' => $request->get('projectname'),
                    "created_at" => Carbon\Carbon::now(),
                    "updated_at" => Carbon\Carbon::now()

                );
                $userclient = userProjects::insert($userproject);
            }


            /* multi client insert */
            $client_names = $request->get('client_name');

            if (!empty($client_names) && $request->get('roll') != '4' && $request->get('roll') != '1') {
                // Delete current data
                userClients::where('userId', $id)->delete();

                foreach ($client_names as $row) {
                    $user_clients = array(
                        'userId' => $id,
                        'clientId' => $row,
                        "created_at" => Carbon\Carbon::now(),
                        "updated_at" => Carbon\Carbon::now()
                    );
                    $user_clients = userClients::insert($user_clients);
                }
            }

            /* multi project insert */
            $project_names = $request->get('project_name');

            if (!empty($project_names) && $request->get('roll') == 5) {
                // Delete current data
                userProjects::where('userId', $id)->delete();


                foreach ($project_names as $row) {
                    $user_projects = array(
                        'userId' => $id,
                        'projectId' => $row,
                        "created_at" => Carbon\Carbon::now(),
                        "updated_at" => Carbon\Carbon::now()
                    );
                    $user_projects = userProjects::insert($user_projects);
                }
            }

            $email = Input::get('email');
            $get_email = user::where('id', '=', $id)->value('email');
            if ($get_email == $email) {
                $get_username = DB::table('users')->where('id', '=', $id)->update($updatedata);
                return Redirect::to('admin/users');
            } else {
                $check_email = user::where('email', '=', $email)->count();
                if ($check_email >= 1) {
                    return Redirect::back()
                        ->withErrors(['email' => 'Email already exist in database.',]);
                } else {
                    $update_user = DB::table('users')->where('id', '=', $id)->update($updatedata);
                    return Redirect::to('admin/users');
                }
            }
        }
    }


    public function search(Request $request)
    {

        $data = $request->all();

        $selectclient = $request['selectclient'];

        $organizations = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organizations = session('adminclient');
        }

        if (Auth::user()->roll == 1) {
            $name = $data['search'][0];
            $email = $data['search'][1];
            $role = $data['search'][2];
            $organization = $data['search'][3];
            $manufacturer = $data['search'][4];
            $projects = $data['search'][5];
            $status = $data['search'][6];

        } else {
            $name = $data['search'][0];
            $email = $data['search'][1];
            $role = $data['search'][2];
            $organization = $data['search'][3];
            $projects = $data['search'][4];
            $status = $data['search'][5];
        }


        $search_user = User::leftjoin('roll', 'roll.id', '=', 'users.roll')
            ->leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
            ->leftjoin('projects', 'projects.id', '=', 'user_projects.projectId')
            ->leftjoin('user_clients', 'user_clients.userId', '=', 'users.id')
            ->leftJoin('clients', 'clients.id', '=', 'user_clients.clientId')
            ->leftJoin('manufacturers', 'manufacturers.id', '=', 'users.organization')
            ->select('users.*', 'roll.roll_name', 'clients.client_name', 'projects.project_name')
            ->where('users.is_delete', '=', 0)
            ->groupBy('users.id')
            ->orderby('users.id', 'DESC');

        if (!empty($name)) {
            $search_user = $search_user->where('users.name', 'LIKE', $name . '%');
        }
        if (!empty($email)) {
            $search_user = $search_user->where('users.email', 'LIKE', $email . '%');
        }
        if (!empty($role)) {
            $search_user = $search_user->where('roll.roll_name', 'LIKE', $role . '%');
        }
        if (!empty($organization)) {

            $search_user = $search_user->where('clients.client_name', 'LIKE', $organization . '%');
        }
        if (!empty($projects)) {
            $search_user = $search_user->where('projects.project_name', 'LIKE', $projects . '%');
        }
        if (!empty($manufacturer) && Auth::user()->roll == 1) {
            $search_user = $search_user->where('manufacturers.manufacturer_name', 'LIKE', $manufacturer . '%');
        }
        if (!empty($status)) {
            $search_user = $search_user->where('users.status', 'LIKE', $status . '%');
        }

        if (Auth::user()->roll == 2) {
            $search_user = $search_user->where('users.roll', '!=', 5);
        }
        if (count($organizations) > 0) {
            $search_user = $search_user->whereIn('user_clients.clientId', $organizations);
        }

        $data = $search_user->get();
//        dd($data);
        $selectclient = clients::where('id', $selectclient)->value('client_name');
        foreach ($data as $row) {
            $row->userclient = $row->userclients;
            $clientstr = array();
            foreach ($row->userclients as $client) {
                $clientstr[] = $client->clientname['client_name'];
            }
            $row->clientarr = $clientstr;

            $row->view = $selectclient != "" ? false : true;
            if (in_array($selectclient, $row->clientarr)) {
                $row->view = true;
            }
            $row->clientarr = implode(",", $clientstr);
            /*Multiple project start*/
            $projectstr = array();

            foreach ($row->usersproject as $project) {
                $projectstr[] = $project->projectname['project_name'];
            }

            $row->project_names = $projectstr;

//            $row->view = $selectclient != "" ? false : true;
//            if(in_array($selectclient, $row->project_name))
//            {
//                $row->view = true;
//            }
            $row->project_names = implode(",", $projectstr);
            $row->project_name = $row->roll == "5" ? $row->project_names : $row->project_name;

            $row->manufacturer = $row->roll == "5" ? $row->manufacture['manufacturer_name'] : '';

        }

        if (count($data))
            return [
                'value' => $data,
                'status' => TRUE
            ];
        else
            return [
                'value' => 'No result Found',
                'status' => FALSE
            ];

    }

    public function updateall()
    {
        $hiddenid = Input::get('hiddenid');
        $status = Input::get('status');
        foreach (array_combine($hiddenid, $status) as $userid => $user) {
            $updatedata = array('status' => $user);
            $ck = 0;
            $ck = DB::table('users')->where('id', '=', $userid)->update($updatedata);
        }

        return Redirect::to('admin/users');
    }

    public function remove($id)
    {
        $removedata = array('is_delete' => '1');
        $user = User::where('id',$id)->value('email');
        $remove = DB::table('users')->where('id', '=', $id)->delete();
        $remove_securemail = UserMail::where('email',$user)->delete();
        return Redirect::to('admin/users');
    }

    public function getprojectname()
    {

        $clientid = Input::get('clientid');

        if ($clientid == "") {
            $getprojectname = Project::select('project_name', 'id')->get();

        } else {
            if (!is_array($clientid)) {
                $clientid = array();
                $clientid[] = $clientid;
            }

            $getprojectname = project_clients::join('projects', 'projects.id', '=', 'project_clients.project_id')->distinct('projects.id')
                ->whereIn('project_clients.client_name', $clientid)
                ->select('projects.project_name', 'projects.id')
                ->get();

        }

        $data = $getprojectname;

        if (count($data))
            return [
                'value' => $data,
                'status' => TRUE
            ];
        else
            return [
                'value' => 'No Result Found',
                'status' => FALSE
            ];
    }

    public function getprojectnames(Request $request)
    {

        $clientid = Input::get('clientid');
        $getprojectname = Project::select('project_name', 'id')->get();

        if (!empty($clientid)) {
            $getprojectname = project_clients::join('projects', 'projects.id', '=', 'project_clients.project_id')->whereIn('project_clients.client_name', $clientid)->distinct('projects.id')->whereIn('project_clients.client_name', $clientid)->select('projects.project_name', 'projects.id')->groupBy('projects.id')->get();
        }

        $data = $getprojectname;

        if (count($data))
            return [
                'value' => $data,
                'status' => TRUE
            ];
        else
            return [
                'value' => 'No Result Found',
                'status' => FALSE
            ];
    }


    /*Physician ScoreCard Start*/

    public function phyScoreCard($id, Request $request)
    {
        $pagesize = $request->get('pagesize');
        if ($pagesize == "") {
            $pagesize = 10;
        }

        $user = User::where('id', $id)->first();

        $scorecard = ScoreCard::where('userId', $id)->orderBy('id', 'desc')->paginate($pagesize);

        $count = ScoreCard::where('userId', $id)->count();

        return view('pages.scorecard.scorecard', compact('user', 'scorecard', 'count', 'pagesize'));

    }

    public function phyScoreCardCreate(Request $request, $id)
    {
        $user = User::where('id', $id)->first();


        $month = Month::orderBy('id', 'asc')
            // ->whereNotIn('id', $monthName)
            ->pluck('month', 'id')->all();

        return view('pages.scorecard.addScoreCard', compact('user', 'month'));
    }

    public function phyScoreCardStore(Request $request, $id)
    {
        $rules = array(
            'monthId' => 'required',
            'year' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();

        }


        $data = $request->all();

        $data['monthId'] = $request['monthId'];
        $data['year'] = $request['year'];
        $data['userId'] = $id;

        // Validation multiple entry
        $clients = ScoreCard::where('year', $data['year'])->where('monthId', $data['monthId'])->where('userId', $data['userId'])->get();
        if (count($clients) > 0) {
            return redirect()->back()
                ->withErrors(['clientId' => 'You Entred Duplicate Record Please Try Another once!!',]);
        }

        $scorecard = new ScoreCard;
        $scorecard->fill($data);

        if ($scorecard->save()) {

            return redirect('admin/users/scorecard/' . $id);
        }

    }

    public function phyScoreCardEdit($id)
    {
        $score = ScoreCard::where('id', $id)->first();
        $scoreImage = ScoreCardImage::where('scorecardId', $id)->get();

        $month = Month::orderBy('id', 'asc')
            // ->whereNotIn('id', $monthName)
            ->pluck('month', 'id')->all();

        // $month = Month::orderBy('id','asc')->pluck('month','id')->all();

        return view('pages.scorecard.editScoreCard', compact('score', 'scoreImage', 'month'));
    }

    public function phyScoreCardView($id)
    {
        $score = ScoreCard::where('id', $id)->first();
        $user = User::where('id', $score['userId'])->first();
        $scoreImage = ScoreCardImage::where('scorecardId', $id)->orderBy('id', 'desc')->get();
        return view('pages.scorecard.viewScoreCard', compact('score', 'scoreImage', 'user'));
    }

    public function phyScoreCardUpdate($id, Request $request)
    {
        $rules = array(
            'monthId' => 'required',
            'year' => 'required',
//            'scorecardImage' => 'mimes:jpg,png,jpeg,gif',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();

        }

        $uid = $request['userId'];
        $scorecardImage = $request['scorecardImage'];
        $month = $request['monthId'];
        $data = $request->all();

        $clients = ScoreCard::where('year', $data['year'])->where('monthId', $data['monthId'])->where('userId', $data['userId'])->where('id', $id)->value('monthId');

        $flag1 = false;

        if ($month == $clients) {
            $flag1 = true;

        } else {
            if ($month != $clients) {
                $checkcard = ScoreCard::where('year', $data['year'])->where('monthId', $data['monthId'])->where('userId', $data['userId'])->first();
                $flag1 = $checkcard == null ? true : false;
                $checkcard == null ? '' : $errors['clientId'] = 'You Entred Duplicate Record Please Try Another once!!';
            }

        }

        if ($flag1) {

            $data = $request->except('scorecardImage', '_method', '_token');
            // dd($data);

            if ($request->hasFile('scorecardImage')) {
                foreach ($scorecardImage as $image) {

                    $extension = $image->getClientOriginalExtension();

                    $destinationpath = public_path() . '/upload/scorecard';
                    $filename = 'scorecard' . '_' . rand(1, 9999) . '.' . $extension;
                    $move = $image->move($destinationpath, $filename);

                    $dishesdata['scorecardId'] = $id;
                    $dishesdata['scorecardImage'] = 'upload/scorecard/' . $filename;
                    // dd($dishesdata['scorecardImage']);

                    $dishimage = new ScoreCardImage();
                    $dishimage->fill($dishesdata);
                    $dishimage->save();

                }

            }
            // dd($data);
            $updateProfile = ScoreCard::where('id', '=', $id)->update($data);

            return redirect('admin/users/scorecard/' . $uid);
        } else {

            return redirect()->back()
                ->withErrors(['clientId' => 'You Entred Duplicate Record Please Try Another once!!',]);

        }
    }

    public function phyScoreCardImageRemove(Request $request, $id)
    {
        $data = $request->all();
        // dd($request['chekImage']);
        $getimage = ScoreCardImage::whereIn('id', $request['chekImage'])->get();

        if ($getimage != "") {
            foreach ($getimage as $key) {
                $explodeimage = explode('/', $key['scorecardImage']);
                $filename = public_path() . '/upload/scorecard/' . $explodeimage[2];
                \File::delete($filename);
            }
        }
        $remove = ScoreCardImage::whereIn('id', $request['chekImage'])->delete();
        return Redirect::to('admin/users/scorecard/view/' . $id);

    }

    /*Scorecard Image Remove single start*/
    public function phyScoreCardSingleImageRemove($sId, $id)
    {

        $getimage = ScoreCardImage::where('id', $id)->get();

        if ($getimage != "") {
            foreach ($getimage as $key) {
                $explodeimage = explode('/', $key['scorecardImage']);
                $filename = public_path() . '/upload/scorecard/' . $explodeimage[2];
                \File::delete($filename);
            }
        }
        $remove = ScoreCardImage::where('id', $id)->delete();
        return Redirect::to('admin/users/scorecard/edit/' . $sId);

    }

    /*Scorecard Image Remove Single End*/

    public function phyScoreCardRemove(Request $request, $id)
    {

        $data = $request->all();

        $getimage = ScoreCardImage::whereIn('scorecardId', $data['ck_rep'])->get();
        if ($getimage != "") {
            foreach ($getimage as $key) {
                $explodeimage = explode('/', $key['scorecardImage']);
                $filename = public_path() . '/upload/scorecard/' . $explodeimage[2];
                \File::delete($filename);
            }
        }

        $remove = ScoreCard::whereIn('id', $data['ck_rep'])->delete();
        if ($remove)
            return [
                'value' => "Success",
                'status' => TRUE
            ];
        else
            return [
                'value' => 'No result Found',
                'status' => FALSE
            ];
    }

    public function phySCoreCardSearch(Request $request)
    {
        $data = $request->all();
        $userId = $data['userId'];
        $month = $data['search'][0];
        $year = $data['search'][1];

        $searchScorecard = ScoreCard::month()->where('scorecards.userId', $userId)->orderBy('scorecards.id', 'desc');
        if (!empty($month)) {
            $searchScorecard = $searchScorecard->where('month.month', 'LIKE', $month . '%');
        }

        if (!empty($year)) {
            $searchScorecard = $searchScorecard->where('year', 'LIKE', $year . '%');
        }
        $searchScorecard = $searchScorecard->orderBy('scorecards.id', 'DESC')->get();

        $data = $searchScorecard;

        if (count($data))
            return [
                'value' => $data,
                'status' => TRUE
            ];
        else
            return [
                'value' => 'No result Found',
                'status' => FALSE
            ];
    }
    /*Physicain Scorecard End*/

    /*migrate data*/
    public function migratedata()
    {
        /*get organization column*/
        $user_organization = User::whereIn('roll', [2, 3, 4])->select('id', 'organization', 'name', 'roll')->get();

        foreach ($user_organization as $row) {

            /*check existing data*/
            $user_clients = userClients::where('userId', $row->id)->first();
            if ($user_clients != "" && $row->organization != "") {
                $userclient_insert = array('userId' => $row->id,
                    'clientId' => $row->organization);
                $newclient = new userClients();
                $newclient->fill($userclient_insert);
                $newclient->save();
            }

        }

        // /*get projectname column*/
        $userproject = User::where('roll', 3)->select('id', 'projectname')->get();
        foreach ($userproject as $row) {
            echo $row->id . ' ' . $row->projectname;

            /*check existing data*/
            $user_projects = userProjects::where('userId', $row->id)->first();
            if ($user_projects == "" && $row->projectname != "") {
                $userproject_insert = array('userId' => $row->id,
                    'projectId' => $row->projectname);
                $newproject = new userProjects();
                $newproject->fill($userproject_insert);
                $newproject->save();

            }

        }


    }


    /*set session for administrator view*/
    public function setadminstratorclient(Request $request)
    {
        $client = $request['clients'];
        if ($client == 0) {
            $clients = $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
            $request->session()->put('adminclient', $clients);
        } else {
            $clients[] = $client;
            $request->session()->put('adminclient', $clients);
        }
        Session::forget('adminproject');
        return redirect::back();
    }

    public function setadminstratorclients(Request $request,$id)
    {
        $client = $id;
        if ($client == 0) {
            $clients = $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
            $request->session()->put('adminclient', $clients);
        } else {
            $clients[] = $client;
            $request->session()->put('adminclient', $clients);
        }
        // Session::destroy('adminproject');
        Session::forget('adminproject');

        return redirect::back();
    }

    public function setadminstratorprojects(Request $request,$id){
        $project = $id;

        if (empty($project)) {
            $projects = userProjects::leftjoin('projects','projects.id','=','user_projects.projectId')->where('user_projects.userId', Auth::user()->id)->select('projects.id')->get();
            $request->session()->put('adminproject', $project);
        } else {
            $projects[] = $project;
            $request->session()->put('adminproject', $project);
        }
        return redirect::back();
    }


    /*admin logout*/
    public function logoutadmin()
    {
        Auth::logout();
        Session::flush();
        return redirect('admin/login');

    }

    /*SEt User project table data migration start*/

    public function userProjectmigarte()
    {
        $user = User::where('roll', 5)->get();
        $data = array();
        foreach ($user as $item) {
            $data['userId'] = $item->id;
            $data['projectId'] = $item->projectname;

            $newclient = new userProjects();
            $newclient->fill($data);
            $newclient->save();

        }


    }

    /*Physician Data migrate in use project table start*/
    public function physicianDataMigrate(){
        $user = User::where('roll',3)->get();
        $data = array();

        foreach ($user as $item){
            if(!empty($item->projectname)){
                $data['userId'] = $item->id;
                $data['projectId'] = $item->projectname;

                $newclient = new userProjects();
                $newclient->fill($data);
                $newclient->save();
            }
        }
        print_r("Success..!! User Physician Data Migrate Complete.");
    }
    /*Physician Data migrate in use project table end*/
    /*SEt User project table data migration end*/

}
