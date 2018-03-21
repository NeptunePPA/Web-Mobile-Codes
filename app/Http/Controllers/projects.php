<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\clients;
use App\project;
use App\project_clients;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Session;
use App\User;
use Auth;
use App\userClients;

class projects extends Controller{

    public function index(Request $request)
    {
        $pagesize = $request->get('pagesize');
        if ($pagesize == "") {
            $pagesize = 10;
        }

            $organization = userClients::where('userId',Auth::user()->id)->select('clientId')->get();
            if($request->session()->has('adminclient'))
            {
                $organization = session('adminclient');
            }

        if (count($organization) > 0) {
            $projects = Project::join('project_clients', 'project_clients.project_id', '=', 'projects.id')
                    ->whereIn('project_clients.client_name', $organization)
                    ->select('projects.*')
                    ->orderBy('projects.id', 'desc')
                    ->groupBy('projects.id')
                    ->paginate($pagesize);


			$count =Project::join('project_clients', 'project_clients.project_id', '=', 'projects.id')
                    ->whereIn('project_clients.client_name', $organization)
                    ->select('projects.*')
                    ->orderBy('projects.id', 'desc')
                    ->groupBy('projects.id')
					->get();
            $count = count($count);
        } else {
            $projects = project::orderBy('id', 'desc')->paginate($pagesize);
            $count = project::count();
        }


        foreach ($projects as $project) {

            $project->clients = $project->projectclients;
            $project->clients_count = $project->clients->count();

            $projectclient = array();
            foreach ($project->clients as $client)
			{

                $client->clients_user_count = User::join('user_clients','user_clients.userId','=','users.id')
                    ->leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
                    ->where('user_projects.projectId', '=', $project->id)
                    ->where('user_clients.clientId', '=', $client->client_name)
                    ->where('users.roll', '=', 3)
                    ->where('users.status','!=','Disabled')
                    ->where('users.is_delete','!=','1');

//                    if (count($organization) > 0) {
//                        $client->clients_user_count = $client->clients_user_count->whereIn('user_clients.clientId', $organization);
//                    }
//                    ->groupBy('user_clients.clientId', 'users.projectname')
//                    ->distinct()
                $client->clients_user_count = $client->clients_user_count->count();

                $projectclient[] = $client->client_name;


            }

//dd($projectclient);
            if (count($organization) > 0) {
                $project->users_count = User::join('user_clients', 'user_clients.userId', '=', 'users.id')
                    ->leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
                    ->where('user_projects.projectId', '=', $project->id)
                    ->where('users.roll', '=', 3)
                    ->where('users.is_delete','!=','1')
                    ->whereIn('user_clients.clientId', $organization)
//                    ->distinct()
                    ->count();

            } else {


                $project->users_count = User::join('user_clients', 'user_clients.userId', '=', 'users.id')
                    ->leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
                    ->where('user_projects.projectId', '=', $project->id)
                    ->where('users.roll', '=', 3)
                    ->where('users.status','!=','Disabled')
                    ->where('users.is_delete','!=','1')
                    ->whereIn('user_clients.clientId', $projectclient)
                    ->count();
            }

        }
//         dd($projects);
        return view('pages.projects', compact('projects', 'count', 'pagesize'));
    }

    public function add(Request $request)
    {

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');
        }

