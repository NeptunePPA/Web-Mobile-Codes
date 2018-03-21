<?php

namespace App\Http\Controllers;

use App\category;
use App\physciansPreferenceAnswer;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Hash;
use Mail;
use Crypt;
use Auth;
use Excel;
use App\User;
use App\roll;
use App\userClients;
use App\manufacturers;
use App\project;
use App\clients;
use App\project_clients;
use App\order;
use App\Survey;
use App\SurveyAnswer;
use App\device;
use Carbon\Carbon;
use App\LoginUser;


class TrackingController extends Controller
{

    public function index()
    {
        print_r("hello test");
    }

    public function userAnalytics(Request $request)
    {

        $pagesize = $request->get('pagesize');
        if ($pagesize == "") {
            $pagesize = 10;
        }

        $getclient = $request->get('clients');
        $getdoctor = $request->get('doctor');
        $getproject = $request->get('project');

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');
        }

        if (count($organization) > 0) {



            $clients = ['' => 'All Client'] + clients::orderBy('client_name', 'asc')
                    ->whereIn('id', $organization)
                    ->where('is_active', '1')
                    ->pluck('client_name', 'id')->all();

            $physician = ['' => 'All Physician'] + User::physician()->where('users.is_delete', 0)->where('users.status', 'Enabled')
                    ->whereIn('user_clients.clientId', $organization)
                    ->where('users.roll', 3)
                    ->pluck('users.name', 'users.id')->all();

            $project = ['' => "All Project"] + project::leftjoin('project_clients', 'project_clients.project_id', '=', 'projects.id')
                    ->where('projects.is_delete', 0)
                    ->whereIn('project_clients.client_name', $organization)
                    ->pluck('projects.project_name', 'projects.id')->all();
//             dd($project);
        } else {

            $clients = ['' => 'All Client'] + clients::orderBy('client_name', 'asc')->where('is_active', '1')->pluck('client_name', 'id')->all();
            $physician = ['' => 'All Physician'] + User::where('is_delete', 0)
                    ->where('status', 'Enabled')
                    ->where('roll', 3)
                    ->pluck('name', 'id')->all();

            $project = ['' => "All Project"] + project::where('is_delete', 0)->pluck('project_name', 'id')->all();
        }


        $users = User::userdata();

        if ($getclient != "") {

            $users = $users->where('user_clients.clientId', $getclient);
        }

        if ($getdoctor != '') {
            $users = $users->where('users.id', $getdoctor);
        }

        if ($getproject != '') {
            $users = $users->where('projects.id', $getproject);
        }

        if (count($organization) > 0) {
            $users = $users->whereIn('user_clients.clientId', $organization);
        }

        $users = $users->groupBy('loginuser.userId')
            ->distinct()
            ->orderby('users.id', 'desc')
            ->paginate($pagesize);

        $counts = User::userdata();
        if ($getclient != "") {

            $counts = $counts->where('user_clients.clientId', $getclient);
        }

        if ($getdoctor != '') {
            $counts = $counts->where('users.id', $getdoctor);
        }

        if ($getproject != '') {
            $counts = $counts->where('projects.id', $getproject);
        }

        if (count($organization) > 0) {
            $counts = $counts->whereIn('user_clients.clientId', $organization);
        }

        $counts = $counts->groupBy('loginuser.userId')
            ->distinct()
            ->orderby('users.id', 'desc')
            ->get();


        $counts = count($counts);

        return view('pages.analytics.userAnalytics', compact('users', 'counts', 'pagesize', 'clients', 'getclient', 'physician', 'getdoctor', 'project', 'getproject'));
    }

    public function userAnalyticsSearch(Request $request)
    {
        $data = $request->all();
        $name = $data['search'][0];
        $email = $data['search'][1];
        $client = $data['search'][2];
        $roll = $data['search'][3];
        $project = $data['search'][4];

        $getclient = $data['getclient'] == 'NULL' ? '' : $data['getclient'];
        $getdoctor = $data['getdoctor'] == 'NULL' ? '' : $data['getdoctor'];
        $getproject = $data['getproject'] == 'NULL' ? '' : $data['getproject'];

        $search_user = User::leftjoin('roll', 'roll.id', '=', 'users.roll')
            ->leftjoin('orders', 'orders.orderby', '=', 'users.id')
            ->leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
            ->leftjoin('projects', 'projects.id', '=', 'user_projects.projectId')
            ->leftjoin('user_clients', 'user_clients.userId', '=', 'users.id')
            ->leftJoin('clients', 'clients.id', '=', 'user_clients.clientId')
            ->select('users.*', 'roll.roll_name', 'clients.client_name', 'projects.project_name')
            ->where('users.roll', '3')
            ->where('users.is_delete', '0');

//        $search_user = User::useranalytics()->where('users.is_delete', '0');


        if (!empty($name)) {
            $search_user = $search_user->where('users.name', 'LIKE', $name . '%');
        }

        if (!empty($email)) {
            $search_user = $search_user->where('users.email', 'LIKE', $email . '%');
        }

        if (!empty($client)) {
            $search_user = $search_user->where('clients.client_name', 'LIKE', $client . '%');
        }

        if (!empty($roll)) {
            $search_user = $search_user->where('roll.roll_name', 'LIKE', $roll . '%');
        }

        if (!empty($project)) {
            $search_user = $search_user->where('projects.project_name', 'LIKE', $project . '%');
        }


        if ($getclient != "") {

            $search_user = $search_user->where('user_clients.clientId', $getclient)->groupBY('user_clients.userId')->distinct();

        }

        if ($getdoctor != "") {

            $search_user = $search_user->where('users.id', $getdoctor)->groupBY('users.id')->distinct();

        }

        if ($getproject != "") {

            $search_user = $search_user->where('user_projects.projectId', $getproject)->groupBY('user_projects.projectId')->distinct();

        }

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();

        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');

        }

        if (count($organization) > 0) {

                $search_user = $search_user->whereIn('user_clients.clientId', $organization)->groupBY('users.id')->groupBY('users.roll');
        } else {
                $search_user = $search_user->groupBY('user_clients.userId')->groupBY('users.id')->groupBY('users.roll');

        }



        $data = $search_user->distinct()->orderby('users.id', 'desc')->get();
        // dd($data);
        foreach ($data as $row) {
            $row->userclient = $row->userclients;
            $clientstr = array();
            foreach ($row->userclients as $client) {
                $clientstr[] = $client->clientname['client_name'];
            }
            $row->clientarr = implode(",", $clientstr);
            $row->orders = $row->orders()->count();
            $row->login = $row->login()->count();
            $row->manufacturer = $row->manufacture['manufacturer_name'];

        }
