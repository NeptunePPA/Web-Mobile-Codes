<?php

namespace App\Http\Controllers;

use App\ItemFileEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Itemfiles;
use App\clients;
use Excel;
use App\ItemfileDetails;
use App\userClients;
use Carbon\Carbon;
use Response;
use App\project_clients;
use App\project;
use Auth;
use DB;


class ItemFile extends Controller
{
    public function index(Request $request)
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
            $itemfile = Itemfiles::whereIn('clientId', $organization)->paginate($pagesize);
            $count = Itemfiles::whereIn('clientId', $organization)->count();

        } else {
            $itemfile = Itemfiles::paginate($pagesize);
            $count = Itemfiles::count();
        }
        return view('pages.itemfiles.index', compact('itemfile', 'count', 'pagesize'));
    }


    public function add(Request $request)
    {
        /*get client name*/
        $project_clients = project_clients::select('client_name',DB::raw('count(project_id) as totalproject'))->groupBy('client_name')->get();
        $check_itemfile_project = Itemfiles::select('clientId',DB::raw('count(projectId) as totalproject'))->groupBy('clientId')->get();
        $clientdata = [];
        foreach ($project_clients as $row) {

            $a = [];
            foreach ($check_itemfile_project as $value) {
                $a[$value->clientId] = $value->totalproject;
            }

            if(array_key_exists($row->client_name, $a))
            {
                if($a[$row->client_name] != $row->totalproject)
                {
                    $clientdata[] = $row->client_name;
                }

            }
            else
            {
                $clientdata[] = $row->client_name;
            }
        }

        /*get client name*/

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();

        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');

        }

        if (count($organization) > 0) {
            $clients = ['' => 'Client Name'] + clients::rightJoin('project_clients','project_clients.client_name','=','clients.id')
                    ->whereIn('clients.id', $organization)
                    ->whereIn('clients.id', $clientdata)
                    ->pluck('clients.client_name', 'clients.id')->all();

        } else {

            $clients = ['' => 'Client Name'] + clients::rightJoin('project_clients','project_clients.client_name','=','clients.id')
                    ->whereIn('clients.id', $clientdata)
                    ->pluck('clients.client_name', 'clients.id')
                    ->all();
        }
