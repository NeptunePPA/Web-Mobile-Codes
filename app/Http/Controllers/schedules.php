<?php

namespace App\Http\Controllers;

use App\customContact;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\project;
use App\manufacturers;
use App\device;
use App\schedule;
use App\User;
use App\clients;
use App\project_clients;
use App\order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Auth;
use Mail;
use Response;
use Storage;
use App\userClients;
use Carbon\Carbon;
use App\RepContact;


class schedules extends Controller
{

    public function index(Request $request)
    {
        $pagesize = $request->get('pagesize');
        if ($pagesize == "") {
            $pagesize = 10;
        }

        $userid = Auth::user()->id;
        //$organization = user::where('id', '=', $userid)->value('organization');

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');

        }

        if (count($organization) > 0) {


            $schedules = schedule::leftjoin('projects', 'projects.id', '=', 'schedule.project_name')
                ->leftjoin('users', 'users.id', '=', 'schedule.physician_name')
                ->leftjoin('manufacturers', 'manufacturers.id', '=', 'schedule.manufacturer')
                ->leftjoin('device', 'device.id', '=', 'schedule.device_name')
                ->leftjoin('clients', 'clients.id', '=', 'schedule.client_name')
                ->leftjoin('user_clients', 'user_clients.userId', '=', 'users.id')
                ->whereIn('schedule.client_name', $organization)
                ->select('schedule.*', 'clients.client_name', 'users.name', 'manufacturers.manufacturer_name', 'device.device_name as device', 'projects.project_name as pro_name')
                ->where('schedule.is_delete', '=', '0')->orderby('schedule.id', '=', 'DESC')
                ->groupBy('schedule.id')
                ->paginate($pagesize);

            $count = schedule::leftjoin('projects', 'projects.id', '=', 'schedule.project_name')
                ->leftjoin('users', 'users.id', '=', 'schedule.physician_name')
                ->leftjoin('manufacturers', 'manufacturers.id', '=', 'schedule.manufacturer')
                ->leftjoin('device', 'device.id', '=', 'schedule.device_name')
                ->leftjoin('clients', 'clients.id', '=', 'schedule.client_name')
                ->leftjoin('user_clients', 'user_clients.userId', '=', 'users.id')
                ->whereIn('schedule.client_name', $organization)
                ->select('schedule.*', 'clients.client_name', 'users.name', 'manufacturers.manufacturer_name', 'device.device_name as device', 'projects.project_name as pro_name')
                ->where('schedule.is_delete', '=', '0')->orderby('schedule.id', '=', 'DESC')
                ->groupBy('schedule.id')
                ->get();
            $count = count($count);
            // dd($count);
        } else {
            $schedules = schedule::leftjoin('projects', 'projects.id', '=', 'schedule.project_name')
                ->leftjoin('users', 'users.id', '=', 'schedule.physician_name')
                ->leftjoin('manufacturers', 'manufacturers.id', '=', 'schedule.manufacturer')
                ->leftjoin('device', 'device.id', '=', 'schedule.device_name')
                ->leftjoin('clients', 'clients.id', '=', 'schedule.client_name')
                ->select('schedule.*', 'clients.client_name', 'users.name', 'manufacturers.manufacturer_name', 'device.device_name as device', 'projects.project_name as pro_name')
                ->where('schedule.is_delete', '=', '0')
                ->orderby('schedule.id', '=', 'DESC')
                ->groupBy('schedule.id')
                ->paginate($pagesize);

            $count = schedule::leftjoin('projects', 'projects.id', '=', 'schedule.project_name')
                ->leftjoin('users', 'users.id', '=', 'schedule.physician_name')
                ->leftjoin('manufacturers', 'manufacturers.id', '=', 'schedule.manufacturer')
                ->leftjoin('device', 'device.id', '=', 'schedule.device_name')
                ->leftjoin('clients', 'clients.id', '=', 'schedule.client_name')
                ->where('schedule.is_delete', '=', 0)->count();


        }


