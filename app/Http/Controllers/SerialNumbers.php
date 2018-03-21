<?php

namespace App\Http\Controllers;

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
use App\Serialnumber;
use App\SerialnumberDetail;
use Auth;
use App\device;
use App\project_clients;
use App\client_price;
use Log;
use DateTime;

class SerialNumbers extends Controller
{
    public function index()
    {

    }

    public function create(Request $request, $id)
    {

        $deviceid = $id;
        $projectname = device::where('id', '=', $deviceid)->where('is_delete', '=', '0')->value('project_name');
        $devices = device::findOrFail($id);
        $check_clientname = Serialnumber::where('deviceId', '=', $id)->get();


        $clientname = [];
        foreach ($check_clientname as $clients) {
            $clientname[] = $clients->clientId;

        }

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');

        }

        if (count($organization) > 0) {


            $clients = ['' => 'Client Name']
                + project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')
                    ->where('project_clients.project_id', '=', $projectname)
                    ->whereNotIn('project_clients.client_name', $clientname)
                    ->whereIn('clients.id', $organization)
                    ->pluck('clients.client_name', 'clients.id')
                    ->all();
        } else {
            $clients = ['' => 'Client Name']
                + project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')
                    ->where('project_clients.project_id', '=', $projectname)
                    ->whereNotIn('project_clients.client_name', $clientname)
                    ->pluck('clients.client_name', 'clients.id')
                    ->all();
        }