//dd($clients);
        return view('pages.itemfiles.add', compact('clients'));
    }

    /*Change Project Filed Start*/

    public function projectchange(Request $request)
    {
        $id = $request['clientname'];

        $check_project = Itemfiles::where('clientId', $id)->get();

        $project = [];
        foreach ($check_project as $clients) {
            $project[] = $clients['projectId'];

        }
        $data = project_clients::where('client_name', $id)->whereNotIn('project_id', $project)->get();

        foreach ($data as $row) {
            $row['projectName'] = $row->projectname->project_name;
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

    /*Change Project Filed End*/

    public function import($id)
    {
        $itemFile = Itemfiles::where('id', $id)->first();

        $client = clients::where('id', $itemFile['clientId'])->first();

        $clients = ['' => 'Client Name', $client['id'] => $client['client_name']];

        $project = project::where('id', $itemFile['projectId'])->first();

        $projects = ['' => "Project Name", $project['id'] => $project['project_name']];

        return view('pages.itemfiles.import', compact('clients', 'projects', 'itemFile'));

    }

    public function create(Request $request)
    {
        $rules = array(
            'clientId' => 'required',
            'projectId' => 'required',
            'itemFile' => 'required'
        );

        $messages = [
            'clientId.required' => 'Please select client name.',
            'projectId.required' => 'Please select Project name.',

        ];


        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $filename = Input::file('itemFile')->getClientOriginalName();
        //$move = Input::file('itemFile')->move($destinationpath,$filename);


        /*check exisiting file entry*/
        $checkclientfile = Itemfiles::where('clientId', $request->get('clientId'))->where('projectId', $request->get('projectId'))->first();

        if ($checkclientfile == "") {

            $insertdata = [
                'clientId' => $request->get('clientId'),
                'projectId' => $request->get('projectId'),
                'itemFile' => $filename,
                'createDate' => Carbon::now()->format('d-m-Y'),
                'updateDate' => Carbon::now()->format('d-m-Y')
            ];
            $itemfilestore = new Itemfiles();
            $itemfilestore->fill($insertdata);
            $itemfilestore->save();

            $fileId = $itemfilestore->id;

        } else {

            $fileId = $checkclientfile->id;

        }


        $removedata = array();
        $reItemdetails = ItemfileDetails::where('fileId', $fileId)->get();

        foreach ($reItemdetails as $re) {
            $removedata[] = $re->id;
        }


        if (Input::hasFile('itemFile')) {

            $path = Input::file('itemFile')->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->get();
            $wrongdata = array();

            foreach ($data as $key => $value) {
                $company = $value->company;
                $category = $value->category;
                $supplyitem = $value->supply_item_descriptionsize;
                $mfgpart = $value->mfgpartnumber;
                $hpm = $value->hospital_product_number;
                $doctors = $value->doctors;
                $email = $value->email;


                if ($company != null) {
                    $flag4 = true;
                } else {
                    $company = $company . "(Company Name is Required)";
                    $flag4 = false;
                }

                if ($category != null) {
                    $flag6 = true;
                } else {
                    $category = $category . "(Category Name is Required)";
                    $flag6 = false;
                }

                if ($supplyitem != null) {
                    $flag7 = true;
                } else {
                    $supplyitem = $supplyitem . "(Supply item Name is Required)";
                    $flag7 = false;
                }

//                if ($doctors != null) {
//                    $flag8 = true;
//                } else {
//                    $doctors = $doctors . "(Doctor Name is Required)";
//                    $flag8 = false;
//                }
                $flag9 = true;
                if($doctors != null){
                    if ($email != null) {
                        $flag9 = true;
                    } else {
                        $doctors = $doctors . "(Email OR Doctor name is Required)";
                        $flag9 = false;
                    }
                }



                if ($supplyitem != null) {
                    $devicename = ItemfileDetails::where('supplyItem', '=', $supplyitem)->where('category', $category)->where('clientId', $request->get('clientId'))
//                        ->where('projectId', $request->get('projectId'))
                        ->first();
                }


                $mfgpartnumber = ItemfileDetails::where('mfgPartNumber', '=', $mfgpart)->where('supplyItem', '=', $supplyitem)->where('category', $category)->where('clientId', $request->get('clientId'))
//                    ->where('projectId', $request->get('projectId'))
                    ->first();


                $hosnumber = ItemfileDetails::where('hospitalNumber', '=', $hpm)->where('supplyItem', '=', $supplyitem)->where('category', $category)->where('clientId', $request->get('clientId'))
//                    ->where('projectId', $request->get('projectId'))
                    ->first();


                if ($devicename == null) {
                    $flag1 = true;
                } else {
                    $supplyitem = $value->supply_item_descriptionsize . "(Supply Item name already exist)";
                    $flag1 = false;
                }
                if ($mfgpart != null) {
                    if ($mfgpartnumber == null) {
                        $flag2 = true;
                    } else {
                        $mfgpart = $value->mfgpartnumber . "(Manufacturer Part Number already exist)";
                        $flag2 = false;
                    }
                } else {
                    $flag2 = true;
                }

                if ($hpm != null) {
                    if ($hosnumber == null) {
                        $flag3 = true;
                    } else {
                        $hpm = $value->hospital_product_number . "(Hospital Product Number already exist)";
                        $flag3 = false;
                    }
                } else {
                    $flag3 = true;
                }


                $insert = [
                    'clientId' => $request->get('clientId'),
                    'projectId' => $request->get('projectId'),
                    'fileId' => $fileId,
                    'company' => $company,
                    'category' => $category,
                    'supplyItem' => $supplyitem,
                    'mfgPartNumber' => $mfgpart,
                    'hospitalNumber' => $hpm,
                    'doctors' => $doctors,
                    'email' => $email
                ];

                if ($flag1 && $flag2 && $flag3 && $flag4 && $flag6 && $flag7 && $flag9) {

                    // $removeItemdetails = ItemfileDetails::whereIN('id',$removedata)->delete();

                    $itemfiledetails = ItemfileDetails::create($insert);

                    $currentdate = Carbon::now()->format('d-m-Y');

                    $updatedate = Itemfiles::where('id', $fileId)->update(['updateDate' => $currentdate]);

                } else {

                    $wrongdata[] = array(

                        'company' => $company,
                        'category' => $category,
                        'supplyItem' => $supplyitem,
                        'mfgPartNumber' => $mfgpart,
                        'hospitalNumber' => $hpm,
                        'doctors' => $doctors,
                        'email' => $email
                    );
                }


            }

            $status = true;

            if (count($wrongdata) != 0) {
                $status = false;
                return view('pages.itemfiles.importerror', compact('wrongdata', 'fileId'));
            } else {
                return redirect::to('admin/itemfiles');
            }


        }
    }

    public function view($id)
    {

        $itemFile = Itemfiles::where('id', $id)->first();

        $itemfiledetails = itemfiledetails::where('fileId', $id)->orderBy('id', 'DESC')->get();
        $fileid = $id;
        return view('pages.itemfiles.view', compact('itemfiledetails', 'fileid', 'itemFile'));
    }

    public function edit($id)
    {

        $itemFile = Itemfiles::where('id', $id)->first();
        $fileid = $id;
        $itemfiledetails = itemfiledetails::where('fileId', $id)->orderBy('id', 'DESC')->get();
        return view('pages.itemfiles.edit', compact('itemfiledetails', 'fileid', 'itemFile'));
    }

    public function update(Request $request, $id)
    {

        $data = $request->get('detailsId');
        $company = $request->get('company');
        $category = $request->get('category');
        $supplyItem = $request->get('supplyItem');
        $mfgPartNumber = $request->get('mfgPartNumber');
        $hospitalNumber = $request->get('hospitalNumber');
        $doctors = $request->get('doctors');
        $email = $request->get('email');
        $clientId = Itemfiles::where('id', $id)->value('clientId');
        $projectId = Itemfiles::where('id', $id)->value('projectId');
        $wrongdata = array();
        for ($i = 0; $i < count($data); $i++) {

            $rowid = $data[$i];
            $rowdetails = ItemfileDetails::where('id', '=', $rowid)->first();
            $getsupplyitem = $rowdetails['supplyItem'];
            $getmfgpart = $rowdetails['mfgPartNumber'];
            $gethspn = $rowdetails['hospitalNumber'];

            $flag1 = true;
            $flag2 = true;
            $flag3 = true;

            $devicename = $supplyItem[$i];
            $mfgptnumber = $mfgPartNumber[$i];
            $hospnumber = $hospitalNumber[$i];

            if ($getsupplyitem != $supplyItem[$i]) {
                $devicename = ItemfileDetails::where('supplyItem', '=', $supplyItem[$i])->where('clientId', $clientId)
//                    ->where('projectId', $projectId)
                    ->first();
                $flag1 = $devicename == null ? true : false;
                $devicename = $devicename == null ? '' : $supplyItem[$i] . 'Already exist in database';
            }

            if ($getmfgpart != $mfgPartNumber[$i]) {
                $mfgptnumber = ItemfileDetails::where('mfgPartNumber', '=', $mfgPartNumber[$i])->where('mfgPartNumber', '!=', "")->where('clientId', $clientId)
//                    ->where('projectId', $projectId)
                    ->first();
                $flag2 = $mfgptnumber == null ? true : false;
                $mfgptnumber = $mfgptnumber == null ? '' : $mfgPartNumber[$i] . 'Already exist in database';
            }

            if ($gethspn != $hospitalNumber[$i]) {
                $hospnumber = ItemfileDetails::where('hospitalNumber', '=', $hospitalNumber[$i])->where('hospitalNumber', '!=', "")->where('clientId', $clientId)
//                    ->where('projectId', $projectId)
                    ->first();
                $flag3 = $hospnumber == null ? true : false;
                $hospnumber = $hospnumber == null ? '' : $hospitalNumber[$i] . 'Already exist in database';
            }


            $getrecord = array(
                "company" => $company[$i],
                "category" => $category[$i],
                "supplyItem" => $supplyItem[$i],
                "mfgPartNumber" => $mfgPartNumber[$i],
                "hospitalNumber" => $hospitalNumber[$i],
                "doctors" => $doctors[$i],
                "email" => $email[$i],
            );

            if ($flag1 && $flag2 && $flag3) {
                $updaterecord = ItemfileDetails::where('id', $rowid)->update($getrecord);
            } else {
                $wrongdata[] = array(
                    'company' => $company[$i],
                    'category' => $category[$i],
                    'supplyItem' => $devicename,
                    'mfgPartNumber' => $mfgptnumber,
                    'hospitalNumber' => $hospnumber,
                    'doctors' => $doctors[$i],
                    "email" => $email[$i],
                );
            }
        }

        $status = true;
        if (count($wrongdata) != 0) {
            $status = false;
            $fileId = $id;
            return view('pages.itemfiles.importerror', compact('wrongdata', 'fileId'));
        } else {
            $currentdate = Carbon::now();
            $currentdate = Carbon::parse($currentdate)->format('d-m-Y');
            $updatedate = Itemfiles::where('id', $id)->update(['updateDate' => $currentdate]);

            return redirect::to('admin/itemfiles/view/' . $id);

        }

    }

    public function export($id)
    {
        $fileid = $id;

        $details = ItemfileDetails::where('fileId', $fileid)->orderBy('id', 'DESC')->get();
        $itemfiledata = array();
        foreach ($details as $row) {
            $itemfiledata[] = [
                $row['company'],
                $row['category'],
                $row['supplyItem'],
                $row['mfgPartNumber'],
                $row['hospitalNumber'],
                $row['doctors'],
                $row['email']
            ];
        }

        $myFile = Excel::create('Itemfile', function ($excel) use ($itemfiledata) {

            $excel->setTitle('Item File Details');
            $excel->setCreator('Admin')->setCompany('Neptune-PPA');
            $excel->setDescription('Item File Details file');

            $excel->sheet('Itemfile Details', function ($sheet) use ($itemfiledata) {
                $sheet->row(1, array('Company', 'Category', 'Supply Item Description/Size', 'MfgPartNumber', 'Hospital Product Number', 'Doctors','Email'));
                $sheet->row($sheet->getHighestRow(), function ($row) {
                    $row->setFontWeight('bold');
                });
                foreach ($itemfiledata as $row) {
                    $sheet->appendRow($row);
                }
            });
        })->download('xlsx');


    }

    public function search(Request $request)
    {
        $data = $request->all();
        $clientname = $data['search'][0];
        $projectname = $data['search'][1];
        $datecreated = $data['search'][2];
        $dateupdated = $data['search'][3];

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();


        $searchitemfile = Itemfiles::leftJoin('clients', 'clients.id', '=', 'item_files.clientId')
            ->leftJoin('projects', 'projects.id', '=', 'item_files.projectId')
            ->select('item_files.*', 'clients.client_name', 'projects.project_name');

        if ($clientname != "") {
            $searchitemfile = $searchitemfile->where('clients.client_name', 'LIKE', $clientname . '%');
        }

        if ($projectname != "") {
            $searchitemfile = $searchitemfile->where('projects.project_name', 'LIKE', $projectname . '%');
        }

        if ($datecreated != "") {
            $searchitemfile = $searchitemfile->where('item_files.createDate', 'LIKE', $datecreated . '%');
        }

        if ($dateupdated != "") {
            $searchitemfile = $searchitemfile->where('item_files.updateDate', 'LIKE', $dateupdated . '%');
        }

        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');

        }

        if (count($organization) > 0) {

            $searchitemfile = $searchitemfile->whereIn('item_files.clientId', $organization)->get();
        } else {
            $searchitemfile = $searchitemfile->get();
        }
        foreach ($searchitemfile as $row) {

            $row->createat = Carbon::parse($row->createDate)->format('d-m-Y');
            $row->updateat = Carbon::parse($row->updateDate)->format('d-m-Y');

        }
        $data = $searchitemfile;
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

    public function sampledownload()
    {

        $file = "public/upload/csv/itemfile.xlsx";
        return Response::download($file);
        return redirect()->back();
    }

    public function remove($id)
    {
        // dd($id);
        $removefile = Itemfiles::where('id', $id)->delete();

        $removedata = ItemfileDetails::where('fileId', $id)->delete();
        return Redirect::to('admin/itemfiles');
    }

    public function removedata(Request $request, $id)
    {
        $data = $request->get('ck_rep');

        $removedata = ItemfileDetails::whereIN('id', $data)->where('fileId', $id)->delete();
    }

}