        if (count($organization) > 0) {

            $clients = Clients::whereIn('id', $organization)->where('is_active', '=', '1')->pluck('client_name', 'id')->all();
        } else {
            $clients = Clients::where('is_active', '=', '1')->pluck('client_name', 'id')->all();
        }
        return view('pages.addproject', compact('clients'));
    }

    public function create(Request $request)
    {

        $rules = array(
            'project_name' => 'required|unique:projects,project_name'
        );


        $insertdata = array(
            'project_name' => $request->get('project_name'),
            'is_delete' => '0'
        );


        $validator = Validator::make($insertdata, $rules);

        if ($validator->fails()) {
            return Redirect::to('admin/projects/add')
                ->withErrors($validator);
        } else {
            $check_delete_projectname = project::where('project_name', '=', $request->get('project_name'))
                ->where('is_delete', '=', 0)->count();
            if ($check_delete_projectname >= 1) {
                return Redirect::to('admin/projects/add')
                    ->withErrors(['project_name' => 'Projectname already exist in database']);
            } else {

                $ck = 0;
                $ck = Project::insert($insertdata);
                if ($ck > 0) {
                    $pr_id = Project::get()->last();
                    $pr_id = $pr_id->id;
                    $client_names = $request->get('client_name');

                    if (isset($client_names) || !empty($client_names)) {
                        foreach ($client_names as $client_name) {
                            $project_client = array(
                                'project_id' => $pr_id,
                                'client_name' => $client_name
                            );
                            $pr = project_clients::insert($project_client);
                        }
                    }
                    return Redirect::to('admin/projects');
                } else {
                    return fail;
                }
            }
        }
    }

    public function edit(Request $request, $id)
    {

        $selected = Project_clients::where('project_id', '=', $id)->pluck('client_name')->all();

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');
        }

        if (count($organization) > 0) {
            $client_name = Clients::where('is_active', '=', '1')->whereIn('id', $organization)->pluck('client_name', 'id')->all();

        } else {
            $client_name = Clients::where('is_active', '=', '1')->pluck('client_name', 'id')->all();
        }


        $projects = Project::FindOrFail($id);
        $clients = Project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')->select('project_clients.id', 'clients.client_name')->where('project_clients.project_id', '=', $id)->get();
        return view('pages.editproject', compact('projects', 'clients', 'client_name', 'selected'));
    }

    public function update($id, Request $request)
    {

        $rules = array(
            'project_name' => 'required'
        );

        $updatedata = array(
            'project_name' => $request->get('project_name')
        );

        $validator = Validator::make($updatedata, $rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } else {
            $projectname = Input::get('project_name');
            $get_projectname = project::where('id', '=', $id)->value('project_name');

            if ($get_projectname != $projectname) {
                $check_projects = project::where('project_name', '=', $projectname)->count();
                if ($check_projects >= 1) {
                    return Redirect::back()
                        ->withErrors(['project_name' => 'Project name already exist in database.']);
                }
            }

            $client_names = $request->get('client_name');

            // Delete current data
            project_clients::where('project_id', $id)->delete();

            if (isset($client_names) && !empty($client_names)) {
                foreach ($client_names as $client_name) {
                    $project_client = array(
                        'project_id' => $id,
                        'client_name' => $client_name
                    );
                    project_clients::insert($project_client);
                }
            }
            $update_projectname = DB::table('projects')->where('id', '=', $id)->update($updatedata);
            return Redirect::to('admin/projects');
        }
    }

    public function clients_remove($id)
    {
        $remove_project_client = project_clients::FindOrFail($id);
        $remove_project_client->delete();

        return Redirect::back();
    }

    public function search(Request $request)
    {
        $projectname = $request['search'][0];
        if (Auth::user()->roll == 1) {
            $clientname = $request['search'][1];
        }

        $search_projects = project::leftJoin('project_clients', 'project_clients.project_id', '=', 'projects.id')->leftJoin('clients', 'clients.id', '=', 'project_clients.client_name')
            ->select('projects.*', 'clients.*', 'project_clients.*', 'projects.id as prid')
            ->orderBy('projects.id', 'desc')->groupBy('projects.id');

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');
        }
        if (count($organization) > 0) {
            $search_projects = $search_projects->whereIn('project_clients.client_name', $organization);
        }

        if (!empty($projectname)) {
            $search_projects = $search_projects->where('projects.project_name', 'LIKE', $projectname . '%');
        }
        if (!empty($clientname)) {
            $search_projects = $search_projects->where('clients.client_name', 'LIKE', $clientname . '%');
        }

        $search_project = $search_projects->get();

        foreach ($search_project as $row) {

            // $row->clients = $row->projectclients;
            // $row->clients_count = $row->clients->count();

            $row->clients = project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')
                ->select('project_clients.*', 'clients.*', 'clients.id as clientid')
                ->where('project_id', '=', $row->prid)
                ->get();
            $row->clients_count = $row->clients->count();


            $projectclient = array();
            foreach ($row->clients as $client) {

                $client->clients_user_count = User::join('user_clients', 'user_clients.userId', '=', 'users.id')
                    ->leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
                    ->where('user_projects.projectId', '=', $row->prid)
                    ->where('user_clients.clientId', '=', $client->clientid)
                    ->where('users.roll', '=', 3)
                    ->where('users.status','!=','Disabled')
                    ->where('users.is_delete','!=','1')
//                    ->groupBy('user_clients.clientId', 'users.projectname')
//                    ->distinct()
                    ->count();

                $projectclient[] = array($client->clientid);
            }

            if (count($organization) > 0) {
                $row->users_count = User::join('user_clients', 'user_clients.userId', '=', 'users.id')
                    ->leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
                    ->where('user_projects.projectId', '=', $row->prid)
                    ->where('users.roll', '=', 3)
                    ->where('users.status','!=','Disabled')
                    ->where('users.is_delete','!=','1')
                    ->whereIn('user_clients.clientId', $organization)
//                    ->distinct()
                    ->count();

            } else {

                $row->users_count = User::join('user_clients', 'user_clients.userId', '=', 'users.id')
                    ->leftjoin('user_projects','user_projects.userId','=','users.id')
                    ->where('user_projects.projectId','=',$row->prid)
                    ->where('users.roll', '=', 3)
                    ->where('users.status','!=','Disabled')
                    ->where('users.is_delete','!=','1')
                    ->whereIn('user_clients.clientId', $projectclient)
//                    ->distinct()
                    ->count();
            }

        }
        $data = $search_project;
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

    public function remove($id)
    {
        $removedata = array('is_delete' => '1');
        $remove_projects = DB::table('projects')->where('id', '=', $id)->delete();
        $remove_project_clients = DB::table('project_clients')->where('project_id', '=', $id)->delete();
        return Redirect::to('admin/projects');
    }

}