        return view('pages.serialNumber.add', compact('clients', 'deviceid'));

    }

    public function store(Request $request, $id)
    {

        $rules = array(
            'clientId' => 'required',
            'serialFile' => 'required'
        );

        $messages = [
            'clientId.required' => 'Please select client name.',

        ];


        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $filename = Input::file('serialFile')->getClientOriginalName();

        $checkclientfile = Serialnumber::where('clientId', $request->get('clientId'))->where('deviceId', $id)->first();

        if ($checkclientfile == "") {

            $insertdata = [
                'clientId' => $request->get('clientId'),
                'deviceId' => $id,
                'serialFile' => $filename,
                'createDate' => Carbon::now()->format('d-m-Y'),
                'updateDate' => Carbon::now()->format('d-m-Y')
            ];
            $itemfilestore = new Serialnumber();
            $itemfilestore->fill($insertdata);
            $itemfilestore->save();

            $serialId = $itemfilestore->id;

        } else {

            $serialId = $checkclientfile->id;

        }

        $removedata = array();
        $reItemdetails = SerialnumberDetail::where('serialId', $serialId)->get();

        foreach ($reItemdetails as $re) {
            $removedata[] = $re->id;
        }

        if (Input::hasFile('serialFile')) {

            $path = Input::file('serialFile')->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->get();
            $wrongdata = array();

            foreach ($data as $key => $value) {
                $serial = $value->serial_number;
                $qty = $value->quantity;
                $discount = $value->discount_percentage;
                $purchaseDate = Carbon::parse($value->purchase_date)->format('m-d-Y');
                $expiryDate = Carbon::parse($value->expiry_date)->format('m-d-Y');


                if ($serial != null) {
                    $flag1 = true;
                } else {
                    $serial = $serial . "(Serial Number is Required)";
                    $flag1 = false;
                }

//                if ($qty != null) {
//                    $flag2 = true;
//                } else {
//                    $qty = $qty . "(Quantity is Required)";
//                    $flag2 = false;
//                }

                if ($serial != null) {
                    $serials = SerialnumberDetail::where('serialNumber', '=', $serial)->where('swapType','Swap In')->first();
                }

                if ($serials == null) {
                    $flag2 = true;
                } else {
                    $serial = $value->serial_number . "(Serial Number already exist)";
                    $flag2 = false;
                }

                $insert = [
                    'clientId' => $request->get('clientId'),
                    'deviceId' => $id,
                    'serialId' => $serialId,
                    'serialNumber' => $serial,
                    'status' => "",
                    'discount' => $discount,
                    'purchaseDate' => $purchaseDate,
                    'expiryDate' => $expiryDate,
                    'purchaseType' => 'Bulk',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];


                if ($flag1 && $flag2) {

                    // $removeItemdetails = ItemfileDetails::whereIN('id',$removedata)->delete();

                    $itemfiledetails = SerialnumberDetail::create($insert);

                    $currentdate = Carbon::now();

                    $updatedate = Serialnumber::where('id', $serialId)->update(['updated_at' => $currentdate]);

                } else {

                    $wrongdata[] = array(

                        'serial' => $serial,
                    );
                }


            }

            $status = true;

            if (count($wrongdata) != 0) {

                $count = SerialnumberDetail::where('clientId', $request['clientId'])->where('deviceId', $id)->where('status', '=', '')->count();

                $flag1 = false;
                $flag2 = false;
                $unitbluk = client_price::where('client_name', $request['clientId'])->where('device_id', $id)->where('bulk_check', 'True')->first();
                $systembluk = client_price::where('client_name', $request['clientId'])->where('device_id', $id)->where('system_bulk_check', 'True')->first();

                if (!empty($unitbluk)) {
                    $flag1 = true;
                }

                if (!empty($systembluk)) {
                    $flag2 = true;
                }
                if ($flag1 == true) {
                    $bulk['bulk'] = $count;
                    $bulkupdate = client_price::where('client_name', $request['clientId'])->where('device_id', $id)->update($bulk);
                }

                if ($flag2 == true) {
                    $systembulk['system_bulk'] = $count;
                    $bulkupdate = client_price::where('client_name', $request['clientId'])->where('device_id', $id)->update($systembulk);
                }

                $status = false;
                return view('pages.serialNumber.importerror', compact('wrongdata', 'serialId', 'id'));
            } else {

                $count = SerialnumberDetail::where('clientId', $request['clientId'])->where('deviceId', $id)->where('status', '=', '')->count();

                $flag1 = false;
                $flag2 = false;
                $unitbluk = client_price::where('client_name', $request['clientId'])->where('device_id', $id)->where('bulk_check', 'True')->first();
                $systembluk = client_price::where('client_name', $request['clientId'])->where('device_id', $id)->where('system_bulk_check', 'True')->first();

                if (!empty($unitbluk)) {
                    $flag1 = true;
                }

                if (!empty($systembluk)) {
                    $flag2 = true;
                }
                if ($flag1 == true) {
                    $bulk['bulk'] = $count;
                    $bulkupdate = client_price::where('client_name', $request['clientId'])->where('device_id', $id)->update($bulk);
                }

                if ($flag2 == true) {
                    $systembulk['system_bulk'] = $count;
                    $bulkupdate = client_price::where('client_name', $request['clientId'])->where('device_id', $id)->update($systembulk);
                }

                return redirect::to('admin/devices/view/' . $id . '#6');
            }
        }
    }

    public function import($id)
    {

        $serial = Serialnumber::where('id', $id)->first();

        $client = clients::where('id', $serial['clientId'])->first();

        $clients = ['' => 'Client Name', $client['id'] => $client['client_name']];

        return view('pages.serialNumber.import', compact('clients', 'serial'));
    }

    public function edit($id)
    {
        $serial = Serialnumber::where('id', $id)->first();
        $serialnumberDetails = SerialnumberDetail::where('clientId', $serial['clientId'])->where('deviceId',$serial['deviceId'])->where('purchaseType','Bulk')->orderBy('id', 'desc')->get();
        $serialId = $id;
        return view('pages.serialNumber.edit', compact('serial', 'serialnumberDetails', 'serialId'));
    }

    public function update(Request $request, $id)
    {

        $data = $request->get('detailsId');
        $serial = $request->get('serial');
        $discount = $request->get('discount');
        $purchaseDate = $request->get('purchaseDate');
        $expiryDate = $request->get('expiryDate');

        $clientId = Serialnumber::where('id', $id)->value('clientId');
        $deviceId = Serialnumber::where('id', $id)->value('deviceId');
        $wrongdata = array();
        $serialId = $id;
//dd($request->all());
        for ($i = 0; $i < count($data); $i++) {

            $rowid = $data[$i];
            $rowdetails = SerialnumberDetail::where('id', '=', $rowid)->first();
            $getserial = $rowdetails['serial'];

            $flag1 = true;

            $serials = $serial[$i];


            if ($getserial != $serial[$i]) {

                $serials = SerialnumberDetail::where('serialNumber', $serial[$i])->where('id', '!=', $rowid)->where('swapType','Swap In')->first();

                $flag1 = $serials == null ? true : false;
                $serials = $serials == null ? '' : $serial[$i] . 'Already exist in database';
            }


            $getrecord = array(
                "serialNumber" => $serial[$i],
                "discount" => $discount[$i],
                "purchaseDate" => $purchaseDate[$i],
                "expiryDate" => $expiryDate[$i],
            );


            if ($flag1) {
                $updaterecord = SerialnumberDetail::where('id', $rowid)->update($getrecord);
            } else {
                $wrongdata[] = array(
                    'serial' => $serials,
                );
            }
        }

        $status = true;
        if (count($wrongdata) != 0) {
            $status = false;
            $fileId = $id;
            return view('pages.serialNumber.importerror', compact('wrongdata', 'serialId'));
        } else {
            $currentdate = Carbon::now();
//           $currentdate = Carbon::parse($currentdate)->format('d-m-Y');
            $updatedate = Serialnumber::where('id', $id)->update(['updated_at' => $currentdate]);

            return redirect::to('admin/devices/serialnumber/view/' . $id);
        }

    }

    public function remove($id)
    {

        $deviceId = Serialnumber::where('id', $id)->value('deviceId');

        $client = Serialnumber::where('id', $id)->value('clientId');

        $removefile = Serialnumber::where('id', $id)->delete();

        $removedata = SerialnumberDetail::where('serialId', $id)->delete();

        $count = SerialnumberDetail::where('clientId', $client)->where('deviceId', $deviceId)->where('status', '=', '')->count();

        $flag1 = false;
        $flag2 = false;
        $unitbluk = client_price::where('client_name', $client)->where('device_id', $deviceId)->where('bulk_check', 'True')->first();
        $systembluk = client_price::where('client_name', $client)->where('device_id', $deviceId)->where('system_bulk_check', 'True')->first();

        if (!empty($unitbluk)) {
            $flag1 = true;
        }

        if (!empty($systembluk)) {
            $flag2 = true;
        }
        if ($flag1 == true) {
            $bulk['bulk'] = $count;
            $bulkupdate = client_price::where('client_name', $client)->where('device_id', $deviceId)->update($bulk);
        }

        if ($flag2 == true) {
            $systembulk['system_bulk'] = $count;
            $bulkupdate = client_price::where('client_name', $client)->where('device_id', $deviceId)->update($systembulk);
        }

        return redirect::to('admin/devices/view/' . $deviceId . '#6');
    }

    public function destroy(Request $request, $id)
    {


        $data = $request->get('ck_rep');
        $deviceId = $request->get('device');
        $client = $request->get('client');

        $removedata = SerialnumberDetail::whereIN('id', $data)->where('serialId', $id)->delete();

        $deviceId = Serialnumber::where('id', $id)->value('deviceId');

        $client = Serialnumber::where('id', $id)->value('clientId');

        $count = SerialnumberDetail::where('clientId', $client)->where('deviceId', $deviceId)->where('status', '=', '')->count();

        $flag1 = false;
        $flag2 = false;
        $unitbluk = client_price::where('client_name', $client)->where('device_id', $deviceId)->where('bulk_check', 'True')->first();
        $systembluk = client_price::where('client_name', $client)->where('device_id', $deviceId)->where('system_bulk_check', 'True')->first();

        if (!empty($unitbluk)) {
            $flag1 = true;
        }

        if (!empty($systembluk)) {
            $flag2 = true;
        }
        if ($flag1 == true) {
            $bulk['bulk'] = $count;
            $bulkupdate = client_price::where('client_name', $client)->where('device_id', $deviceId)->update($bulk);
        }

        if ($flag2 == true) {
            $systembulk['system_bulk'] = $count;
            $bulkupdate = client_price::where('client_name', $client)->where('device_id', $deviceId)->update($systembulk);
        }
    }

    public function view($id)
{
    $serial = Serialnumber::where('id', $id)->first();
    $serialnumberDetails = SerialnumberDetail::where('clientId', $serial['clientId'])->where('deviceId',$serial['deviceId'])->where('purchaseType','Bulk')->orderBy('id', 'desc')->get();
    $serialId = $id;
    return view('pages.serialNumber.view', compact('serial', 'serialnumberDetails', 'serialId'));
}

    public function sampledownload()
    {

        $file = "public/upload/csv/serial_number.xlsx";
        return Response::download($file);
        return redirect()->back();
    }

    public function search(Request $request)
    {

        $data = $request->all();
        $clientname = $data['search'][0];
        $datecreated = $data['search'][1];
        $dateupdated = $data['search'][2];
        $deviceId = $data['deviceId'];

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');

        }


        $searchitemfile = Serialnumber::leftJoin('clients', 'clients.id', '=', 'serialNumber.clientId')
            ->select('serialNumber.*', 'clients.client_name');

        if ($clientname != "") {
            $searchitemfile = $searchitemfile->where('clients.client_name', 'LIKE', $clientname . '%');
        }

        if ($datecreated != "") {
            $searchitemfile = $searchitemfile->wheredate('serialNumber.created_at', 'LIKE', $datecreated . '%');
        }

        if ($dateupdated != "") {
            $searchitemfile = $searchitemfile->wheredate('serialNumber.updated_at', 'LIKE', $dateupdated . '%');
        }

        if (count($organization) > 0) {

            $searchitemfile = $searchitemfile->whereIn('serialNumber.clientId', $organization)->where('serialNumber.deviceId', $deviceId)->groupBy('clientId')->orderBy('id', 'desc')->get();
        } else {
            $searchitemfile = $searchitemfile->where('serialNumber.deviceId', $deviceId)->groupBy('clientId')->orderBy('id', 'desc')->get();

        }
        foreach ($searchitemfile as $row) {

            $row->createat = Carbon::parse($row->created_at)->format('Y-m-d');
            $row->updateat = Carbon::parse($row->updated_at)->format('Y-m-d');

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

    public function export($id)
    {
        $serialId = $id;

        $details = SerialnumberDetail::where('serialId', $serialId)->where('purchaseType','Bulk')->orderBy('id', 'DESC')->get();
        $client = Serialnumber::where('id', $id)->first();
        $clientname = $client->client->client_name;

        $device = $client->device->device_name;;

        foreach ($details as $row) {
            $serialdata[] = [
                $row['serialNumber'],
                $row['discount'],
                $row['purchaseDate'],
                $row['expiryDate'],
                $row['status'],

            ];
        }

        $myFile = Excel::create('SerialNumber', function ($excel) use ($serialdata, $clientname, $device) {

            $excel->setTitle('Serial Number Details');
            $excel->setCreator('Admin')->setCompany('Neptune-PPA');
            $excel->setDescription('Serial Number Details file');

            $excel->sheet('Serial Number Details', function ($sheet) use ($serialdata, $clientname, $device) {
                $sheet->row(1, array('Client Name :-', $clientname));
                $sheet->row(2, array('Device Name :-', $device));
                $sheet->row(3, array());
                $sheet->row(4, array('Serial Number', 'Discount', 'Purchase Date', 'Expiry Date', 'Status'));
                $sheet->row($sheet->getHighestRow(), function ($row) {
                    $row->setFontWeight('bold');
                });
                foreach ($serialdata as $row) {
                    $sheet->appendRow($row);
                }
            });
        })->download('xlsx');

    }

    /*Data Migrate For bulk start*/
    public function migratedata()
    {
        $deviceId = array();
        $serial_device = SerialnumberDetail::groupBy('deviceId')->get();
        foreach ($serial_device as $row) {
            $deviceId[] = $row->deviceId;
        }

        $data['bulk'] = "0.00";
        $data['system_bulk'] = '0.00';

        $update = client_price::whereNotIn('device_id', $deviceId)->update($data);

        print_r("Bulk Data Migrate SucessFully..!!");
    }
    /*Data Migrate For bulk End*/

    /*Serial Number Import Bulk Devices.. Start 28-10-2017 12:15 P.M*/
    public function imports(Request $request)
    {

        $filename = Input::file('serial_import')->getClientOriginalName();

        if (Input::hasFile('serial_import')) {

            $path = Input::file('serial_import')->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->get()->groupBy('device_model_number');
            $wrongdata = array();
            $wrongdatas = array();

            foreach ($data as $key => $row) {
                $d1 = $row->groupBy('client_name');
                $device = $key;

                if ($key == null) {
                    $devices = $device . "(Device Model Number is Required)";

                    $wrongdatas[] = array(

                        'serial' => $devices,
                    );

                    return view('pages.serialNumber.importerrors', compact('wrongdatas'));
                } else {

                    foreach ($d1 as $keys => $value) {

                        if ($keys == null) {
                            $client = $keys . "(Client Name is Required)";

                            $wrongdatas[] = array(

                                'serial' => $client,
                            );

                            return view('pages.serialNumber.importerrors', compact('wrongdatas'));
                        } else {

                            $deviceId = device::where('model_name', $device)->value('id');

                            $clientId = clients::where('client_name', $keys)->value('id');

                            /*Enter Serial number Details Start*/

                            $checkclientfile = Serialnumber::where('clientId', $clientId)->where('deviceId', $deviceId)->first();

                            if ($checkclientfile == "") {

                                $insertdata = [
                                    'clientId' => $clientId,
                                    'deviceId' => $deviceId,
                                    'serialFile' => $filename,
                                    'createDate' => Carbon::now()->format('d-m-Y'),
                                    'updateDate' => Carbon::now()->format('d-m-Y')
                                ];
                                Log::debug($insertdata);
//                        print_r($insertdata);
                                $itemfilestore = new Serialnumber();
                                $itemfilestore->fill($insertdata);
                                $itemfilestore->save();

                                $serialId = $itemfilestore->id;

                            } else {

                                $serialId = $checkclientfile->id;

                            }

                            /*Enter Serial number details end**/

                            /*Serial Number Entry*/
                            foreach ($value as $i) {

                                $serial = $i->serial_number;
                                $qty = $i->quantity;
                                $discount = $i->discount_percentage;
                                $purchaseDate = Carbon::parse($i->purchase_date)->format('m-d-Y');
                                $expiryDate = Carbon::parse($i->expiry_date)->format('m-d-Y');

                                if ($serial != null) {
                                    $flag1 = true;
                                } else {
                                    $serial = $serial . "(Serial Number is Required)";
                                    $flag1 = false;
                                }

                                if ($serial != null) {
                                    $serials = SerialnumberDetail::where('serialNumber', '=', $serial)->first();
                                }

                                if ($serials == null) {
                                    $flag2 = true;
                                } else {
                                    $serial = $i->serial_number . "(Serial Number already exist)";
                                    $flag2 = false;
                                }

                                $insert = [
                                    'clientId' => $clientId,
                                    'deviceId' => $deviceId,
                                    'serialId' => $serialId,
                                    'serialNumber' => $serial,
                                    'status' => "",
                                    'discount' => $discount,
                                    'purchaseDate' => $purchaseDate,
                                    'expiryDate' => $expiryDate,
                                    'purchaseType' => 'Bulk',
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                ];
Log::debug($insert);
                                if ($flag1 && $flag2) {

                                    // $removeItemdetails = ItemfileDetails::whereIN('id',$removedata)->delete();

                                    $itemfiledetails = SerialnumberDetail::create($insert);

                                    $currentdate = Carbon::now();

                                    $updatedate = Serialnumber::where('id', $serialId)->update(['updated_at' => $currentdate]);

                                } else {

                                    $wrongdata[] = array(

                                        'serial' => $serial,
                                    );
                                }


                            }
                            /*Serial Number End*/

                            $status = true;

                            if (count($wrongdata) != 0) {

                                $count = SerialnumberDetail::where('clientId', $clientId)->where('deviceId', $deviceId)->where('status', '=', '')->count();

                                $flag1 = false;
                                $flag2 = false;
                                $unitbluk = client_price::where('client_name', $clientId)->where('device_id', $deviceId)->where('bulk_check', 'True')->first();
                                $systembluk = client_price::where('client_name', $clientId)->where('device_id', $deviceId)->where('system_bulk_check', 'True')->first();

                                if (!empty($unitbluk)) {
                                    $flag1 = true;
                                }

                                if (!empty($systembluk)) {
                                    $flag2 = true;
                                }
                                if ($flag1 == true) {
                                    $bulk['bulk'] = $count;
                                    $bulkupdate = client_price::where('client_name', $clientId)->where('device_id', $deviceId)->update($bulk);
                                }

                                if ($flag2 == true) {
                                    $systembulk['system_bulk'] = $count;
                                    $bulkupdate = client_price::where('client_name', $clientId)->where('device_id', $deviceId)->update($systembulk);
                                }

                                $status = false;
                                return view('pages.serialNumber.importerror', compact('wrongdata', 'serialId'));
                            } else {

                                $count = SerialnumberDetail::where('clientId', $clientId)->where('deviceId', $deviceId)->where('status', '=', '')->count();

                                $flag1 = false;
                                $flag2 = false;
                                $unitbluk = client_price::where('client_name', $clientId)->where('device_id', $deviceId)->where('bulk_check', 'True')->first();
                                $systembluk = client_price::where('client_name', $clientId)->where('device_id', $deviceId)->where('system_bulk_check', 'True')->first();

                                if (!empty($unitbluk)) {
                                    $flag1 = true;
                                }

                                if (!empty($systembluk)) {
                                    $flag2 = true;
                                }
                                if ($flag1 == true) {
                                    $bulk['bulk'] = $count;
                                    $bulkupdate = client_price::where('client_name', $clientId)->where('device_id', $deviceId)->update($bulk);
                                }

                                if ($flag2 == true) {
                                    $systembulk['system_bulk'] = $count;
                                    $bulkupdate = client_price::where('client_name', $clientId)->where('device_id', $deviceId)->update($systembulk);
                                }
                            }
                        }
                    }

                }
            }
            return redirect::to('admin/devices');

        }
    }

    public function sampledownloads()
    {

        $file = "public/upload/csv/serial_numbers.xlsx";
        return Response::download($file);
        return redirect()->back();
    }
    /*Serial Number Import Bulk Devices.. End*/

    /***/
    /*Consignment Data Module Start 10/11/2017 10:30 A.M.*/

    public function editconsignment($id)
    {
        $serial = Serialnumber::where('id', $id)->first();
        $serialnumberDetails = SerialnumberDetail::where('clientId', $serial['clientId'])->where('deviceId', $serial['deviceId'])->where('purchaseType','Consignment')->orderBy('id', 'desc')->get();
        $serialId = $id;
//        dd($serialnumberDetails);
        return view('pages.serialNumber.editconsignment', compact('serial', 'serialnumberDetails', 'serialId'));
    }

    public function updateconsignment (Request $request, $id)
    {

        $data = $request->get('detailsId');
        $serial = $request->get('serial');
        $discount = $request->get('discount');
        $purchaseDate = $request->get('purchaseDate');
        $expiryDate = $request->get('expiryDate');

        $clientId = Serialnumber::where('id', $id)->value('clientId');
        $deviceId = Serialnumber::where('id', $id)->value('deviceId');
        $wrongdata = array();
        $serialId = $id;

        for ($i = 0; $i < count($data); $i++) {

            $rowid = $data[$i];
            $rowdetails = SerialnumberDetail::where('id', '=', $rowid)->first();
            $getserial = $rowdetails['serial'];

            $flag1 = true;

            $serials = $serial[$i];


            if ($getserial != $serial[$i]) {

                $serials = SerialnumberDetail::where('serialNumber', $serial[$i])->where('id', '!=', $rowid)->first();

                $flag1 = $serials == null ? true : false;
                $serials = $serials == null ? '' : $serial[$i] . 'Already exist in database';
            }


            $getrecord = array(
                "serialNumber" => $serial[$i],
                "discount" => $discount[$i],
                "purchaseDate" => $purchaseDate[$i],
                "expiryDate" => $expiryDate[$i],
            );


            if ($flag1) {
                $updaterecord = SerialnumberDetail::where('id', $rowid)->update($getrecord);
            } else {
                $wrongdata[] = array(
                    'serial' => $serials,
                );
            }
        }

        $status = true;
        if (count($wrongdata) != 0) {
            $status = false;
            $fileId = $id;
            return view('pages.serialNumber.importerror', compact('wrongdata', 'serialId'));
        } else {
            $currentdate = Carbon::now();
//           $currentdate = Carbon::parse($currentdate)->format('d-m-Y');
            $updatedate = Serialnumber::where('id', $id)->update(['updated_at' => $currentdate]);

            return redirect::to('admin/devices/serialnumber/consignment/' . $id);
        }

    }

    public function viewconsignment($id)
    {

        $serial = Serialnumber::where('id', $id)->first();
        $serialnumberDetails = SerialnumberDetail::where('clientId', $serial['clientId'])->where('deviceId', $serial['deviceId'])->where('purchaseType','Consignment')->orderBy('id', 'desc')->get();
        $serialId = $id;

        return view('pages.serialNumber.viewconsignment', compact('serial', 'serialnumberDetails', 'serialId'));
    }

    public function exportconsignment($id)
    {
        $serialId = $id;

        $client = Serialnumber::where('id', $id)->first();
        $details = SerialnumberDetail::where('clientId', $client['clientId'])->where('deviceId', $client['deviceId'])->where('purchaseType','Consignment')->orderBy('id', 'DESC')->get();
        $clientname = $client->client->client_name;
        $device = $client->device->device_name;;

        foreach ($details as $row) {
            $serialdata[] = [
                $row['serialNumber'],
                $row['discount'],
                $row['purchaseDate'],
                $row['expiryDate'],
                $row['status'],

            ];
        }

        $myFile = Excel::create('SerialNumber', function ($excel) use ($serialdata, $clientname, $device) {

            $excel->setTitle('Serial Number Details');
            $excel->setCreator('Admin')->setCompany('Neptune-PPA');
            $excel->setDescription('Serial Number Details file');

            $excel->sheet('Serial Number Details', function ($sheet) use ($serialdata, $clientname, $device) {
                $sheet->row(1, array('Client Name :-', $clientname));
                $sheet->row(2, array('Device Name :-', $device));
                $sheet->row(3, array());
                $sheet->row(4, array('Serial Number', 'Discount', 'Purchase Date', 'Expiry Date', 'Status'));
                $sheet->row($sheet->getHighestRow(), function ($row) {
                    $row->setFontWeight('bold');
                });
                foreach ($serialdata as $row) {
                    $sheet->appendRow($row);
                }
            });
        })->download('xlsx');

    }

    public function migratedate(Request $request){
//        $data = SerialnumberDetail::orderBy('id','DESC')->limit(10)->get();
//
//        foreach ($data as $row){
//            dump(STR_TO_DATE($row->expiryDate,'%Y,%m,%d'));
////            dump(Carbon::parse($row->expiryDate)->format('Y-m-d'));
//        }
        $now = \Carbon\Carbon::now()->format('m-d-Y');

        $expirydate = SerialnumberDetail::where('deviceId', 187)
            ->where('clientId', 15)
            ->where('status', '=', '')
            ->where('purchaseType', 'Bulk')
            ->where('expiryDate', '>=',$now)
            ->orderBy('expiryDate', 'ASC')
            ->first();

        $your_date = $expirydate['expiryDate'];
        dump($your_date);
        dump($now);


        $d = new DateTime(10-16-2003);

        $timestamp = $d->getTimestamp(); // Unix timestamp
        $formatted_date = $d->format('Y-m-d');

        dd($formatted_date);

        $finalDay = '';
dump($finalDay);
dd('ok');
        if ($finalDay <= 30) {
            $bulk_color = color1;
        } else if (31 <= $finalDay && $finalDay >= 90) {
            $bulk_color = color2;
        } else {
            $bulk_color = color3;
        }
    }

    /**/


}