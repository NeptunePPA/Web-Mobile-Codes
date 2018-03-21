<?php

namespace App\Http\Controllers\ImportAPP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Auth;
use Carbon\Carbon;
use Excel;
use Response;
use View;
use App\Import_app;
use App\category;
use App\project;
use App\manufacturers;
use App\clients;
use App\User;
use File;


class ImportAPPController extends Controller
{
    public function index(Request $request)
    {

    }

    public function import(Request $request)
    {
        if ($request->hasFile('device_import')) {
            $path = $request->file('device_import')->getRealPath();
            $data = Excel::load($path, function ($reader) {

            })->get();

            $wrongdata = array();

            if (!empty($data) && $data->count()) {
                foreach ($data as $row) {

                    $flag = 'false';
                    $flag1 = 'false';
                    $flag2 = 'false';
                    $flag3 = 'false';
                    $flag4 = 'false';
                    $flag5 = 'false';

                    $level = array("Advanced", "Entry");

                    if (!empty($row->device_level)) {
                        if (in_array($row->device_level, $level)) {
                            $flag = true;
                        } else {
                            $row->device_level = $row->device_level . "(Wrong data)";
                            $flag = false;
                        }
                    }

                    if (!empty($row->category_name)) {
                        $category_name = category::where('category_name', $row->category_name)->value('id');

                        if (!empty($category_name)) {
                            $flag1 = true;
                        } else {
                            $row->category_name = $row->category_name . "(Wrong data)";
                            $flag1 = false;
                        }
                    } else {
                        $row->category_name = $row->category_name . "(Required)";
                        $flag1 = false;
                    }

                    if (!empty($row->project_name)) {
                        $project_name = project::where('project_name', $row->project_name)->value('id');

                        if (!empty($project_name)) {
                            $flag2 = true;
                        } else {
                            $row->project_name = $row->project_name . "(Wrong data)";
                            $flag2 = false;
                        }
                    } else {
                        $row->project_name = $row->project_name . "(Required)";
                        $flag2 = false;
                    }

                    if (!empty($row->client_name)) {
                        $client_name = clients::where('client_name', $row->client_name)->value('id');

                        if (!empty($client_name)) {
                            $flag3 = true;
                        } else {
                            $row->client_name = $row->client_name . "(Wrong data)";
                            $flag3 = false;
                        }
                    } else {
                        $row->client_name = $row->client_name . "(Required)";
                        $flag3 = false;
                    }

                    if (!empty($row->category_avg_app)) {
                        $flag4 = true;
                    } else {
                        $row->category_avg_app = $row->category_avg_app . "(Required)";
                        $flag4 = false;
                    }

                    if (!empty($row->year)) {
                        $flag5 = true;
                    } else {
                        $row->year = $row->year . "(Required)";
                        $flag5 = false;
                    }

                    $insert = [
                        'category_name' => $category_name,
                        'project_name' => $project_name,
                        'category_avg_app' => $row->category_avg_app,
                        'client_name' => $client_name,
                        'device_level' => $row->device_level == '' ? '': $row->device_level .' Level',
                        'year' => $row->year,
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now(),
                    ];


                    $flag6 = true;

                    $check = Import_app::where('category_name',$category_name)
                        ->where('client_name',$client_name);
                        if(!empty($row->device_level)){
                            $check =$check->where('device_level',$row->device_level. ' Level');

                        }
                       $check = $check->where('project_name',$project_name)
                        ->first();

                    if(!empty($check)){
                        $flag6 = false;
                        $row->category_name = $row->category_name . "(Already Exist.)";
                    }


                    if ($flag && $flag1 && $flag2 && $flag3 && $flag4 && $flag5 && $flag6 = true) {


                        Import_app::insert($insert);

                    } else {

                        $wrongdata[] = array(
                            'category_name' => $row->category_name,
                            'project_name' => $row->project_name,
                            'category_avg_app' => $row->category_avg_app,
                            'client_name' => $row->client_name,
                            'device_level' => $row->device_level,
                            'year' => $row->year,
                        );

                    }
                }

                $status = true;
                if (count($wrongdata) != 0) {
                    $status = false;
                    // dd($wrongdata);
                    return view('pages.repcasetracker.newdevice.app_import_error', compact('wrongdata'));
                } else {

                    return Redirect::to('admin/repcasetracker');
                }
            }


        }
    }

    public function sampledownloadss()
    {

        $file = "public/upload/app/import_app_value.xlsx";

        return Response::download($file);

        return redirect()->back();
    }

    public function view()
    {

        $data = Import_app::orderBy('id', 'DESC')->get();

        return view('pages.repcasetracker.newdevice.import_view', compact('data'));
    }

    public function remove(Request $request)
    {

        $data = $request->all();

        $remove = Import_app::whereIn('id', $data['ck_rep'])->delete();
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
}