//dd($data);
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

    public function userAnalyticsExport(Request $request)
    {

        $chkRep = $request['ck_rep'];
        $getclient = $request['getclient'];

        $users = User::leftjoin('roll', 'roll.id', '=', 'users.roll')
            ->leftjoin('orders', 'orders.orderby', '=', 'users.id')
            ->leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
            ->leftjoin('projects', 'projects.id', '=', 'user_projects.projectId')
            ->leftjoin('user_clients', 'user_clients.userId', '=', 'users.id')
            ->leftJoin('clients', 'clients.id', '=', 'user_clients.clientId')
            ->select('users.*', 'roll.roll_name', 'clients.client_name', 'projects.project_name')
            ->where('users.roll', '3')
            ->where('users.is_delete', '0');

        if ($getclient != "") {

            $users = $users->whereIn('users.id', $chkRep)->where('user_clients.clientId', $getclient)->groupBY('users.id')->orderby('users.id', 'desc')->where('users.is_delete', '0')->distinct()->get();

        } else {

            $users = $users->whereIn('users.id', $chkRep)->groupBY('user_clients.userId')->groupBY('users.id')->groupBY('users.roll')->orderby('users.id', 'desc')->distinct()->get();

        }

        foreach ($users as $row) {

            $resultstr = array();
            foreach ($row->userclients as $row1) {
                $resultstr[] = $row1->clientname['client_name'];
            }
            $row->client_name = implode(",", $resultstr);
            $row->roll_name = $row->role->roll_name;
//            $row->project_name = $row->prname['project_name'];
            $row->orders = $row->orders()->count();
            $row->login = $row->login()->count();
        }



        foreach ($users as $key) {

            $user_data[] = [
                $key['name'],
                $key['email'],
                $key['client_name'],
                $key['roll_name'],
                $key['project_name'],
                $key['login'],
                $key['orders']
            ];
        }
        // dd($user_data);
        $myFile = Excel::create('User_Analytics', function ($excel) use ($user_data) {

            $excel->setTitle('User Analytics');
            $excel->setCreator('Admin')->setCompany('Neptune-PPA');
            $excel->setDescription('User Analytics');

            $excel->sheet('User Analytics', function ($sheet) use ($user_data) {
                $sheet->row(1, array('Name', 'Email', 'Organization', 'Roll', 'Project', 'Login', 'Orders'));
                $sheet->row($sheet->getHighestRow(), function ($row) {
                    $row->setFontWeight('bold');
                });
                foreach ($user_data as $row) {
                    $sheet->appendRow($row);
                }
            });
        });

        $myFile = $myFile->string('xlsx');
        $response = array(
            'name' => "User_Analytics", //no extention needed
            'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($myFile) //mime type of used format
        );
        return response()->json($response);
        exit();

    }

    public function userAnalyticsView(Request $request, $id)
    {
        $pagesize = $request->get('pagesize');
        if ($pagesize == "") {
            $pagesize = 10;
        }
        $user = user::where('id', $id)->first();
        $order = order::where('orderby', $id)->orderby('id', 'desc')->orderby('created_at', 'desc')->groupBy('id')->paginate($pagesize);

        foreach ($order as $row) {
            $row['login'] = LoginUser::whereDate('created_at', '<=', \Carbon\Carbon::parse($row->order_date)->format('Y-m-d'))->where('userId', $row->orderby)->count();
            $row['logindate'] = LoginUser::whereDate('created_at', '=', \Carbon\Carbon::parse($row->order_date)->format('Y-m-d'))->where('userId', $row->orderby)->count();

            $row['ordercount'] = order::whereDate('order_date', '=', \Carbon\Carbon::parse($row->order_date)->format('Y-m-d'))->where('orderby', $id)->count();

            $row['order'] = order::whereDate('order_date', '<=', \Carbon\Carbon::parse($row->order_date)->format('Y-m-d'))->where('orderby', $id)->count();

            if (!empty($row->order_date)) {
                $date = (explode(" ", $row->order_date));
                $row->date = $row->order_date;
//                $row->time = $date[1];
            } else {
                $row->date = "-";
                $row->time = "-";
            }
        }

        $count = order::where('orderby', $id)->orderby('id', 'desc')->orderby('created_at', 'desc')->count();
        return view('pages.analytics.userview', compact('order', 'user', 'count', 'pagesize'));
    }

    public function userAnalyticsViewSearch(Request $request)
    {
        $search = $request->get('search');

        $date = $search[0];
        $device = $search[1];


        $user = $request->get('user');

//        $order = order::leftjoin('device', 'device.id', '=', 'orders.deviceId')->leftJoin('clients', 'clients.id', '=', 'orders.clientId')->select('orders.*', 'device.device_name as device', 'clients.client_name')->where('orderby', $user)->orderby('orders.id', 'desc');

        $order = order::where('orderby', $user)->orderby('id', 'desc')->orderby('created_at', 'desc');

        if (!empty($date)) {
            $order = $order->whereDate('order_date', 'LIKE', $date . '%');
        }

        if (!empty($device)) {
            $order = $order->where('model_name', 'LIKE', $device . '%');
        }

        $order = $order->groupBy('orders.id')->get();

        foreach ($order as $row) {

            $row['login'] = LoginUser::whereDate('created_at', '<=', \Carbon\Carbon::parse($row->order_date)->format('Y-m-d'))->where('userId', $row->orderby)->count();

            $row['logindate'] = LoginUser::whereDate('created_at', '=', \Carbon\Carbon::parse($row->order_date)->format('Y-m-d'))->where('userId', $row->orderby)->count();

            $row['ordercount'] = order::whereDate('order_date', '=', \Carbon\Carbon::parse($row->order_date)->format('Y-m-d'))->where('orderby', $user)->count();

            $row['order'] = order::whereDate('order_date', '<=', \Carbon\Carbon::parse($row->order_date)->format('Y-m-d'))->where('orderby', $user)->count();

            if (!empty($row->order_date)) {
                $date = (explode(" ", $row->order_date));
                $row->date = $row->order_date;
//                $row->time = $date[1];
            } else {
                $row->date = "-";
                $row->time = "-";
            }
        }

        $data = $order;

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

    public function userAnalyticsViewExport(Request $request)
    {

        $chkRep = $request['ck_rep'];

        $user = user::where('id', $request->get('user'))->first();

        $resultstr = array();
        foreach ($user->userclients as $row1) {
            $resultstr[] = $row1->clientname['client_name'];
        }
        $clients = implode(",", $resultstr);

//        $order = order::leftjoin('device', 'device.id', '=', 'orders.deviceId')->leftJoin('clients', 'clients.id', '=', 'orders.clientId')->select('orders.*', 'device.device_name as device', 'clients.client_name')->whereIn('orders.id', $chkRep)->orderby('orders.id', 'desc')->get();
        $order = order::whereIn('order_date', $chkRep)->where('orderby', $user['id'])->orderby('id', 'desc')->orderby('created_at', 'desc')->get();

        foreach ($order as $row) {
            $row['login'] = LoginUser::whereDate('created_at', '<=', \Carbon\Carbon::parse($row->order_date)->format('Y-m-d'))->where('userId', $row->orderby)->count();
            $row['logindate'] = LoginUser::whereDate('created_at', '=', \Carbon\Carbon::parse($row->order_date)->format('Y-m-d'))->where('userId', $row->orderby)->count();

            $row['ordercount'] = order::whereDate('order_date', '=', \Carbon\Carbon::parse($row->order_date)->format('Y-m-d'))->where('orderby', $user['id'])->count();

            $row['order'] = order::whereDate('order_date', '<=', \Carbon\Carbon::parse($row->order_date)->format('Y-m-d'))->where('orderby', $user['id'])->count();

            if (!empty($row->order_date)) {
                $date = (explode(" ", $row->order_date));
                $row->date = $row->order_date;
//                $row->time = $date[1];
            } else {
                $row->date = "-";
                $row->time = "-";
            }
        }

        foreach ($order as $row) {

            $order_data[] = [
                $row['order_date'],
                $row['logindate'],
                $row['ordercount'],
                $row['login'],
                $row['order'],
                $row['model_name'],
            ];
        }

        $myFile = Excel::create('User_Order_Analytics', function ($excel) use ($order_data, $user, $clients) {

            $excel->setTitle('User Order Analytics');
            $excel->setCreator('Admin')->setCompany('Neptune-PPA');
            $excel->setDescription('User Order Analytics');

            $excel->sheet('User Order Analytics', function ($sheet) use ($order_data, $user, $clients) {
                $sheet->row(1, array('User Details', $user['name'], $user['email'], $clients, $user->role->roll_name));
                $sheet->row(3, array('Order Date', '# of Logins', '# of Orders', '# Logins', '# Orders', 'Devices Ordered'));
                $sheet->row($sheet->getHighestRow(), function ($row) {
                    $row->setFontWeight('bold');
                });
                foreach ($order_data as $row) {
                    $sheet->appendRow($row);
                }
            });
        });

        $myFile = $myFile->string('xlsx');
        $response = array(
            'name' => "User_Order_Analytics", //no extention needed
            'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($myFile) //mime type of used format
        );
        return response()->json($response);
        exit();
    }


    public function organizationAnalytics(Request $request)
    {


        $pagesize = $request->get('pagesize');
        if ($pagesize == "") {
            $pagesize = 10;
        }

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();

        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');
        }

        if (count($organization) > 0) {


            $clients = ['' => 'All Client'] + clients::orderBy('client_name', 'asc')->whereIn('id', $organization)->where('is_active', '1')->pluck('client_name', 'id')->all();

            // dd($organization);
        } else {

            $clients = ['' => 'All Client'] + clients::orderBy('client_name', 'asc')->where('is_active', '1')->pluck('client_name', 'id')->all();

        }

        $getclient = $request->get('clients');
// dd($getclient);
        if (count($organization) > 0) {

            $organizations = clients::whereIn('id', $organization)->groupBy('id')->orderby('id', 'desc')->paginate($pagesize);
            $counts = clients::whereIn('id', $organization)->count();
        } else {

            $organizations = new clients();
            $organizations = $organizations->orderby('id', 'desc')->paginate($pagesize);
            $counts = clients::count();


        }

        if ($getclient != "") {
            $organizations = clients::organizationanal()
                ->where('clients.id', $getclient)
                ->groupBy('user_clients.clientId')
                ->where('users.roll', '3')
                ->where('users.status', 'Enabled')
                ->orderby('clients.id', 'desc')
                ->paginate($pagesize);
        }

        foreach ($organizations as $row) {

            $row->user = $row->leftjoin('user_clients', 'user_clients.clientId', '=', 'clients.id')
                ->leftJoin('users', 'users.id', '=', 'user_clients.userId')
                ->where('clients.id', '=', $row->id)->where('users.roll', '=', 3)
                ->count();

            $row->projectscount = $row->projectclients->count();
            $row->ordercount = $row->clientorders->count();
            $row->login = $row->leftjoin('user_clients', 'user_clients.clientId', '=', 'clients.id')
                ->leftjoin('users', 'users.id', '=', 'user_clients.userId')
                ->leftjoin('loginuser', 'loginuser.userId', '=', 'users.id')
                ->where('clients.id', '=', $row->id)
                ->where('users.roll', '=', 3)
                ->select('clients.*', DB::raw('count(loginuser.userId) as login'))->first();
            $row->login = $row->login->login;
        }
// dd($organizations);


        return view('pages.analytics.organizationAnalytics', compact('clients', 'getclient', 'organizations', 'counts', 'pagesize'));
    }


    public function organizationAnalyticsSearch(Request $request)
    {

        $data = $request->all();
        $clientname = $data['search'][0];
        $getclient = $data['dataclient'];

        $organization = new clients();

        if (!empty($clientname)) {

            $organization = $organization->where('clients.client_name', 'LIKE', $clientname . '%');
        }
        if (!empty($getclient)) {
            $organization = $organization->where('clients.id', $getclient);
        } else {

            $organizations = userClients::where('userId', Auth::user()->id)->select('clientId')->get();

            if ($request->session()->has('adminclient')) {
                $organizations = session('adminclient');

            }

            if (count($organizations) > 0) {

                $organization = $organization->whereIn('id', $organizations);
            }
        }

        $organization = $organization->orderby('id', 'desc')->get();

        foreach ($organization as $row) {

            $row->userscount = $row->leftjoin('user_clients', 'user_clients.clientId', '=', 'clients.id')
                ->leftJoin('users', 'users.id', '=', 'user_clients.userId')
                ->where('clients.id', '=', $row->id)->where('users.roll', '=', 3)
                ->count();

            $row->projectscount = $row->projectclients->count();
            $row->ordercount = $row->clientorders->count();
            $row->userlogin = $row->leftjoin('user_clients', 'user_clients.clientId', '=', 'clients.id')
                ->leftjoin('users', 'users.id', '=', 'user_clients.userId')
                ->leftjoin('loginuser', 'loginuser.userId', '=', 'users.id')
                ->where('clients.id', '=', $row->id)
                ->where('users.roll', '=', 3)
                ->select('clients.*', DB::raw('count(loginuser.userId) as login'))->first();
        }
        $data = $organization;

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

    public function organizationAnalyticsExport(Request $request)
    {
        $chkRep = $request['ck_rep'];
        $getclient = $request['getclient'];

        $organization = new clients();
        $organization = $organization->whereIn('id', $chkRep)->groupBy('id');


        // $organization = clients::organizationanal()->whereIn('clients.id',$chkRep)->groupBy('user_clients.clientId');

        if (!empty($getclient)) {
            $organization = $organization->whereIn('id', $chkRep)->where('id', $getclient)->orderby('id', 'desc')->get();
        } else {

            $organization = $organization->orderby('id', 'desc')->get();
        }


        foreach ($organization as $row) {

            $row->userscount = $row->leftjoin('user_clients', 'user_clients.clientId', '=', 'clients.id')
                ->leftJoin('users', 'users.id', '=', 'user_clients.userId')
                ->where('clients.id', '=', $row->id)->where('users.roll', '=', 3)
                ->count();

            $row->projectscount = $row->projectclients->count();
            $row->ordercount = $row->clientorders->count();
            $row->login = $row->leftjoin('user_clients', 'user_clients.clientId', '=', 'clients.id')
                ->leftjoin('users', 'users.id', '=', 'user_clients.userId')
                ->leftjoin('loginuser', 'loginuser.userId', '=', 'users.id')
                ->where('clients.id', '=', $row->id)
                ->where('users.roll', '=', 3)
                ->select('clients.*', DB::raw('count(loginuser.userId) as login'))->first();
            $row->login = $row->login->login;
        }

        foreach ($organization as $row) {

            $organization_data[] = [
                $row['client_name'],
                $row['userscount'],
                $row['login'],
                $row['projectscount'],
                $row['ordercount'],
            ];
        }

        $myFile = Excel::create('Organization_Analytics', function ($excel) use ($organization_data) {

            $excel->setTitle('Organization Analytics');
            $excel->setCreator('Admin')->setCompany('Neptune-PPA');
            $excel->setDescription('Organization Analytics');

            $excel->sheet('Organization Analytics', function ($sheet) use ($organization_data) {
                $sheet->row(1, array('Client Name', 'Total User', 'Total User Login', 'Total Project Count', 'Total Order Count'));
                $sheet->row($sheet->getHighestRow(), function ($row) {
                    $row->setFontWeight('bold');
                });
                foreach ($organization_data as $row) {
                    $sheet->appendRow($row);
                }
            });
        });

        $myFile = $myFile->string('xlsx');
        $response = array(
            'name' => "Organization_Analytics", //no extention needed
            'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($myFile) //mime type of used format
        );
        return response()->json($response);
        exit();
    }

    /*Organization analytics view start*/

    public function organizationAnalyticsView($id)
    {
        $users = User::useranalytics()->where('user_clients.clientId', $id)->groupBY('users.id')->groupBY('user_clients.clientId')->groupBy('loginuser.userId')->where('users.is_delete', '0')->orderby('users.id', 'desc')->get();
        foreach ($users as $row) {
            $row->ordercount = order::where('orders.clientId', '=', $id)->where('orders.orderby', '=', $row->id)->count();
        }


        return view('pages.analytics.organizationView', compact('users', 'id'));
    }

    public function organizationAnalyticsViewExport(Request $request)
    {
        $chkRep = $request['ck_rep'];
        $getclient = $request['getclient'];

        $users = User::useranalytics()->where('users.is_delete', '0')->orderby('users.id', 'desc');

        if ($getclient != "") {

            $users = $users->whereIn('users.id', $chkRep)->where('user_clients.clientId', $getclient)->groupBY('user_clients.userId', 'loginuser.userId')->distinct()->get();

        } else {

            $users = $users->whereIn('users.id', $chkRep)->groupBY('user_clients.clientId', 'user_clients.userId')->distinct()->get();

        }

        foreach ($users as $row) {


            $row->roll_name = $row->role->roll_name;
            $row->project_name = $row->project_name;
            $row->orders = order::where('orders.clientId', '=', $getclient)->where('orders.orderby', '=', $row->id)->count();
            $row->login = $row->login()->count();
        }

        // dd($users);

        foreach ($users as $key) {

            $user_data[] = [
                $key['name'],
                $key['email'],
                $key['client_name'],
                $key['roll_name'],
                $key['project_name'],
                $key['login'],
                $key['orders']
            ];
        }
        // dd($user_data);
        $myFile = Excel::create('Organization_Analytics_View', function ($excel) use ($user_data) {

            $excel->setTitle('User Analytics');
            $excel->setCreator('Admin')->setCompany('Neptune-PPA');
            $excel->setDescription('User Analytics');

            $excel->sheet('User Analytics', function ($sheet) use ($user_data) {
                $sheet->row(1, array('Name', 'Email', 'Organization', 'Roll', 'Project', 'Login', 'Orders'));
                $sheet->row($sheet->getHighestRow(), function ($row) {
                    $row->setFontWeight('bold');
                });
                foreach ($user_data as $row) {
                    $sheet->appendRow($row);
                }
            });
        });

        $myFile = $myFile->string('xlsx');
        $response = array(
            'name' => "Organization_Analytics_View", //no extention needed
            'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($myFile) //mime type of used format
        );
        return response()->json($response);
        exit();
    }

    public function organizationAnalyticsViewSearch(Request $request)
    {
        $data = $request->all();

        $name = $data['search'][0];
        $email = $data['search'][1];
        $client = $data['search'][2];
        $roll = $data['search'][3];
        $project = $data['search'][4];

        $dataclient = $data['dataclient'] == 'NULL' ? '' : $data['dataclient'];

        $search_user = User::leftjoin('roll', 'roll.id', '=', 'users.roll')
            ->leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
            ->leftjoin('projects', 'projects.id', '=', 'user_projects.projectId')
            ->leftjoin('user_clients', 'user_clients.userId', '=', 'users.id')
            ->leftJoin('clients', 'clients.id', '=', 'user_clients.clientId')
            ->select('users.*', 'roll.roll_name', 'clients.client_name', 'projects.project_name')
            ->where('users.roll', '3')
            ->where('users.is_delete', '0');


        if (!empty($name)) {
            $search_user = $search_user->where('users.name', 'LIKE', $name . '%');
        }

        if (!empty($email)) {
            $search_user = $search_user->where('users.email', 'LIKE', $email . '%');
        }

        if (!empty($client)) {
            $search_user = $search_user->where('clients.client_name', 'LIKE', $client . '%');
        }

        if (!empty($roll)) {
            $search_user = $search_user->where('roll.roll_name', 'LIKE', $roll . '%');
        }

        if (!empty($project)) {
            $search_user = $search_user->where('projects.project_name', 'LIKE', $project . '%');
        }


        if ($dataclient != "") {

            $search_user = $search_user->where('user_clients.clientId', $dataclient)->groupBY('user_clients.userId')->distinct();

        }

        $data = $search_user->orderby('users.id', 'desc')->get();
        // dd($data);
        foreach ($data as $row) {
            // $row->userclient = $row->userclients;
            // $clientstr = array();
            // foreach ($row->userclients as $client) {
            //   $clientstr[] = $client->clientname['client_name'];
            // }
            // $row->clientarr = implode(",", $clientstr);
            $row->orders = order::where('orders.clientId', '=', $dataclient)->where('orders.orderby', '=', $row->id)->count();
            $row->login = $row->login()->count();
            $row->manufacturer = $row->manufacture['manufacturer_name'];

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

    /*Organization analytics view end*/


    /*Order Analytics start*/

    public function orderAnalytics(Request $request)
    {

        $pagesize = $request->get('pagesize');
        if ($pagesize == "") {
            $pagesize = 10;
        }

        $clientname = $request->get('clientname');
        $items = $request->get('items');
        $status = $request->get('status');
        $physicianname = $request->get('physicianname');


        $getclient = $clientname;
        $getphysician = $physicianname;
        $getdevice = $items;
        $getstatus = $status;

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();

        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');

        }

        if (count($organization) <= 0) {

            $clients = ['' => 'All Client'] + clients::orderBy('client_name', 'asc')
                    ->where('is_active', '1')
                    ->pluck('client_name', 'id')->all();

            if ($clientname != "") {
                $physician = ['' => 'All Physicians'] + User::physician()->where('user_clients.clientId', $clientname)->where('users.roll', '=', 3)->pluck('users.name', 'id')->all();

            } else {
                $physician = ['' => 'All Physicians'] + User::physician()->where('users.roll', '=', 3)->pluck('users.name', 'id')->all();

            }


            $devices = ['' => 'All Items'] + device::orderBy('device_name', 'asc')->pluck('device_name', 'id')->all();

        } else {



            $clients = ['' => 'All Client'] + clients::orderBy('client_name', 'asc')
                    ->whereIn('id', $organization)
                    ->where('is_active', '1')
                    ->pluck('client_name', 'id')->all();

            if ($clientname != "") {
                $physician = ['' => 'All Physicians'] + User::physician()->whereIn('user_clients.clientId', $organization)->where('user_clients.clientId', $clientname)->where('users.roll', '=', 3)->pluck('users.name', 'id')->all();

            } else {
                $physician = ['' => 'All Physicians'] + User::physician()->whereIn('user_clients.clientId', $organization)->where('users.roll', '=', 3)->pluck('users.name', 'id')->all();

            }

            $devices = ['' => 'All Items'] + device::client()->whereIn('project_clients.client_name', $organization)->orderBy('device_name', 'asc')->pluck('device_name', 'id')->all();

        }


        $orderlist = order::orderBy('id', 'desc');


        if ($clientname != "") {
            $orderlist = $orderlist->where('clientId', $clientname);
        }

        if ($physicianname != "") {
            $orderlist = $orderlist->where('orderby', $physicianname);
        }

        if ($items != "") {
            $orderlist = $orderlist->where('deviceId', $items);
        }

        if ($status != "") {
            $orderlist = $orderlist->where('status', '=', $status);
        }
        if (count($organization) <= 0) {
            $counts = $orderlist->count();
            $orderlist = $orderlist->paginate($pagesize);

            foreach ($orderlist as $row) {
                $row['login'] = LoginUser::whereDate('created_at', '=', \Carbon\Carbon::parse($row->order_date)->format('Y-m-d'))->where('userId', $row->orderby)->count();
            }

        } else {
            $counts = $orderlist->whereIn('clientId', $organization)->count();
            $orderlist = $orderlist->whereIn('clientId', $organization)->paginate($pagesize);
            foreach ($orderlist as $row) {
                $row['login'] = LoginUser::whereDate('created_at', '=', \Carbon\Carbon::parse($row->order_date)->format('Y-m-d'))->where('userId', $row->orderby)->count();
            }

        }


//        dd($orderlist);
        return view('pages.analytics.ordersAnalytics', compact('clients', 'getclient', 'getphysician', 'physician', 'devices', 'getdevice', 'getstatus', 'orderlist', 'counts', 'pagesize'));
    }

    public function orderAnalyticsSearch(Request $request)
    {

        $search_data = $request->get('search');

        $clientname_search = $search_data[0];
        $orderby_search = $search_data[1];
        $manufacture_search = $search_data[2];
        $device_search = $search_data[3];
        $model_search = $search_data[4];
        $orderdate_search = $search_data[5];
        $logindate_search = $search_data[6];
        $status_search = $search_data[7];
        $complete_search = $search_data[8];
        $cancelled_search = $search_data[9];

        $clientname = '';
        $physicianname = '';
        $items = '';
        $status = '';

        $clientname = $request->get('clientname');
        $physicianname = $request->get('physicianname');
        $items = $request->get('items');
        $status = $request->get('status');

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();

        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');

        }


        $search_orders = order::leftjoin('manufacturers', 'manufacturers.id', '=', 'orders.manufacturer_name')
            ->leftjoin('users', 'users.id', '=', 'orders.orderby')
            ->leftjoin('clients', 'clients.id', '=', 'orders.clientId')
            ->where('orders.is_delete', '=', '0')
            ->select('orders.*', 'users.name as ob_name')
            ->orderby('orders.id', 'DESC');

        if (!empty($clientname_search)) {
            $search_orders = $search_orders->where('clients.client_name', 'LIKE', $clientname_search . '%');
        }
        if (!empty($manufacture_search)) {
            $search_orders = $search_orders->where('manufacturers.manufacturer_name', 'LIKE', $manufacture_search . '%');
        }
        if (!empty($device_search)) {
            $search_orders = $search_orders->where('orders.model_name', 'LIKE', $device_search . '%');
        }
        if (!empty($model_search)) {
            $search_orders = $search_orders->where('orders.model_no', 'LIKE', $model_search . '%');
        }
        if (!empty($orderdate_search)) {
            $search_orders = $search_orders->where('orders.order_date', 'LIKE', $orderdate_search . '%');
        }
        if (!empty($logindate_search)) {
            $search_orders = $search_orders->where('orders.order_date', 'LIKE', $logindate_search . '%');
        }
        if (!empty($orderby_search)) {
            $search_orders = $search_orders->where('users.name', 'LIKE', $orderby_search . '%');
        }
        if (!empty($status_search)) {
            $search_orders = $search_orders->where('orders.status', 'LIKE', $status_search . '%');
        }
        if (!empty($complete_search)) {
            $search_orders = $search_orders->where('orders.updated_at', 'LIKE', $complete_search . '%')->where('orders.status', 'Complete');
        }
        if (!empty($cancelled_search)) {
            $search_orders = $search_orders->where('orders.updated_at', 'LIKE', $cancelled_search . '%')->where('orders.status', 'Cancelled');
        }

        if ($clientname != "") {
            $search_orders = $search_orders->where('orders.clientId', $clientname);
        }

        if ($physicianname != "") {
            $search_orders = $search_orders->where('orders.orderby', $physicianname);
        }

        if ($items != "") {
            $search_orders = $search_orders->where('orders.deviceId', $items);
        }

        if ($status != "") {
            $search_orders = $search_orders->where('orders.status', '=', $status);
        }


        if (count($organization) <= 0) {
            $search_orders = $search_orders->get();
        } else {
            $search_orders = $search_orders->whereIn('orders.clientId', $organization)->get();
        }


        foreach ($search_orders as $row) {
            $row->cname = $row->orderclients['client_name'];
            $row->mname = $row->manufacturer['manufacturer_name'];
            $row->dname = $row->devicename['device_name'];
            $row->dmodel = $row->devicename['model_name'];
            $row->oby = $row->user['name'];
            $row->updated_date = Carbon::parse($row->updated_at)->format('Y-m-d');
            $row->login = LoginUser::whereDate('created_at', '=', \Carbon\Carbon::parse($row->order_date)->format('Y-m-d'))->where('userId', $row->orderby)->count();
        }

        $data = $search_orders;

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

    public function orderAnalyticsExport(Request $request)
    {

        $chkRep = $request['ck_rep'];

        $order = order::whereIn('id', $chkRep)->orderby('id', 'desc')->get();

        foreach ($order as $row) {
            $row->cname = $row->orderclients['client_name'];
            $row->mname = $row->manufacturer['manufacturer_name'];
            $row->dname = $row->devicename['device_name'];
            $row->dmodel = $row->devicename['model_name'];
            $row->oby = $row->user['name'];
            $row->update_at = Carbon::parse($row->updated_at)->format('Y-m-d');
            if ($row->status == "Complete") {
                $row->complete = $row->update_at;
            } else {
                $row->complete = "-";
            }
            if ($row->status == "Cancelled") {
                $row->cancelled = $row->update_at;
            } else {
                $row->cancelled = "-";
            }
            $row->login = LoginUser::whereDate('created_at', '=', \Carbon\Carbon::parse($row->order_date)->format('Y-m-d'))->where('userId', $row->orderby)->count();
        }

        foreach ($order as $row) {

            $order_data[] = [
                $row['cname'],
                $row['mname'],
                $row['dname'],
                $row['dmodel'],
                $row['order_date'],
                $row['login'],
                $row['order_date'],
                $row['oby'],
                $row['status'],
                $row['complete'],
                $row['cancelled']
            ];
        }

        $myFile = Excel::create('Order_Analytics', function ($excel) use ($order_data) {

            $excel->setTitle('Order Analytics');
            $excel->setCreator('Admin')->setCompany('Neptune-PPA');
            $excel->setDescription('Order Analytics');

            $excel->sheet('Order Analytics', function ($sheet) use ($order_data) {
                $sheet->row(1, array('Client Name', 'Manufacturer', 'Device Name', 'Model No.', 'Order Date', 'No of Login', 'Login Date', 'Ordered By', 'Status', 'Completion Date', 'Cancellation Date'));
                $sheet->row($sheet->getHighestRow(), function ($row) {
                    $row->setFontWeight('bold');
                });
                foreach ($order_data as $row) {
                    $sheet->appendRow($row);
                }
            });
        });

        $myFile = $myFile->string('xlsx');
        $response = array(
            'name' => "Order_Analytics", //no extention needed
            'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($myFile) //mime type of used format
        );
        return response()->json($response);
        exit();
    }

    /*Order Analytics end*/

    public function surveyAnalytics(Request $request)
    {

        $pagesize = $request->get('pagesize');
        if ($pagesize == "") {
            $pagesize = 10;
        }

        $getclient = $request->get('clients');
        $getdoctor = $request->get('doctor');
        $getcategory = $request->get('category');

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();

        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');

        }

        if (count($organization) > 0) {


            $clients = ['' => 'All Client'] + clients::orderBy('client_name', 'asc')->whereIn('id', $organization)->where('is_active', '1')->pluck('client_name', 'id')->all();
            if ($getclient != '') {
                $doctor = ['' => 'All Physician'] + User::physician()->where('user_clients.clientId', $getclient)
                        ->where('users.status', 'Enabled')
                        ->where('users.is_delete', '0')
                        ->where('users.roll', '3')
                        ->pluck('users.name', 'users.id')
                        ->all();
            } else {
                $doctor = ['' => 'All Physician'] + User::physician()->whereIn('user_clients.clientId', $organization)
                        ->where('users.status', 'Enabled')
                        ->where('users.is_delete', '0')
                        ->where('users.roll', '3')
                        ->pluck('users.name', 'users.id')
                        ->all();
            }

            // dd($organization);
        } else {

            $clients = ['' => 'All Client'] + clients::orderBy('client_name', 'asc')->where('is_active', '1')->pluck('client_name', 'id')->all();
            if ($getclient != '') {
                $doctor = ['' => 'All Physician'] + User::physician()->where('user_clients.clientId', $getclient)
                        ->where('users.status', 'Enabled')
                        ->where('users.is_delete', '0')
                        ->where('users.roll', '3')
                        ->pluck('users.name', 'users.id')
                        ->all();
            } else {

                $doctor = ['' => 'All Physician'] + User::where('status', 'Enabled')
                        ->where('is_delete', '0')
                        ->where('roll', '3')
                        ->pluck('name', 'id')
                        ->all();
            }
        }

        $category = ['' => 'All Category'] + category::where('is_active', '1')
                ->pluck('category_name', 'id')
                ->all();


        $survey = physciansPreferenceAnswer::searchsurvey();

        if ($getclient != '') {
            $survey = $survey->where('physciansPreferenceAnswer.clientId', $getclient);
        }
//
        if ($getdoctor != '') {
            $survey = $survey->where('physciansPreferenceAnswer.userId', $getdoctor);
        }
//
        if ($getcategory != '') {
            $survey = $survey->where('device.category_name', $getcategory);
        }
//
        if (count($organization) > 0) {
            $survey = $survey->whereIn('physciansPreferenceAnswer.clientId', $organization);
        }

        $survey = $survey->orderBy('physciansPreferenceAnswer.id', 'DESC')
            ->where('physciansPreferenceAnswer.flag', 'True')
            ->paginate($pagesize);

        /*Count of Data */
        $counts = physciansPreferenceAnswer::searchsurvey();

        if ($getclient != '') {
            $counts = $counts->where('physciansPreferenceAnswer.clientId', $getclient);
        }

        if ($getdoctor != '') {
            $counts = $counts->where('physciansPreferenceAnswer.userId', $getdoctor);
        }

        if ($getcategory != '') {
            $counts = $counts->where('device.category_name', $getcategory);
        }

        if (count($organization) > 0) {
            $counts = $counts->whereIn('physciansPreferenceAnswer.clientId', $organization);
        }

        $counts = $counts->where('physciansPreferenceAnswer.flag', 'True')->get();

        $counts = count($counts);

        return view('pages.analytics.surveyAnalytics', compact('survey', 'counts', 'pagesize', 'clients', 'category', 'getcategory', 'getclient', 'getdoctor', 'doctor'));
    }


    public function surveyAnalyticsSearch(Request $request)
    {
        $data = $request->all();
//        dd($data);
        $clientName = $data['search'][0];
        $doctor = $data['search'][1];
        $projects = $data['search'][2];
        $categories = $data['search'][3];
        $level_name = $data['search'][4];
        $manufacturer = $data['search'][5];
        $devices = $data['search'][6];
        $question = $data['search'][7];

        $dataclient = $request->get('dataclient');
        $datacategory = $request->get('datacategory');
        $dataPhysician = $request->get('dataPhysician');

        $searchfeatures = physciansPreferenceAnswer::searchsurvey();


        if (!empty($clientName)) {
            $searchfeatures = $searchfeatures->where('clients.client_name', 'LIKE', $clientName . '%');
        }
        if (!empty($doctor)) {
            $searchfeatures = $searchfeatures->where('users.name', 'LIKE', $doctor . '%');
        }
        if (!empty($projects)) {
            $searchfeatures = $searchfeatures->where('projects.project_name', 'LIKE', $projects . '%');
        }
        if (!empty($categories)) {
            $searchfeatures = $searchfeatures->where('category.category_name', 'LIKE', $categories . '%');
        }
        if (!empty($level_name)) {
            $searchfeatures = $searchfeatures->where('device.level_name', 'LIKE', $level_name . '%');
        }
        if (!empty($manufacturer)) {
            $searchfeatures = $searchfeatures->where('manufacturers.manufacturer_name', 'LIKE', $manufacturer . '%');
        }
        if (!empty($devices)) {
            $searchfeatures = $searchfeatures->where('device.device_name', 'LIKE', $devices . '%');
        }
        if (!empty($question)) {
            $searchfeatures = $searchfeatures->where('physciansPreferenceAnswer.question', 'LIKE', $question . '%');
        }

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();

        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');

        }


        if (count($organization) > 0) {


            $searchfeatures = $searchfeatures->whereIn('physciansPreferenceAnswer.clientId', $organization);
        }

        if ($dataclient != '') {
            $searchfeatures = $searchfeatures->where('physciansPreferenceAnswer.clientId', $dataclient);
        }

        if ($dataPhysician != '') {
            $searchfeatures = $searchfeatures->where('physciansPreferenceAnswer.userId', $dataPhysician);
        }

        if ($datacategory != '') {
            $searchfeatures = $searchfeatures->where('device.category_name', $datacategory);
        }


        $searchfeatures = $searchfeatures->orderBy('physciansPreferenceAnswer.id', 'DESC')
            ->where('physciansPreferenceAnswer.flag', 'True')->get();

        $data = $searchfeatures;

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

    public function surveyAnalyticsExport(Request $request)
    {

        $chkRep = $request['ck_rep'];
        $getclient = $request['getclient'];
        $getdoctor = $request['getphysician'];
        $getcategory = $request['getcategory'];


        $survey = physciansPreferenceAnswer::searchsurvey();

        if ($getclient != '') {
            $survey = $survey->where('physciansPreferenceAnswer.clientId', $getclient);
        }

        if ($getdoctor != '') {
            $survey = $survey->where('physciansPreferenceAnswer.userId', $getdoctor);
        }

        if ($getcategory != '') {
            $survey = $survey->where('device.category_name', $getcategory);
        }

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();

        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');

        }

        if (count($organization) > 0) {


            $survey = $survey->whereIn('physciansPreferenceAnswer.clientId', $organization);
        }

        $survey = $survey->orderBy('physciansPreferenceAnswer.id', 'DESC')
            ->where('physciansPreferenceAnswer.flag', 'True')
//            ->whereIn('physciansPreferenceAnswer.id',$chkRep)
            ->get();

        $survey_data = array();
        foreach ($survey as $key => $row) {

            $survey_data[$row->id] = [
                $row->client_name,
                $row->name,
                $row->project_name,
                $row->category_name,
                $row->level_name,
                $row->manufacturer_name,
                $row->device_name,
                $row->question,
                $row->queanswer_yes,
                $row->queanswer_no
            ];


        }
        $myFile = Excel::create('Survey_Analytics', function ($excel) use ($survey_data, $chkRep) {

            $excel->setTitle('Survey Analytics');
            $excel->setCreator('Admin')->setCompany('Neptune-PPA');
            $excel->setDescription('Survey Analytics');

            $excel->sheet('Survey Analytics', function ($sheet) use ($survey_data, $chkRep) {
                $sheet->row(1, array('Hospital', 'Physician', 'Project', 'Category', 'Level', 'Manuf', 'Device', 'Question', 'Yes', 'No'));
                $sheet->row($sheet->getHighestRow(), function ($row) {
                    $row->setFontWeight('bold');
                });

                foreach ($survey_data as $key => $row) {
                   if (in_array($key, $chkRep)) {
                        $sheet->appendRow($row);
                   }
                }
            });
        });

        $myFile = $myFile->string('xlsx');
        $response = array(
            'name' => "Survey_Analytics", //no extention needed
            'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($myFile) //mime type of used format
        );
        return response()->json($response);
        exit();


    }


    public function surveyAnalyticsView($id)
    {

    }

    public function surveyAnalyticsViewSearch(Request $request)
    {

    }


    /* survey data export*/
    public function surveryviewexport(Request $request)
    {

    }


}