        return view('pages.schedule', compact('schedules', 'count', 'physician', 'manufacturer', 'devices', 'pagesize'));
    }

    public function add(Request $request)
    {
        $userid = Auth::user()->id;
        //$organization = user::where('id', '=', $userid)->value('organization');

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');

        }

        if (count($organization) > 0) {

            $projects = [NULL => 'Project Name'] + project_clients::leftjoin('projects', 'projects.id', '=', 'project_clients.project_id')
                    ->whereIn('project_clients.client_name', $organization)
                    ->where('projects.is_delete', '=', 0)
                    ->distinct('project.id')
                    ->pluck('projects.project_name', 'projects.id')->all();

            $clients = [NULL => 'Client Name'] + clients::whereIn('id', $organization)->where('is_delete', '=', 0)->pluck('client_name', 'id')->all();

        } else {
            $clients = [NULL => 'Client Name'] + clients::where('is_delete', '=', 0)->pluck('client_name', 'id')->all();
            $projects = [NULL => 'Project Name'] + Project::where('is_delete', '=', 0)->pluck('project_name', 'id')->all();
        }


        $manufacturer = ['0' => 'Select Manufacturer'] + Manufacturers::where('is_delete', '=', 0)->pluck('manufacturer_name', 'id')->all();
        $devices = ['0' => 'Select Device'] + device::where('is_delete', '=', 0)->pluck('device_name', 'id')->all();
        $physician = ['0' => 'Select Physician'] + User::where('is_delete', '=', 0)->where('roll', 3)->pluck('name', 'id')->all();
        return view('pages.addschedule', compact('projects', 'manufacturer', 'devices', 'physician', 'clients'));
    }

    public function create(Request $request)
    {

        $hours = $request->get('start_time_hours');
        $minutes = $request->get('start_time_minutes');
        $time = $request->get('start_time');
        if ($minutes == '0' && $hours == '0') {
            return Redirect::back()
                ->withErrors(['Time' => 'please Enter Valid Time..!!'])
                ->withInput();
        }

        if (strlen($minutes) < 2 && strlen($hours) < 2) {
            $starttime = '0' . $hours . ':0' . $minutes . " " . $time;
        } else if (strlen($hours) < 2) {
            $starttime = '0' . $hours . ':' . $minutes . " " . $time;
        } else if (strlen($minutes) < 2) {
            $starttime = $hours . ':0' . $minutes . " " . $time;
        } else {
            $starttime = $hours . ':' . $minutes . " " . $time;
        }

        $t = Carbon::parse($starttime)->setTimezone('UTC')->format('His');
        // dd($t);
        $rules = array(
            'project_name' => 'required|not_in:0',
            'manufacturer' => 'required|not_in:0',
            'physician_name' => 'required|not_in:0',
            'device_name' => 'required|not_in:0',
            'model_no' => 'required',
            // 'rep_name' => 'required',
            'event_date' => 'required',
            'status' => 'required|not_in:0'
        );
        if (Auth::user()->roll == '1') {
            $rules['client_name'] = "required|not_in:0";
        }

        $insertdata = array(
            'project_name' => $request->get('project_name'),
            'client_name' => $request->get('client_name'),
            'physician_name' => $request->get('physician_name'),
            'patient_id' => rand(1000, 9999),
            'manufacturer' => $request->get('manufacturer_name'),
            'device_name' => $request->get('device_name'),
            'model_no' => $request->get('model_no'),
            'rep_name' => $request->get('rep_name'),
            'event_date' => $request->get('event_date'),
            'start_time' => $starttime,
            'status' => $request->get('status')
        );

        $validator = Validator::make($insertdata, $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator);
        } else {


            $insert_schedule = schedule::insert($insertdata);
            $insert_schedule = 1;
            if ($insert_schedule) {
                $schedule_id = schedule::get()->last();
                $schedule_id = $schedule_id->id;
                $schedules = schedule::join('projects', 'projects.id', '=', 'schedule.project_name')
                    ->join('users', 'users.id', '=', 'schedule.physician_name')
                    ->join('manufacturers', 'manufacturers.id', '=', 'schedule.manufacturer')
                    ->join('device', 'device.id', '=', 'schedule.device_name')
                    ->join('clients', 'clients.id', '=', 'schedule.client_name')
                    ->select('schedule.*', 'clients.client_name', 'users.name', 'manufacturers.manufacturer_name', 'device.device_name as device', 'projects.project_name as pro_name')
                    ->where('schedule.id', '=', $schedule_id)
                    ->get();

                foreach ($schedules as $schedule) {
                    $title = "Welcome to Neptune-PPA - Schedule ";
                    $projectname = $schedule->pro_name;
                    $clientname = $schedule->client_name;
                    $physician = $schedule->name;
                    $patientid = $schedule->patient_id;
                    $manufacturer = $schedule->manufacturer_name;
                    $device = $schedule->device;
                    $model_name = $schedule->model_no;
                    $rep_name = $schedule->rep_name;
                    $event_date = $schedule->event_date;
                    $start_time = $schedule->start_time;

                    $physicianid = $schedule->physician_name;
                    $date = Carbon::parse($event_date)->format('Ymd');

                    $link = "https://calendar.google.com/calendar/render?action=TEMPLATE&text=Product-Schedule-Details&dates=" . $date . "T" . $t . "/" . $date . "T" . $t . "&details=Project Name: " . $projectname . "%0A%0A Physician: " . $physician . " %0A%0A Patient ID:" . $patientid . "%0A%0A  Device: " . $device . "%0A%0A Model No.:" . $model_name . "&location&trp=false&&sf=true&output=xml#eventpage_6";

                    $outlook = "https://outlook.live.com/owa/?rru=addevent&startdt=" . $date . "T" . $t . "&enddt=" . $date . "T" . $t . "&subject=Product-Schedule-Details&location=false&body=Project Name: " . $projectname . "%0A%0A Physician: " . $physician . " %0A%0A Patient ID:" . $patientid . " %0A%0A  Device: " . $device . "%0A%0A Model No.:" . $model_name . " &allday=false&path=/calendar/view/Month";


                    $data = array('title' => $title, 'projectname' => $projectname, 'clientname' => $clientname, 'physician' => $physician, 'patient_id' => $patientid, 'manufacturer' => $manufacturer, 'device' => $device, 'model_no' => $model_name, 'rep_name' => $rep_name, 'event_date' => $event_date, 'start_time' => $start_time, 'physicianid' => $physicianid, 'link' => $link, 'outlook' => $outlook, 'date' => $date, 't' => $t);

                    $event = $this->event($data);
                    $path = realpath('public/events/icalender.ics');


                    Mail::send('emails.createschedule', $data, function ($message) use ($data) {

                        $path = realpath('public/events/icalender.ics');

//                        $repemail = user::where('name', '=', $data['rep_name'])
//                            ->where('roll', '=', 5)
//                            ->where('status', '=', 'Enabled')
//                            ->where('is_delete', '=', 0)
//                            ->value('email');

                        $physicianmail = user::where('id', '=', $data['physicianid'])
                            ->where('roll', '=', 3)
                            ->where('status', '=', 'Enabled')
                            ->where('is_delete', '=', 0)
                            ->value('email');


                        if ($physicianmail != "") {
                            $message->to($physicianmail);
                        }
//print_r("hieee");
                        $message->from('admin@neptuneppa.com')->subject($data['title']);

                        $organization = clients::where('client_name', '=', $data['clientname'])->value('id');

//                        $get_user_emails = user::leftJoin('user_clients', 'user_clients.userId', '=', 'users.id')->where('users.roll', '=', 2)
//                            ->where('user_clients.clientId', '=', $organization)
//                            ->where('status', '=', 'Enabled')
//                            ->where('is_delete', '=', 0)
//                            ->get();
//
//                        foreach ($get_user_emails as $user_email) {
//                            if ($user_email != "") {
//                                $message->cc($user_email->email);
//                            }
//                        }
                        $deviceId = device::where('device_name', $data['device'])->value('id');

                        /*Changes by punit Kathiriya  29-8-2017 12:44PM Start*/

                        $customUser = customContact::where('clientId', $organization)->where('deviceId', $deviceId)->first();

                        if (!empty($customUser)) {
//                            if ($customUser['order_email'] != "") {
//                                $ordermail = User::where('id',$customUser['order_email'])->value('email');
//
//                                if($ordermail != ''){
//
//                                $message->cc($ordermail);
//                                }
//                            }
                            if ($customUser['cc1'] != "") {
                                $message->cc($customUser['cc1']);
                            }

                            if ($customUser['cc2'] != "") {
                                $message->cc($customUser['cc2']);
                            }
                            if ($customUser['cc3'] != "") {
                                $message->cc($customUser['cc3']);
                            }
                            if ($customUser['cc4'] != "") {
                                $message->cc($customUser['cc4']);
                            }
                            if ($customUser['cc5'] != "") {
                                $message->cc($customUser['cc5']);
                            }
                            if ($customUser['cc6'] != "") {
                                $message->cc($customUser['cc6']);
                            }
                        }
                        /*Changes by punit Kathiriya  29-8-2017 12:44PM End*/


                        $projectId = project::where('project_name', $data['projectname'])->value('id');

                        $manufacturerId = manufacturers::where('manufacturer_name', $data['manufacturer'])->value('id');

                        $projectUser = User::leftjoin('rep_contact_info', 'rep_contact_info.repId', '=', 'users.id')
                            ->leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
                            ->where('user_projects.projectId', $projectId)
                            ->where('users.organization', $manufacturerId)
                            ->where('rep_contact_info.deviceId', $deviceId)
                            ->where('rep_contact_info.repStatus', 'Yes')
                            ->where('users.roll', '5')
                            ->where('users.status', '=', 'Enabled')
                            ->where('users.is_delete', '0')
                            ->get();

                        foreach ($projectUser as $rmail) {
                            if ($rmail != "") {
                                $message->cc($rmail->email);
                            }
                        }

//                         $message->cc('punitkathiriya@gmail.com');
                        $message->attach(($path), [
                            'as' => 'icalender.ics',
                            'mime' => 'text/calendar',
                        ]);
                    });


                }
//                die;


            }
            return Redirect::to('admin/schedule');
        }
    }

    public function edit($id, Request $request)
    {
        $userid = Auth::user()->id;
        //$organization = user::where('id', '=', $userid)->value('organization');

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');

        }

        if (count($organization) > 0) {


            $projects = [NULL => 'Project Name'] + project_clients::join('projects', 'projects.id', '=', 'project_clients.project_id')
                    ->whereIn('project_clients.client_name', $organization)
                    ->where('projects.is_delete', '=', 0)
                    ->distinct('project.id')
                    ->pluck('projects.project_name', 'projects.id')->all();
            $clients = [NULL => 'Client Name'] + clients::whereIn('id', $organization)->where('is_delete', '=', 0)->pluck('client_name', 'id')->all();

            // dd($clients);
        } else {
            $clients = [NULL => 'Client Name'] + clients::where('is_delete', '=', 0)->pluck('client_name', 'id')->all();
            $projects = Project::where('is_delete', '=', 0)->pluck('project_name', 'id')->all();
        }


        $manufacturer = Manufacturers::where('is_delete', '=', 0)->pluck('manufacturer_name', 'id')->all();
        $devices = ['0' => 'Select Device'] + device::where('is_delete', '=', 0)->pluck('device_name', 'id')->all();

        $physician = User::where('roll', 3)->where('is_delete', '=', 0)->pluck('name', 'id')->all();

        $schedules = schedule::FindOrFail($id);
        // dd($schedules->device_name);
        $rep = [NULL => 'Rep Name'] + User::leftJoin('user_clients', 'user_clients.userId', '=', 'users.id')->leftJoin('rep_contact_info', 'rep_contact_info.repId', '=', 'users.id')->where('users.roll', '5')->where('users.organization', $schedules->manufacturer)->where('users.projectname', $schedules->project_name)->where('user_clients.clientId', $schedules->client_name)->where('rep_contact_info.deviceId', $schedules->device_name)->where('rep_contact_info.repStatus', 'Yes')->groupBy('users.id')->distinct()->pluck('users.name', 'users.name')->all();;

        $time = $schedules->start_time;

        $starttime = preg_split("/(\s|:)/", $time);

        // dd($schedules);

        return view('pages.editschedule', compact('schedules', 'clients', 'projects', 'manufacturer', 'devices', 'physician', 'starttime', 'rep'));
    }

    public function update($id, Request $request)
    {

        $hours = $request->get('start_time_hours');
        $minutes = $request->get('start_time_minutes');
        $time = $request->get('start_time');
        $start_time = $hours . ':' . $minutes . " " . $time;
        $data = $request->all();

        if (strlen($minutes) < 2 && strlen($hours) < 2) {
            $starttime = '0' . $hours . ':0' . $minutes . " " . $time;

        } else if (strlen($hours) < 2) {
            $starttime = '0' . $hours . ':' . $minutes . " " . $time;

        } else if (strlen($minutes) < 2) {
            $starttime = $hours . ':0' . $minutes . " " . $time;

        } else {
            $starttime = $hours . ':' . $minutes . " " . $time;

        }

        $t = Carbon::parse($starttime)->setTimezone('UTC +5:30')->format('His');

        $rules = array(
            'project_name' => 'required|not_in:0',
            'physician_name' => 'required|not_in:0',
            'manufacturer' => 'required|not_in:0',
            'device_name' => 'required|not_in:0',
            'model_no' => 'required',
            // 'rep_name' => 'required',
            'event_date' => 'required',
            'status' => 'required|not_in:0'
        );
        if (Auth::user()->roll == '1') {
            $rules['client_name'] = "required|not_in:0";
        }

        $updatedata = array(
            'project_name' => $request->get('project_name'),
            'client_name' => $request->get('client_name'),
            'physician_name' => $request->get('physician_name'),
            'manufacturer' => $request->get('manufacturer'),
            'device_name' => $request->get('device_name'),
            'model_no' => $request->get('model_no'),
            'rep_name' => $request->get('rep_name'),
            'event_date' => $request->get('event_date'),
            'start_time' => $start_time,
            'status' => $request->get('status')
        );

        $validator = Validator::make($updatedata, $rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } else {

            $update = DB::table('schedule')->where('id', '=', $id)->update($updatedata);

            if ($update) {

                $schedules = schedule::join('projects', 'projects.id', '=', 'schedule.project_name')
                    ->join('users', 'users.id', '=', 'schedule.physician_name')
                    ->join('manufacturers', 'manufacturers.id', '=', 'schedule.manufacturer')
                    ->join('device', 'device.id', '=', 'schedule.device_name')
                    ->join('clients', 'clients.id', '=', 'schedule.client_name')
                    ->select('schedule.*', 'clients.client_name', 'users.name', 'manufacturers.manufacturer_name', 'device.device_name as device', 'projects.project_name as pro_name')
                    ->where('schedule.id', '=', $id)
                    ->get();

                $title = "Welcome to Neptune-PPA - Schedule update";
                $projectname = $schedules[0]['pro_name'];
                $clientname = $schedules[0]['client_name'];
                $physician = $schedules[0]['name'];
                $patientid = $schedules[0]['patient_id'];
                $manufacturer = $schedules[0]['manufacturer_name'];
                $device = $schedules[0]['device'];
                $model_name = $schedules[0]['model_no'];
                $rep_name = $schedules[0]['rep_name'];
                $event_date = $schedules[0]['event_date'];
                $start_time = $schedules[0]['start_time'];
                $physicianid = $schedules[0]['physician_name'];


                $date = Carbon::parse($event_date)->format('Ymd');

                $link = "https://calendar.google.com/calendar/render?action=TEMPLATE&text=Product-Schedule-Details&dates=" . $date . "T" . $t . "/" . $date . "T" . $t . "&details=Project Name: " . $projectname . "%0A%0A Physician: " . $physician . " %0A%0A Patient ID:" . $patientid . "%0A%0A  Device: " . $device . "%0A%0A Model No.:" . $model_name . "&location&trp=false&sf=true&output=xml#eventpage_6";

                $outlook = "https://outlook.live.com/owa/?rru=addevent&startdt=" . $date . "T" . $t . "&enddt=" . $date . "T" . $t . "&subject=Product-Schedule-Details&location=false&body=Project Name: " . $projectname . "%0A%0A Physician: " . $physician . " %0A%0A Patient ID:" . $patientid . " %0A%0A  Device: " . $device . "%0A%0A Model No.:" . $model_name . " &allday=false&path=/calendar/view/Month";


                $data = array(
                    'title' => $title,
                    'projectname' => $projectname,
                    'clientname' => $clientname,
                    'physician' => $physician,
                    'patient_id' => $patientid,
                    'manufacturer' => $manufacturer,
                    'device' => $device,
                    'model_no' => $model_name,
                    'rep_name' => $rep_name,
                    'event_date' => $event_date,
                    'start_time' => $start_time,
                    'physicianid' => $physicianid,
                    'link' => $link,
                    'outlook' => $outlook,
                    // 'icalender'=>$icalender,
                    'date' => $date,
                    't' => $t
                );

                $event = $this->event($data);
                $path = realpath('public/events/icalender.ics');

                Mail::send('emails.createschedule', $data, function ($message) use ($data, $event) {


                    $path = realpath('public/events/icalender.ics');

//                    $repemail = user::where('name', '=', $data['rep_name'])
//                        ->where('roll', '=', 5)
//                        ->where('status', '=', 'Enabled')
//                        ->where('is_delete', '=', 0)
//                        ->value('email');

                    $physicianmail = user::where('id', '=', $data['physicianid'])
                        ->where('roll', '=', 3)
                        ->where('status', '=', 'Enabled')
                        ->where('is_delete', '=', 0)
                        ->value('email');


                    if ($physicianmail != "") {
                        $message->to($physicianmail);
                    }

                    $message->from('admin@neptuneppa.com')->subject($data['title']);

                    $organization = clients::where('client_name', '=', $data['clientname'])->value('id');

//                    $message->cc('punitkathiriya@gmail.com');

//                    $get_user_emails = user::leftJoin('user_clients', 'user_clients.userId', '=', 'users.id')->where('users.roll', '=', 2)
//                        ->where('user_clients.clientId', '=', $organization)
//                        ->where('status', '=', 'Enabled')
//                        ->where('is_delete', '=', 0)
//                        ->get();
//
//                    foreach ($get_user_emails as $user_email) {
//                        if ($user_email != "") {
//                            $message->cc($user_email->email);
//                        }
//                    }

                    $deviceId = device::where('device_name', $data['device'])->value('id');

                    /*Changes by punit Kathiriya  29-8-2017 12:44PM Start*/

                    $customUser = customContact::where('clientId', $organization)->where('deviceId', $deviceId)->first();

                    if (!empty($customUser)) {
//                        if ($customUser['order_email'] != "") {
//                            $ordermail = User::where('id',$customUser['order_email'])->value('email');
//
//                            if($ordermail != ''){
//
//                                $message->cc($ordermail);
//                            }
//                        }
                        if ($customUser['cc1'] != "") {
                            $message->cc($customUser['cc1']);
                        }

                        if ($customUser['cc2'] != "") {
                            $message->cc($customUser['cc2']);
                        }
                        if ($customUser['cc3'] != "") {
                            $message->cc($customUser['cc3']);
                        }
                        if ($customUser['cc4'] != "") {
                            $message->cc($customUser['cc4']);
                        }
                        if ($customUser['cc5'] != "") {
                            $message->cc($customUser['cc5']);
                        }
                        if ($customUser['cc6'] != "") {
                            $message->cc($customUser['cc6']);
                        }
                    }
                    /*Changes by punit Kathiriya  29-8-2017 12:44PM End*/


                    $projectId = project::where('project_name', $data['projectname'])->value('id');

                    $manufacturerId = manufacturers::where('manufacturer_name', $data['manufacturer'])->value('id');

//                    $deviceId = device::where('device_name', $data['device'])->value('id');

                    $projectUser = User::leftjoin('rep_contact_info', 'rep_contact_info.repId', '=', 'users.id')
                        ->leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
                        ->where('user_projects.projectId', $projectId)
                        ->where('users.organization', $manufacturerId)
                        ->where('rep_contact_info.deviceId', $deviceId)
                        ->where('rep_contact_info.repStatus', 'Yes')
                        ->where('users.roll', '5')
                        ->where('users.status', '=', 'Enabled')
                        ->where('users.is_delete', '0')
                        ->get();

                    foreach ($projectUser as $rmail) {
                        if ($rmail != "") {
                            $message->cc($rmail->email);
                        }
                    }
//                    $message->cc('punitkathiriya@gmail.com');
                    $message->attach(($path), [
                        'as' => 'icalender.ics',
                        'mime' => 'text/calendar',
                    ]);
                });

            }
            return Redirect::to('admin/schedule');
        }
    }

    static function event($data)
    {

        $dat[0] = "BEGIN:VCALENDAR";
        $dat[1] = "VERSION:2.0";
        $dat[2] = "PRODID:-//Google Inc//Google Calendar 70.9054//EN";
        $dat[3] = "X-PUBLISHED-TTL:P1W";
        $dat[4] = "BEGIN:VEVENT";
        $dat[5] = "UID:admin@neptune-ppa.com";
        $dat[6] = "DTSTART:" . $data['date'] . "T" . $data['t'];
        $dat[7] = "SEQUENCE:0";
        $dat[8] = "TRANSP:OPAQUE";
        $dat[9] = "DTEND:" . $data['date'] . "T" . $data['t'];
        $dat[10] = "LOCATION:";
        $dat[11] = "SUMMARY:Neptune-PPA Event Schedule";
        $dat[12] = "CLASS:PUBLIC";
        $dat[13] = "DESCRIPTION:Project Name:-" . $data['projectname'] . " Physician:- " . $data['physician'] . "  Patient ID:- " . $data['patient_id'] . "  Device:-" . $data['device'] . " Model No.:-" . $data['model_no'] . "";
        $dat[14] = "ORGANIZER:Neptune-PPA<admin@neptune-ppa.com>";
        $dat[15] = "DTSTAMP:" . $data['date'];
        $dat[16] = "END:VEVENT";
        $dat[17] = "END:VCALENDAR";

        $filenames = 'icalender.ics';
        header('Content-type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filenames);
        $dat = implode("\r\n", $dat);
        file_put_contents('public/events/' . $filenames, $dat);

    }

    public function search(Request $request)
    {

        $data = $request->all();

        // if(Auth::user()->roll == 1){


        $id = $data['search'][0];
        $project_name = $data['search'][1];
        $client_name = $data['search'][2];
        $name = $data['search'][3];
        $patient_id = $data['search'][4];
        $manufacturer_name = $data['search'][5];
        $device_name = $data['search'][6];
        $model_no = $data['search'][7];
        $rep_name = $data['search'][8];
        $event_date = $data['search'][9];
        $start_time = $data['search'][10];

        $userid = Auth::user()->id;
        //$organization = user::where('id', '=', $userid)->value('organization');

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();

        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');

        }

        if (count($organization) > 0) {

            $search_schedules = schedule::leftjoin('projects', 'projects.id', '=', 'schedule.project_name')
                ->leftjoin('users', 'users.id', '=', 'schedule.physician_name')
                ->leftjoin('manufacturers', 'manufacturers.id', '=', 'schedule.manufacturer')
                ->leftjoin('device', 'device.id', '=', 'schedule.device_name')
                ->leftjoin('clients', 'clients.id', '=', 'schedule.client_name')
                ->leftjoin('user_clients', 'user_clients.userId', '=', 'users.id')
                ->whereIn('schedule.client_name', $organization)
                ->select('schedule.*', 'clients.client_name', 'users.name', 'manufacturers.manufacturer_name', 'device.device_name as device', 'projects.project_name as pro_name')
                ->where('schedule.is_delete', '=', '0');


            if (!empty($id)) {
                $search_schedules = $search_schedules->where('schedule.id', 'LIKE', $id . '%');
            }
            if (!empty($project_name)) {
                $search_schedules = $search_schedules->where('projects.project_name', 'LIKE', $project_name . '%');
            }
            if (!empty($client_name)) {
                $search_schedules = $search_schedules->where('clients.client_name', 'LIKE', $client_name . '%');
            }
            if (!empty($name)) {
                $search_schedules = $search_schedules->where('users.name', 'LIKE', $name . '%');
            }
            if (!empty($patient_id)) {
                $search_schedules = $search_schedules->where('schedule.patient_id', 'LIKE', $patient_id . '%');
            }
            if (!empty($manufacturer_name)) {
                $search_schedules = $search_schedules->where('manufacturers.manufacturer_name', 'LIKE', $manufacturer_name . '%');
            }
            if (!empty($device_name)) {
                $search_schedules = $search_schedules->where('device.device_name', 'LIKE', $device_name . '%');
            }
            if (!empty($model_no)) {
                $search_schedules = $search_schedules->where('schedule.model_no', 'LIKE', $model_no . '%');
            }
            if (!empty($rep_name)) {
                $search_schedules = $search_schedules->where('schedule.rep_name', 'LIKE', $rep_name . '%');
            }
            if (!empty($event_date)) {
                $search_schedules = $search_schedules->where('schedule.event_date', 'LIKE', $event_date . '%');
            }
            if (!empty($start_time)) {
                $search_schedules = $search_schedules->where('schedule.start_time', 'LIKE', $start_time . '%');
            }
            $search_schedules = $search_schedules->groupBy('schedule.id')->orderby('schedule.id', '=', 'DESC')
                ->get();
            // dd($search_schedules);
        } else {


            $search_schedules = schedule::leftjoin('projects', 'projects.id', '=', 'schedule.project_name')
                ->leftjoin('clients', 'clients.id', '=', 'schedule.client_name')
                ->leftjoin('users', 'users.id', '=', 'schedule.physician_name')
                ->leftjoin('manufacturers', 'manufacturers.id', '=', 'schedule.manufacturer')
                ->leftjoin('device', 'device.id', '=', 'schedule.device_name')
                ->select('schedule.*', 'users.name', 'clients.client_name', 'manufacturers.manufacturer_name', 'device.device_name as device', 'projects.project_name as pro_name')
                ->where('schedule.is_delete', '=', '0');

            if (!empty($id)) {
                $search_schedules = $search_schedules->where('schedule.id', 'LIKE', $id . '%');
            }
            if (!empty($project_name)) {
                $search_schedules = $search_schedules->where('projects.project_name', 'LIKE', $project_name . '%');
            }
            if (!empty($client_name)) {
                $search_schedules = $search_schedules->where('clients.client_name', 'LIKE', $client_name . '%');
            }
            if (!empty($name)) {
                $search_schedules = $search_schedules->where('users.name', 'LIKE', $name . '%');
            }
            if (!empty($patient_id)) {
                $search_schedules = $search_schedules->where('schedule.patient_id', 'LIKE', $patient_id . '%');
            }
            if (!empty($manufacturer_name)) {
                $search_schedules = $search_schedules->where('manufacturers.manufacturer_name', 'LIKE', $manufacturer_name . '%');
            }
            if (!empty($device_name)) {
                $search_schedules = $search_schedules->where('device.device_name', 'LIKE', $device_name . '%');
            }
            if (!empty($model_no)) {
                $search_schedules = $search_schedules->where('schedule.model_no', 'LIKE', $model_no . '%');
            }
            if (!empty($rep_name)) {
                $search_schedules = $search_schedules->where('schedule.rep_name', 'LIKE', $rep_name . '%');
            }
            if (!empty($event_date)) {
                $search_schedules = $search_schedules->where('schedule.event_date', 'LIKE', $event_date . '%');
            }
            if (!empty($start_time)) {
                $search_schedules = $search_schedules->where('schedule.start_time', 'LIKE', $start_time . '%');
            }

            $search_schedules = $search_schedules->groupBy('schedule.id')->orderby('schedule.id', '=', 'DESC')
                ->get();
        }
        $data = $search_schedules;

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

    public function updateall()
    {
        /* $hiddenid = Input::get('hiddenid');
          $physician = Input::get('physician_name');
          $manufacturer = Input::get('manufacturer_name');
          $device = Input::get('device_name');


          for($i = 0; $i < count($hiddenid); $i++)
          {
          $updaterecord = array(
          "physician_name" => $physician[$i],
          "device_name" => $device[$i],
          "manufacturer" => $manufacturer[$i]
          );
          $updateschedule = DB::table('schedule')->where('id', '=', $hiddenid[$i])->update($updaterecord);
      } */
        return Redirect::to('admin/schedule');
    }

    public function devicedetails()
    {
        $deviceid = Input::get('deviceid');
        $clientname = Input::get('clientname');
        $manufacturer = Input::get('manufacturer');
        $projectname = Input::get('projectname');

        $model = device::where('device.id', '=', $deviceid)->value('model_name');

        $search_device = User::leftJoin('user_clients', 'user_clients.userId', '=', 'users.id')
            ->leftJoin('rep_contact_info', 'rep_contact_info.repId', '=', 'users.id')
            ->leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
            ->where('users.roll', '5')->where('users.organization', $manufacturer)
            ->where('user_projects.projectId', $projectname)
            ->where('user_clients.clientId', $clientname)
            ->where('rep_contact_info.deviceId', $deviceid)
            ->where('rep_contact_info.repStatus', 'Yes')
            ->groupBy('users.id')
            ->distinct()
            ->get();

        $data = array(
            'search_device' => $search_device,
            'model' => $model,
        );

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
        $remove = DB::table('schedule')->where('id', '=', $id)->update($removedata);
        return Redirect::to('admin/schedule');
    }

    public function getclientname(Request $request)
    {

        $projectid = Input::get('projectid');
        // dd($projectid);

        $userid = Auth::user()->id;

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();

        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');
            // $organization = $adminclient;
        }

        if (count($organization) > 0) {

            $getclientname = project_clients::leftjoin('clients', 'clients.id', '=', 'project_clients.client_name')
                ->where('project_clients.project_id', $projectid)
                ->whereIn('clients.id', $organization)
                ->select('clients.client_name', 'clients.id')
                ->get();


            // dd($getclientname);

        } else {
            $getclientname = project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')
                ->where('project_clients.project_id', '=', $projectid)
                ->select('clients.client_name', 'clients.id')
                ->get();
        }

        $data = $getclientname;
        // dd($data);
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

    public function getphysician(Request $request)
    {

        $clientid = Input::get('clientid');
        $projectid = Input::get('projectid');
        // dd($clientid);

        if (Auth::user()->roll == 2) {


            $getphysician = user::leftJoin('user_clients', 'user_clients.userId', '=', 'users.id')
                ->leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
                ->where('user_projects.projectId', '=', $projectid)
                ->where('user_clients.clientId', $clientid)
                ->where('users.roll', '=', 3)
                ->select('users.name', 'users.id')
                ->where('users.is_delete', '=', 0)
                ->groupBy('users.id')
                ->get();
        } else {
            $getphysician = user::leftJoin('user_clients', 'user_clients.userId', '=', 'users.id')
                ->leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
                ->where('user_clients.clientId', '=', $clientid)
                ->where('user_projects.projectId', '=', $projectid)
                ->where('users.roll', '=', 3)
                ->where('users.is_delete', '=', 0)
                ->select('users.name', 'users.id')->get();
        }


        $data = $getphysician;
        // dd($data);

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

    public function getmanufacturer()
    {
        $projectid = Input::get('projectid');
        $getmanufacturer = device::join('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
            ->where('device.project_name', '=', $projectid)
            ->groupby('device.manufacturer_name')
            ->where('device.is_delete', '=', 0)
            ->get();


        $manufacturerdata = $getmanufacturer;

        if (count($manufacturerdata))
            return [
                'value' => $manufacturerdata,
                'status' => TRUE
            ];
        else
            return [
                'value' => 'No result Found',
                'status' => FALSE
            ];
    }

    public function getdevicename()
    {
        $projectid = Input::get('projectid');
        $manufacturerid = Input::get('manufacturerid');
        $getclientname = device::where('manufacturer_name', '=', $manufacturerid)
            ->where('project_name', '=', $projectid)
            ->where('is_delete', '=', 0)
            ->select('device_name', 'id')->get();
        $data = $getclientname;

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


    public function export()
    {


        $scheduleid = Input::get('schedule_chk');

        $schedule_id = [];

        foreach ($scheduleid as $schedule) {
            $schedule_id[] = $schedule;

        }

        $schedules = schedule::leftjoin('projects', 'projects.id', '=', 'schedule.project_name')
            ->leftjoin('users', 'users.id', '=', 'schedule.physician_name')
            ->leftjoin('manufacturers', 'manufacturers.id', '=', 'schedule.manufacturer')
            ->leftjoin('device', 'device.id', '=', 'schedule.device_name')
            ->leftjoin('clients', 'clients.id', '=', 'schedule.client_name')
            ->select('schedule.*', 'clients.client_name', 'users.name', 'manufacturers.manufacturer_name', 'device.device_name as device', 'projects.project_name as pro_name')
            ->where('schedule.is_delete', '=', '0')
            ->orderby('schedule.id', '=', 'DESC')
            ->whereIn('schedule.id', $schedule_id)
            ->get();


        $filename = "schedule.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('ID', 'Project Name', 'Client Name', 'Physician', 'Patient ID', 'Manufacturer', 'Device Name', 'Model No.', 'Rep Name', 'Event date', 'Start Time'));

        foreach ($schedules as $row) {
            fputcsv($handle, array($row['id'], $row['pro_name'], $row['client_name'], $row['name'], $row['patient_id'], $row['manufacturer_name'], $row['device'], $row['model_no'], $row['rep_name'], $row['event_date'], $row['start_time']));
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return Response::download($filename, 'schedule.csv', $headers);
        return Redirect::to('admin/schedule');
    }

    public function order($id, Request $request)
    {

        $userid = Auth::user()->id;
        $order = order::where('id', $id)->first();

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');

        }

        if (count($organization) > 0) {

            $clients = [NULL => 'Client Name'] + clients::whereIn('id', $organization)->where('is_delete', '=', 0)->pluck('client_name', 'id')->all();
        } else {
            // $clients = [NULL => 'Client Name'] + clients::where('is_delete', '=', 0)->pluck('client_name', 'id')->all();
            $clients = [NULL => 'Client Name'] + clients::where('id', $order['clientId'])->where('is_delete', '=', 0)->pluck('client_name', 'id')->all();

        }


        $device = device::where('id', $order['deviceId'])->first();

        $projects = [NULL => 'Project Name'] + Project::where('is_delete', '=', 0)->where('id', $device['project_name'])->pluck('project_name', 'id')->all();


        $physician = ['0' => 'Select Physician'] + User::where('is_delete', '=', 0)->where('roll', 3)->where('id', $order['orderby'])->pluck('name', 'id')->all();

        $manufacturer = ['0' => 'Select Manufacturer'] + Manufacturers::where('is_delete', '=', 0)->where('id', $order['manufacturer_name'])->pluck('manufacturer_name', 'id')->all();

        $devices = ['0' => 'Select Device'] + device::where('is_delete', '=', 0)->where('id', $device['id'])->pluck('device_name', 'id')->all();

//        $rep = User::leftJoin('user_clients', 'user_clients.userId', '=', 'users.id')
//            ->select('users.id', 'users.name')
//            ->where('user_clients.clientId', $order['clientId'])
//            ->where('users.roll', '5')
//            ->pluck('users.name', 'users.name')->all();

        $rep = [NULL => 'Rep Name'] + User::leftJoin('user_clients', 'user_clients.userId', '=', 'users.id')
                ->leftJoin('rep_contact_info', 'rep_contact_info.repId', '=', 'users.id')
                ->leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
                ->where('users.roll', '5')
                ->where('user_projects.projectId', $device['project_name'])
                ->where('users.organization', $order['manufacturer_name'])
                ->where('user_clients.clientId', $order['clientId'])
                ->where('rep_contact_info.deviceId', $device['id'])
                ->where('rep_contact_info.repStatus', 'Yes')
                ->groupBy('users.id')->distinct()
                ->pluck('users.name', 'users.name')->all();


        return view('pages.schedule.addCustomSchedule', compact('device', 'order', 'projects', 'clients', 'physician', 'manufacturer', 'devices', 'rep'));
    }

}