<?php

namespace App\Http\Controllers\rep;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\roll;
use App\User;
use Auth;
use App\clients;
use App\ItemfileDetails;
use App\ItemFileMain;
use App\ItemFileEntry;
use App\Itemfiles;
use App\order;
use Carbon;
use App\userClients;
use App\device;
use App\SerialnumberDetail;
use App\client_price;

class RepcaseController extends Controller
{
    public function index()
    {
        return view('pages.frontend.repcase.index');
    }

    public function clients(Request $request)
    {

        $clientId = Itemfiles::get();

        $cid = array();
        foreach ($clientId as $row) {
            $cid[] = $row->clientId;
        }

        if (Auth::user()->roll == 2) {
            $userid = Auth::user()->id;
            //$organization = user::where('id', '=', $userid)->value('organization');

            $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
            if ($request->session()->has('adminclient')) {
                $organization = session('adminclient');

            }

            $clients = [NULL => 'Select Hospital'] + clients::orderBy('id', 'asc')
                    ->whereIn('id', $organization)
                    ->whereIn('id', $cid)
                    ->where('is_active', '1')
                    ->pluck('client_name', 'id')
                    ->all();

        } else if (Auth::user()->roll == 5) {

            $clients = [NULL => 'Select Hospital'] + clients::leftjoin('user_clients', 'user_clients.clientId', '=', 'clients.id')
                    ->where('user_clients.userId', Auth::user()->id)
                    ->whereIn('clients.id', $cid)
                    ->orderBy('clients.id', 'asc')
                    ->where('clients.is_active', '1')
                    ->pluck('clients.client_name', 'clients.id')
                    ->all();
        } else {

            $clients = [NULL => 'Select Hospital'] + clients::orderBy('id', 'asc')
                    ->whereIn('id', $cid)
                    ->where('is_active', '1')
                    ->pluck('client_name', 'id')
                    ->all();
        }

        return view('pages.frontend.repcase.selectclient', compact('clients'));
    }

    public function clientRecord(Request $request)
    {

        $client = $request->get('clientId');
        $project = $request->get('projectId');
        $client_name = clients::where('id', $client)->value('client_name');

        if (Auth::user()->roll == "5") {
            $itemfile = ItemFileMain::where('clientId', $client)->where('projectId', $project)->where('item_file_main.repUser', Auth::user()->id)->get();

            $producedates = ItemFileEntry::itemdata()
                ->where('item_file_main.clientId', $client)
                ->where('item_file_main.repUser', Auth::user()->id)
                ->where('item_file_main.projectId', $project)
                ->groupBy('item_file_main.produceDate')
                ->select('item_file_main.produceDate')
                ->get();

            $producedate = array();

            $producedate[null] = "Select Produce Date";
            foreach ($producedates as $row) {
                $date = Carbon\Carbon::parse($row->produceDate)->format('m-d-Y');
                $producedate[$row->produceDate] = $date;
            }

            $caseid = [NULL => 'Select a Case ID'] + ItemFileEntry::itemdata()->where('item_file_main.clientId', $client)->where('item_file_main.repUser', Auth::user()->id)->where('item_file_main.projectId', $project)->groupBy('item_file_main.repcaseID')->pluck('item_file_main.repcaseID', 'item_file_entry.itemMainId')->all();

            $ponumber = ItemFileEntry::itemdata()
                ->where('item_file_main.clientId', $client)
                ->where('item_file_main.projectId', $project)
                ->where('item_file_main.repUser', Auth::user()->id)
                ->where('item_file_entry.poNumber', '!=', '')
                ->where('item_file_entry.swapDate', null)
                ->select('item_file_entry.poNumber', 'item_file_entry.itemMainId')
                ->groupBy('item_file_entry.poNumber')
                ->get();


            $doctors = [NULL => 'Select a Physician'] + ItemFileEntry::itemdata()->where('item_file_main.clientId', $client)->where('item_file_main.repUser', Auth::user()->id)->where('item_file_main.projectId', $project)->groupBy('item_file_main.physician')->pluck('item_file_main.physician', 'item_file_main.physician')->all();

            $serialnumbers = [NULL => 'Select a Serial'] + ItemFileEntry::itemdata()->where('item_file_main.clientId', $client)->where('item_file_main.projectId', $project)->where('item_file_main.repUser', Auth::user()->id)->where('item_file_entry.swapDate', '=', NULL)->where('item_file_entry.swappedId', '=', NULL)->pluck('item_file_entry.serialNumber', 'item_file_entry.serialNumber')->all();
        } elseif (Auth::user()->roll == "2") {

            $itemfile = ItemFileMain::where('clientId', $client)->where('projectId', $project)->get();

            $producedates = ItemFileEntry::itemdata()
                ->where('item_file_main.clientId', $client)
                ->where('item_file_main.projectId', $project)
                ->groupBy('item_file_main.produceDate')
                ->select('item_file_main.produceDate')->get();

            $producedate = array();
            $producedate[NULL] = "Select Produce Date";
            foreach ($producedates as $row) {
                $date = Carbon\Carbon::parse($row->produceDate)->format('m-d-Y');
                $producedate[$row->produceDate] = $date;
            }

            $caseid = [NULL => 'Select a Case ID'] + ItemFileEntry::itemdata()
                    ->where('item_file_main.clientId', $client)
                    ->where('item_file_main.projectId', $project)
                    ->groupBy('item_file_main.repcaseID')
                    ->pluck('item_file_main.repcaseID', 'item_file_entry.itemMainId')->all();

            $ponumber = ItemFileEntry::itemdata()
                ->where('item_file_main.clientId', $client)
                ->where('item_file_main.projectId', $project)
                ->where('item_file_entry.poNumber', '!=', '')
                ->where('item_file_entry.swapDate', null)
                ->select('item_file_entry.poNumber', 'item_file_entry.itemMainId')
                ->groupBy('item_file_entry.poNumber')
                ->get();


            $doctors = [NULL => 'Select a Physician'] + ItemFileEntry::itemdata()->where('item_file_main.clientId', $client)->where('item_file_main.projectId', $project)->groupBy('item_file_main.physician')->pluck('item_file_main.physician', 'item_file_main.physician')->all();

            $serialnumbers = [NULL => 'Select a Serial'] + ItemFileEntry::itemdata()->where('item_file_main.clientId', $client)->where('item_file_main.projectId', $project)->where('item_file_entry.swapDate', '=', NULL)->where('item_file_entry.swappedId', '=', NULL)->pluck('item_file_entry.serialNumber', 'item_file_entry.serialNumber')->all();
        }

        return view('pages.frontend.repcase.clientdata', compact('client_name', 'producedate', 'caseid', 'ponumber', 'doctors', 'serialnumbers', 'project'));

    }

    public function clientRecordList(Request $request)
    {

        $client = $request->get('client');
        $producedate = $request->get('producedate');
        $caseid = $request->get('caseid');
        $ponumber = $request->get('ponumber');
        $doctor = $request->get('doctor');
        $month = $request->get('month');
        $year = $request->get('year');
        $serialNumber = $request->get('serialNumber');
        $project = $request->get('project');

        $clientId = clients::where('client_name', $client)->value('id');

        if ($producedate != '') {

            if (Auth::user()->roll == 5) {
                $data = ItemFileEntry::itemdata()->where('item_file_main.produceDate', $producedate)
                    ->where('item_file_main.clientId', $clientId)
                    ->where('item_file_main.projectId', $project)
                    ->where('item_file_main.repUser', Auth::user()->id)
                    ->groupBy('item_file_entry.id')->get();
            } else if (Auth::user()->roll == 2) {
                $data = ItemFileEntry::itemdata()
                    ->where('item_file_main.clientId', $clientId)
                    ->where('item_file_main.projectId', $project)
                    ->where('item_file_main.produceDate', $producedate)
                    ->groupBy('id')->distinct()->get();
            }
            $itemfile = ItemFileMain::where('produceDate', $producedate)->value('produceDate');
            $itemfile = Carbon\Carbon::parse($itemfile)->format('m-d-Y');
            $status = "produceDate";

        } elseif ($caseid != '') {

            if (Auth::user()->roll == 5) {
                $data = ItemFileEntry::itemdata()->where('item_file_main.clientId', $clientId)
                    ->where('item_file_main.projectId', $project)
                    ->where('item_file_entry.itemMainId', $caseid)
                    ->where('item_file_main.repUser', Auth::user()->id)
                    ->groupBy('item_file_entry.id')->get();

            } else if (Auth::user()->roll == 2) {

                $data = ItemFileEntry::itemdata()->where('item_file_entry.itemMainId', $caseid)
                    ->where('item_file_main.clientId', $clientId)
                    ->where('item_file_main.projectId', $project)
                    ->groupBy('item_file_entry.id')
                    ->get();
            }
            $itemfile = ItemFileMain::where('id', $caseid)->value('repcaseID');
            $status = "caseid";

        } else if ($ponumber != '') {

            if (Auth::user()->roll == 5) {
                $data = ItemFileEntry::itemdata()->where('item_file_main.clientId', $clientId)
                    ->where('item_file_main.projectId', $project)
                    ->where('item_file_entry.poNumber', $ponumber)
                    ->where('item_file_main.repUser', Auth::user()->id)
                    ->groupBy('item_file_entry.serialNumber')->get();

            } elseif (Auth::user()->roll == 2) {

                $data = ItemFileEntry::itemdata()->where('item_file_main.clientId', $clientId)
                    ->where('item_file_main.projectId', $project)
                    ->where('item_file_entry.poNumber', $ponumber)
                    ->groupBy('item_file_entry.serialNumber')->get();
            }
            $itemfile = $ponumber;
            $status = "poNumber";

        } else if ($doctor != "") {

            if (Auth::user()->roll == 5) {
                $data = ItemFileEntry::itemdata()->where('item_file_main.clientId', $clientId)
                    ->where('item_file_main.projectId', $project)
                    ->where('item_file_main.physician', $doctor)
                    ->where('item_file_main.repUser', Auth::user()->id)
                    ->groupBy('item_file_entry.id')->get();
            } elseif (Auth::user()->roll == 2) {

                $data = ItemFileEntry::itemdata()->where('item_file_main.clientId', $clientId)
                    ->where('item_file_main.projectId', $project)
                    ->where('item_file_main.physician', $doctor)
                    ->groupBy('item_file_entry.id')->get();
            }

            $itemfile = ItemFileMain::where('physician', $doctor)->value('physician');

            $status = "physician";

        } else if ($month != "" && $year != "") {

            if (Auth::user()->roll == 5) {
                $data = ItemFileEntry::itemdata()->where('item_file_main.clientId', $clientId)
                    ->where('item_file_main.projectId', $project)
                    ->whereMonth('item_file_main.produceDate', '=', $month)
                    ->whereYear('item_file_main.produceDate', '=', $year)
                    ->where('item_file_main.repUser', Auth::user()->id)
                    ->groupBy('item_file_entry.id')->get();

            } else if (Auth::user()->roll == 2) {

                $data = ItemFileEntry::itemdata()->where('item_file_main.clientId', $clientId)
                    ->where('item_file_main.projectId', $project)
                    ->whereMonth('item_file_main.produceDate', '=', $month)
                    ->whereYear('item_file_main.produceDate', '=', $year)
                    ->groupBy('item_file_entry.id')->get();
            }

            $itemfile = $month . " / " . $year;

            $status = "monthYear";

        } else if ($serialNumber != "") {

            if (Auth::user()->roll == 5) {
                $data = ItemFileEntry::itemdata()->where('item_file_entry.serialNumber', $serialNumber)
                    ->where('item_file_main.clientId', $clientId)
                    ->where('item_file_main.projectId', $project)
                    ->where('item_file_main.repUser', Auth::user()->id)
                    ->groupBy('item_file_entry.serialNumber')->get();
            } elseif (Auth::user()->roll == 2) {

                $data = ItemFileEntry::itemdata()->where('item_file_entry.serialNumber', $serialNumber)
                    ->where('item_file_main.clientId', $clientId)
                    ->where('item_file_main.projectId', $project)
                    ->groupBy('item_file_entry.serialNumber')->get();
            }
            $itemfile = $serialNumber;
            $status = "serialNumber";

        }

        return view('pages.frontend.repcase.clientdatarecord', compact('data', 'itemfile', 'status'));
    }

    public function clientRecordListdata($id)
    {
        $data = ItemFileEntry::where('id', $id)->first();

        if (empty($data)) {
            $data = ItemFileEntry::where('oldid', $id)->first();
        }

        $swap = '';

        $swap = ItemFileEntry::where('id', $data['swapId'])->first();

        if ($data['completeNew'] == "Yes") {
            $swap['new'] = "Yes";
        }

//dd($data);
        return view('pages.frontend.repcase.casedetails', compact('data', 'swap'));
    }

    public function swapdevice($id)
    {
        return view('pages.frontend.repcase.swapdevice', compact('id'));
    }

    public function swapdeviceEdit($id)
    {
        $data = ItemFileEntry::where('id', $id)->first();
        return view('pages.frontend.repcase.caseedit', compact('data'));
    }

    public function swapdeviceUpdate(Request $request, $id)
    {

        $getdevice = ItemFileEntry::where('serialNumber', $request->get('serialNumber'))->where('id', '!=', $id)->get();
        if (count($getdevice) > 0) {
            return redirect()->back()
                ->withErrors(['serialNumber' => 'please Enter Valid serial Number..!!']);
        }

        $checkserial = ItemFileEntry::where('id', $id)->first();

        if ($checkserial['serialNumber'] != $request->get('serialNumber')) {

//            $order = $request->get('order');
//            $orderstatus = order::where('id', $order)->value('status');
//
//            $statusUpdate = ItemFileEntry::where('id', $id)->select('orderId', 'oldOrderStatus')->get();
//            foreach ($statusUpdate as $key) {
//
//                $upoldstatus = order::where('id', $key->orderId)->update(['status' => $key->oldOrderStatus]);
//            }
//
//            $update_serial = ItemFileEntry::where('id', '=', $id)->update(['orderId' => $order, 'oldOrderStatus' => $orderstatus]);

            $insertrecord = array(
                "repcaseID" => $request->get('repcaseID'),
                "supplyItem" => $request->get('supplyItem'),
                "hospitalPart" => $request->get('hospitalPart'),
                "mfgPartNumber" => $request->get('mfgPartNumber'),
                "quantity" => '1',
                "purchaseType" => $request->get('purchaseType'),
                "serialNumber" => $request->get('serialNumber'),
                "poNumber" => $request->get('poNumber'),
                "status" => $checkserial['status'],
                "itemMainId" => $checkserial['itemMainId'],
//                "orderId" => $request->get('order'),
//                "oldOrderStatus" => $orderstatus,
                "category" => $request->get('category'),
                "manufacturer" => $request->get('manufacturer'),
                "projectId" => $checkserial['projectId'],
                "swapDate" => Carbon\Carbon::parse($request->get('produceDate'))->format('Y-m-d'),
                "swapId" => $id,
                "created_at" => Carbon\Carbon::now(),
                "updated_at" => Carbon\Carbon::now()
            );
            $insert_custom_field = new ItemFileEntry;
            $insert_custom_field->fill($insertrecord);
            $insert_custom_field->save();
//            $insert_custom_field = ItemFileEntry::insert($insertrecord);

//            $update['status'] = 'Complete';
//
//            $update_custom_field = order::where('id', $order)->update($update);

            $deleteSerial = SerialnumberDetail::where('serialNumber', $checkserial['serialNumber'])->delete();

            return Redirect::to('repcasetracker/clients/record/list/' . $insert_custom_field->id);
        } else {
            return Redirect::to('repcasetracker/clients/record/list/' . $id);
        }

    }

    public function addcase(Request $request)
    {
        $clientId = Itemfiles::get();

        $cid = array();
        foreach ($clientId as $row) {
            $cid[] = $row->clientId;
        }

        if (Auth::user()->roll == 2) {
            $userid = Auth::user()->id;
            //$organization = user::where('id', '=', $userid)->value('organization');

            $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
            if ($request->session()->has('adminclient')) {
                $organization = session('adminclient');

            }

            $clients = [NULL => 'Select Hospital'] + clients::orderBy('id', 'asc')
                    ->whereIn('id', $organization)
                    ->whereIn('id', $cid)
                    ->where('is_active', '1')
                    ->pluck('client_name', 'id')
                    ->all();

        } else if (Auth::user()->roll == 5) {

            $clients = [NULL => 'Select Hospital'] + clients::leftjoin('user_clients', 'user_clients.clientId', '=', 'clients.id')
                    ->where('user_clients.userId', Auth::user()->id)
                    ->whereIn('clients.id', $cid)
                    ->orderBy('clients.id', 'asc')
                    ->where('clients.is_active', '1')
                    ->pluck('clients.client_name', 'clients.id')
                    ->all();
        } else {

            $clients = [NULL => 'Select Hospital'] + clients::orderBy('id', 'asc')
                    ->whereIn('id', $cid)
                    ->where('is_active', '1')
                    ->pluck('client_name', 'id')
                    ->all();
        }

        // dd($clients);
        $physician = [NULL => 'Select Physician'];

        $project = [NULL => 'Select Project'];

        $category = [NULL => 'Select Category'];

        $company = [NULL => 'Select Company'];

        $repuser = [NULL => 'Select Rep User'];

        $phyEmail = [NULL => 'Select Physician Email'];

        return view('pages.frontend.repcase.addcasedetails', compact('phyEmail','clients', 'physician', 'project', 'category', 'company', 'repuser'));
    }

    public function createcase(Request $request)
    {
//        dd($request->all());
        $rules = array(
            'procedure_date' => 'required',
            'hospital' => 'required',
//            'repUser' =>'required',
            'physician' => 'required',
            'phyEmail'=>'required',
            'category' => 'required',
            'manufacturer' => 'required',
            'supplyItem' => 'required',
            'hospitalPart' => 'required',
            'mfgPartNumber' => 'required',
//            'quantity' => 'required',
            'purchaseType' => 'required',
            'serialNumber' => 'required',
            'poNumber' => 'required',
            'isImplanted' => 'required',
//            'type' => 'required',

        );

        $validator = Validator::make($request->all(), $rules);
//         dd($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $checkserialNumber = $request->get('serialNumber');
        $checksupplyItem = $request->get('supplyItem');

        for ($i = 0; $i < count($checksupplyItem); $i++) {

            $getdevice = ItemFileEntry::where('serialNumber', $checkserialNumber[$i])->where('swapType', 'Swap In')->value('serialNumber');

            if (!empty($getdevice)) {

                return redirect()->back()
                    ->withErrors(['serialNumber' => 'please Enter Valid serial Number..!!']);
            }
        }

//        $orderstatus = array();
//
//        $order = $request->get('order');
//
//        for ($i = 0; $i < count($order); $i++) {
//            $orderstatus[] = order::where('id', $order[$i])->value('status');
//        }

        $date = date_create_from_format('m-d-Y', $request->get('procedure_date'));
        $pdate = $date->format('Y-m-d');

        $last = ItemFileMain::orderBy('id', 'DESC')->value('repcaseID');

        $data['repcaseID'] = $last + 1;
        $data['produceDate'] = $pdate;
        $data['physician'] = $request->get('physician');
        $data['clientId'] = $request->get('hospital');
        $data['projectId'] = $request->get('projectId');
        $data['repUser'] = Auth::user()->id;
        $data['phyEmail'] = $request->get('phyEmail');

        $item_file = new ItemFileMain;
        $item_file->fill($data);

        if ($item_file->save()) {

            $itemMainId = $item_file->id;
            $supplyItem = $request->get('supplyItem');
            $hospitalPart = $request->get('hospitalPart');
            $mfgPartNumber = $request->get('mfgPartNumber');
            $quantity = '1';
            $purchaseType = $request->get('purchaseType');
            $serialNumber = $request->get('serialNumber');
            $poNumber = $request->get('poNumber');
            $status = $request->get('status');
//            $order = $request->get('order');
            $isImplanted = $request->get('isImplanted');
//            $type = $request->get('type');
            $unusedReason = $request->get('unusedReason');
//            $orderstatus = $orderstatus;
            $category = $request->get('category');
            $manufacturer = $request->get('manufacturer');
            $swap = $request->get('swap');
            $cco_check = $request->get('cco_check');
            $repless_check = $request->get('repless_check');
            $dataid = $request->get('dataid');
            $datasId = '';
            $serialNumbers = '';
            $bulks = '';
            $swaps = '';

            for ($i = 0; $i < count($supplyItem); $i++) {
                if ($supplyItem[$i] != "") {

                    $insertrecord = array(
                        "repcaseID" => $item_file->repcaseID,
                        "supplyItem" => $supplyItem[$i],
                        "hospitalPart" => $hospitalPart[$i],
                        "mfgPartNumber" => $mfgPartNumber[$i],
                        "quantity" => $quantity,
                        "purchaseType" => $purchaseType[$i],
                        "serialNumber" => $serialNumber[$i],
                        "poNumber" => $poNumber[$i],
                        "itemMainId" => $itemMainId,
//                        "orderId" => $order[$i],
                        "status" => $status[$i],
//                        "oldOrderStatus" => $orderstatus[$i],
                        "category" => $category[$i],
                        "manufacturer" => $manufacturer[$i],
                        "projectId" => $item_file->projectId,
                        "created_at" => Carbon\Carbon::now(),
                        "updated_at" => Carbon\Carbon::now(),
                        "swapType" => $swap[$i],
                        "dataId" => $dataid[$i],
                        "isImplanted" => $isImplanted[$i],
                        "cco_check" => $cco_check[$i],
                        "repless_check" => $repless_check[$i],
//                        "type" => $type[$i],
                        "unusedReason" => $unusedReason[$i],
                    );

                    if ($purchaseType[$i] == "Consignment") {

                        $getdeviceId = device::where('model_name', $mfgPartNumber[$i])->value('id');

                        if (!empty($getdeviceId)) {
                            $addserial['serialNumber'] = $serialNumber[$i];
                            $addserial['clientId'] = $request->get('hospital');
                            $addserial['deviceId'] = $getdeviceId;
                            $addserial['purchaseType'] = "Consignment";

                            $serialdevice = new SerialnumberDetail();
                            $serialdevice->fill($addserial);
                            $serialdevice->save();
                        }

                    }


                    $upstatus['swapType'] = $swap[$i];
                    if ($purchaseType[$i] == "Bulk") {
                        $upstatus['status'] = "Used In Bulk";
                        $upstatus['swapType'] = $swap[$i];
                    } else {
                        $upstatus['status'] = "Used In Consignment";
                    }

                    $serial = SerialnumberDetail::where('serialNumber', $serialNumber[$i])->first();
                    if ($serial) {
                        $serialupdate = SerialnumberDetail::where('serialNumber', $serialNumber[$i])->update($upstatus);
                    }

                    $getswapedid = ItemFileEntry::where('serialNumber', $serialNumbers)->where('itemMainId', $itemMainId)->first();


                    if ($datasId == $dataid[$i] && $swaps == 'Swap Out') {


                        $sd['swapDate'] = Carbon\Carbon::now()->format('Y-m-d');
                        $sd['swappedId'] = $getswapedid['id'] + 1;
                        $insertrecord['newSwapDate'] = Carbon\Carbon::now()->format('Y-m-d');
                        $upswapedid = ItemFileEntry::where('serialNumber', $serialNumbers)->where('itemMainId', $itemMainId)->update($sd);

                    }


                    if ($datasId == $dataid[$i] && $swaps == 'Swap In') {


                        $insertrecord['swapDate'] = Carbon\Carbon::now()->format('Y-m-d');
                        $insertrecord['swappedId'] = $getswapedid['id'];

                        $sd['newSwapDate'] = Carbon\Carbon::now()->format('Y-m-d');

                        $upswapedid = ItemFileEntry::where('serialNumber', $serialNumbers)->where('itemMainId', $itemMainId)->update($sd);

                    }


                    if ($datasId == $dataid[$i] && $bulks == 'Bulk' && $swaps == 'Swap Out') {

                        $getserialdiscont = SerialnumberDetail::where('serialNumber', $serialNumbers)->first();

                        if (!empty($getserialdiscont)) {

                            $updatediscount = SerialnumberDetail::where('serialNumber', $serialNumber[$i])->update(['discount' => $getserialdiscont['discount'], 'purchaseType' => 'Bulk', 'status' => 'Used In Bulk']);

                            $updatestatus = ItemFileEntry::where('serialNumber', $serialNumbers)->where('itemMainId', $itemMainId)->update(['purchaseType' => 'Consignment']);

                            $insertrecord['purchaseType'] = "Bulk";

                            $upserialold = SerialnumberDetail::where('serialNumber', $serialNumbers)->update(['purchaseType' => 'Consignment', 'discount' => '', 'status' => 'Used In Consignment']);

                        }

                    }

                    if ($datasId == $dataid[$i] && $bulks == 'Consignment' && $swaps == 'Swap In') {

                        $getserialdiscont = SerialnumberDetail::where('serialNumber', $serialNumber[$i])->first();

                        if (!empty($getserialdiscont)) {

                            $updatediscount = SerialnumberDetail::where('serialNumber', $serialNumbers)->update(['discount' => $getserialdiscont['discount'], 'purchaseType' => 'Bulk', 'status' => 'Used In Bulk']);

                            $updatestatus = ItemFileEntry::where('serialNumber', $serialNumber[$i])->where('itemMainId', $itemMainId)->update(['purchaseType' => 'Consignment']);

                            $insertrecord['purchaseType'] = "Bulk";

                            $upserialold = SerialnumberDetail::where('serialNumber', $serialNumber[$i])->update(['purchaseType' => 'Consignment', 'discount' => '', 'status' => 'Used In Consignment']);

                        }

                    }


                    /*Bulk Count Start*/

                    $device = device::where('model_name', $mfgPartNumber[$i])
//                        ->where('device_name', $supplyItem[$i])
                        ->first();
                    if (!empty($device)) {
                        $count = SerialnumberDetail::where('clientId', $item_file->clientId)->where('deviceId', $device->id)->where('status', '=', '')->count();

                        $flag1 = false;
                        $flag2 = false;
                        $unitbluk = client_price::where('client_name', $item_file->clientId)->where('device_id', $device->id)->where('bulk_check', 'True')->value('bulk');
                        $systembluk = client_price::where('client_name', $item_file->clientId)->where('device_id', $device->id)->where('system_bulk_check', 'True')->value('system_bulk');

                        if (!empty($unitbluk)) {
                            $flag1 = true;
                        }

                        if (!empty($systembluk)) {
                            $flag2 = true;
                        }
                        if ($flag1 == true) {
                            $bulk['bulk'] = $count;
                            $bulkupdate = client_price::where('client_name', $item_file->clientId)->where('device_id', $device->id)->update($bulk);
                        }

                        if ($flag2 == true) {
                            $systembulk['system_bulk'] = $count;
                            $bulkupdate = client_price::where('client_name', $item_file->clientId)->where('device_id', $device->id)->update($systembulk);
                        }

                    }
                    /*Bulk Count end*/


                    $insert_custom_field = ItemFileEntry::insert($insertrecord);

                    $datasId = $dataid[$i];
                    $serialNumbers = $serialNumber[$i];
                    $bulks = $purchaseType[$i];
                    $swaps = $swap[$i];

                }

            }


//            $update['status'] = 'Complete';
//
//            $update_custom_field = order::whereIN('id', $order)->update($update);

            return Redirect::to('repcasetracker');
        }
    }

    public function swapdeviceNewEdit($id)
    {
        $data = ItemFileEntry::where('id', $id)->first();

        $category = [NULL => 'Select Category'] + ItemfileDetails::orderBy('id', 'asc')->where('clientId', $data->itemfilename->client['id'])
                ->where('projectId', $data['projectId'])->groupBy('category')
                ->pluck('category', 'category')
                ->all();

        $manufacture = [NULL => 'Select Manufacture'] + ItemfileDetails::orderBy('id', 'asc')->where('clientId', $data->itemfilename->client['id'])
                ->where('projectId', $data['projectId'])->where('category', $data['category'])->groupBy('company')
                ->pluck('company', 'company')
                ->all();

        $supplyItem = [NULL => 'Select Supply Item'] + ItemfileDetails::orderBy('id', 'asc')->where('clientId', $data->itemfilename->client['id'])
                ->where('projectId', $data['projectId'])->where('category', $data['category'])->where('company', $data['manufacturer'])->groupBy('supplyItem')
                ->pluck('supplyItem', 'supplyItem')
                ->all();

        return view('pages.frontend.repcase.casenewedit', compact('data', 'category', 'manufacture', 'supplyItem'));
    }

    /*Swap Device update Start*/
    public function swapdeviceNewUpdate(Request $request, $id)
    {
//        dd($request->all());
        $itemMainId = ItemFileEntry::where('id', $id)->first();

        $itemfile = ItemFileMain::where('id', $itemMainId->itemMainId)->first();

        $rules = array(
            'produceDate' => 'required',
            'client' => 'required',
            'physician' => 'required',
            'category' => 'required',
            'manufacturer' => 'required',
            'supplyItem' => 'required',
//            'hospitalPart' => 'required',
            'mfgPartNumber' => 'required',
//            'quantity' => 'required',
            'purchaseType' => 'required',
            'serialNumber' => 'required',
//            'poNumber' => 'required',

        );

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }


        $getdevice = ItemFileEntry::where('supplyItem', $request->get('supplyItem'))->where('serialNumber', $request->get('serialNumber'))->where('swapType', 'Swap In')->get();
        foreach ($getdevice as $key) {

            if ($key->id != $id) {
                return redirect()->back()
                    ->withErrors(['serialNumber' => 'please Enter Valid serial Number..!!']);
            }
        }
        if ($itemMainId['serialNumber'] != $request->get('serialNumber')) {

//            $order = $request->get('order');
//            $orderstatus = order::where('id', $order)->value('status');
//
//            $statusUpdate = ItemFileEntry::where('id', $id)->select('orderId', 'oldOrderStatus')->get();
//            foreach ($statusUpdate as $key) {
//
//                $upoldstatus = order::where('id', $key->orderId)->update(['status' => $key->oldOrderStatus]);
//            }
            $data['repcaseID'] = $request->get('repcaseID');
            $data['supplyItem'] = $request->get('supplyItem');
            $data['hospitalPart'] = $request->get('hospitalPart');
            $data['mfgPartNumber'] = $request->get('mfgPartNumber');
            $data['quantity'] = '1';
            $data['purchaseType'] = $request->get('purchaseType');
            $data['serialNumber'] = $request->get('serialNumber');
            $data['poNumber'] = $request->get('poNumber');
            $data['status'] = $request->get('status');
//            $data['orderId'] = $request->get('order');
            $data['category'] = $request->get('category');
            $data['manufacturer'] = $request->get('manufacturer');
            $data['newSwapDate'] = Carbon\Carbon::now()->format('Y-m-d');
            $data['projectId'] = $itemMainId['projectId'];
            $data['swapId'] = $request->get('swapId');
            $data['itemMainId'] = $itemMainId['itemMainId'];
//            $data['oldOrderStatus'] = $orderstatus;
            $data['swapType'] = "Swap In";
            $data['created_at'] = Carbon\Carbon::now();
            $data['updated_at'] = Carbon\Carbon::now();

            $Itemfiles = new ItemFileEntry;
            $Itemfiles->fill($data);
            $Itemfiles->save();

            /*Serial Number Delete in Device start*/
            $checkDeleteSerial = ItemFileEntry::where('id', $request->get('swapId'))->first();
            $deleteSerial = SerialnumberDetail::where('serialNumber', $checkDeleteSerial['serialNumber'])->update(['status' => '']);
            /*Serial Number Delete in Device End*/

            if ($request->get('purchaseType') == "Consignment") {

                $getdeviceId = device::where('model_name', $request->get('mfgPartNumber'))->value('id');

                if (!empty($getdeviceId)) {
                    $addserial['serialNumber'] = $request->get('serialNumber');
                    $addserial['clientId'] = $itemfile['clientId'];
                    $addserial['deviceId'] = $getdeviceId;
                    $addserial['purchaseType'] = "Consignment";

                    $serialdevice = new SerialnumberDetail();
                    $serialdevice->fill($addserial);
                    $serialdevice->save();
                }

            }

            if ($request->get('purchaseType') == "Bulk") {
                $upstatus['status'] = "Used In Bulk";
            } else {
                $upstatus['status'] = "Used In Consignment";
            }

            $serial = SerialnumberDetail::where('serialNumber', $request->get('serialNumber'))->first();
            if ($serial) {
                $serialupdate = SerialnumberDetail::where('serialNumber', $request->get('serialNumber'))->update($upstatus);
            }

            /*Bulk Count Start*/

            $device = device::where('model_name', $request->get('mfgPartNumber'))
//                ->where('device_name', $request->get('supplyItem'))
                ->first();

            if (!empty($device)) {

                $count = SerialnumberDetail::where('clientId', $itemfile['clientId'])->where('deviceId', $device->id)->where('status', '=', '')->count();

                $flag1 = false;
                $flag2 = false;
                $unitbluk = client_price::where('client_name', $itemfile['clientId'])->where('device_id', $device->id)->where('bulk_check', 'True')->first();
                $systembluk = client_price::where('client_name', $itemfile['clientId'])->where('device_id', $device->id)->where('system_bulk_check', 'True')->first();

                if (!empty($unitbluk)) {
                    $flag1 = true;
                }

                if (!empty($systembluk)) {
                    $flag2 = true;
                }

                if ($flag1 == true) {
                    $bulk['bulk'] = $count;
                    $bulkupdate = client_price::where('client_name', $itemfile['clientId'])->where('device_id', $device->id)->update($bulk);
                }

                if ($flag2 == true) {
                    $systembulk['system_bulk'] = $count;
                    $bulkupdate = client_price::where('client_name', $itemfile['clientId'])->where('device_id', $device->id)->update($systembulk);
                }
            }
//die;
            /*Bulk Count end*/

            $sep['swappedId'] = $Itemfiles->id;
            $sep['swapDate'] = Carbon\Carbon::now()->format('Y-m-d');
            $sep['swapType'] = "Swap Out";
            $updata = ItemFileEntry::where('id', $request->get('swapId'))->update($sep);

//            $order = $request->get('order');
//            $update['status'] = 'Complete';
//
//            $update_custom_field = order::where('id', $order)->update($update);

            return Redirect::to('repcasetracker/clients/record/list/' . $Itemfiles->id);
        } else {
            return Redirect::to('repcasetracker/clients/record/list/' . $id);
        }
    }

    /*Swap new Device update*/
    public function swapdeviceNewUpdates(Request $request, $id)
    {
//dd($request->all());
        $itemMainId = ItemFileEntry::where('id', $id)->first();

        $itemfile = ItemFileMain::where('id', $itemMainId->itemMainId)->first();

        $rules = array(
            'produceDate' => 'required',
            'client' => 'required',
            'physician' => 'required',
            'category' => 'required',
            'manufacturer' => 'required',
            'supplyItem' => 'required',
//            'hospitalPart' => 'required',
            'mfgPartNumber' => 'required',
//            'quantity' => 'required',
            'purchaseType' => 'required',
            'serialNumber' => 'required',
//            'poNumber' => 'required',

        );

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }


        $getdevice = ItemFileEntry::where('supplyItem', $request->get('supplyItem'))->where('serialNumber', $request->get('serialNumber'))->where('swapType', 'Swap In')->get();
        foreach ($getdevice as $key) {

            if ($key->id != $id) {
                return redirect()->back()
                    ->withErrors(['serialNumber' => 'please Enter Valid serial Number..!!']);
            }
        }

        /*Check Serial number in itemfile entry db*/

        $serialnumbers = ItemFileEntry::where('itemMainId', $itemMainId['itemMainId'])->get();
        $serialno = array();
        foreach ($serialnumbers as $item) {
            $serialno[] = $item->serialNumber;
        }


        if ($itemMainId['serialNumber'] != $request->get('serialNumber')) {

            if (!in_array($request->get('serialNumber'), $serialno)) {

                $data['repcaseID'] = $request->get('repcaseID');
                $data['supplyItem'] = $request->get('supplyItem');
                $data['hospitalPart'] = $request->get('hospitalPart');
                $data['mfgPartNumber'] = $request->get('mfgPartNumber');
                $data['quantity'] = '1';
                $data['purchaseType'] = $request->get('purchaseType');
                $data['serialNumber'] = $request->get('serialNumber');
                $data['poNumber'] = $request->get('poNumber');
                $data['status'] = $request->get('status');
//                $data['orderId'] = $request->get('order');
                $data['category'] = $request->get('category');
                $data['manufacturer'] = $request->get('manufacturer');
                $data['newSwapDate'] = Carbon\Carbon::now()->format('Y-m-d');
                $data['projectId'] = $itemMainId['projectId'];
                $data['swapId'] = $request->get('swapId');
                $data['itemMainId'] = $itemMainId['itemMainId'];
//            $data['oldOrderStatus'] = $orderstatus;
                $data['swapType'] = "Swap In";
                $data['completeNew'] = "Yes";
                $data['created_at'] = Carbon\Carbon::now();
                $data['updated_at'] = Carbon\Carbon::now();

                $Itemfiles = new ItemFileEntry;
                $Itemfiles->fill($data);
                $Itemfiles->save();

                /*Serial Number Delete in Device start*/
                $checkDeleteSerial = ItemFileEntry::where('id', $request->get('swapId'))->first();
                $deleteSerial = SerialnumberDetail::where('serialNumber', $checkDeleteSerial['serialNumber'])->delete();
                /*Serial Number Delete in Device End*/

                if ($request->get('purchaseType') == "Consignment") {

                    $getdeviceId = device::where('model_name', $request->get('mfgPartNumber'))->value('id');

                    if (!empty($getdeviceId)) {
                        $addserial['serialNumber'] = $request->get('serialNumber');
                        $addserial['clientId'] = $itemfile['clientId'];
                        $addserial['deviceId'] = $getdeviceId;
                        $addserial['purchaseType'] = "Consignment";

                        $serialdevice = new SerialnumberDetail();
                        $serialdevice->fill($addserial);
                        $serialdevice->save();
                    }

                }

                if ($request->get('purchaseType') == "Bulk") {
                    $upstatus['status'] = "Used In Bulk";
                } else {
                    $upstatus['status'] = "Used In Consignment";
                }

                $serial = SerialnumberDetail::where('serialNumber', $request->get('serialNumber'))->first();
                if ($serial) {
                    $serialupdate = SerialnumberDetail::where('serialNumber', $request->get('serialNumber'))->update($upstatus);
                }

                /*Bulk Count Start*/

                $device = device::where('model_name', $request->get('mfgPartNumber'))
//                    ->where('device_name', $request->get('supplyItem'))
                    ->first();

                if (!empty($device)) {
                    $count = SerialnumberDetail::where('clientId', $itemfile['clientId'])->where('deviceId', $device->id)->where('status', '=', '')->count();

                    $flag1 = false;
                    $flag2 = false;
                    $unitbluk = client_price::where('client_name', $itemfile['clientId'])->where('device_id', $device->id)->where('bulk_check', 'True')->first();
                    $systembluk = client_price::where('client_name', $itemfile['clientId'])->where('device_id', $device->id)->where('system_bulk_check', 'True')->first();

                    if (!empty($unitbluk)) {
                        $flag1 = true;
                    }

                    if (!empty($systembluk)) {
                        $flag2 = true;
                    }
                    if ($flag1 == true) {
                        $bulk['bulk'] = $count;
                        $bulkupdate = client_price::where('client_name', $itemfile['clientId'])->where('device_id', $device->id)->update($bulk);
                    }

                    if ($flag2 == true) {
                        $systembulk['system_bulk'] = $count;
                        $bulkupdate = client_price::where('client_name', $itemfile['clientId'])->where('device_id', $device->id)->update($systembulk);
                    }
                    /*Bulk Count end*/
                }
//            $order = $request->get('order');
//            $update['status'] = 'Complete';
//
//            $update_custom_field = order::where('id', $order)->update($update);


                $sep['swappedId'] = $Itemfiles->id;
                $sep['swapDate'] = Carbon\Carbon::now()->format('Y-m-d');
                $sep['swapType'] = "Swap Out";
                $updata = ItemFileEntry::where('id', $request->get('swapId'))->update($sep);


                return Redirect::to('repcasetracker/clients/record/list/' . $Itemfiles->id);
            }
        } else {

            return Redirect::to('repcasetracker/clients/record/list/' . $id);
        }
    }

    /*Swap Device Update End*/
    public function getserialnumber(Request $request)
    {
        $supplyItem = $request->get('supplyItem');
        $model = $request->get('mfgPartNumber');
        $client = $request->get('client');

        $device = device::where('model_name', $model)
//            ->where('device_name', $supplyItem)
            ->first();

        $check = array();
        $checkserial = ItemFileEntry::get();

        foreach ($checkserial as $row) {
            $check[] = $row->serialNumber;
        }


        $serialNumber = SerialnumberDetail::where('clientId', $client)->where('deviceId', $device['id'])
            ->whereNotIn('serialNumber', $check)->where('status', null)->get();

        $data = $serialNumber;

        $html = "<select name ='serialNumber[]' class='form-control input-type-format serialNumber' id='serialNumber' data-id='" . $request->get('id') . "'><option value=''>Select Serial Number</option>";

        foreach ($serialNumber as $row) {
            $html .= "<option value='" . $row->serialNumber . "'>" . $row->serialNumber . "</option>";
        }

        $html .= "</select>";

        if (count($data))


            return [
                'value' => $html,
                'status' => TRUE
            ];
        else
            return [
                'value' => 'No result Found',
                'status' => FALSE
            ];

    }

    public function getserialnumbers(Request $request)
    {

        $supplyItem = $request->get('supplyItem');
        $model = $request->get('mfgPartNumber');
        $client = $request->get('client');
        $serialNumber = $request->get('serialNumber');

        $device = device::where('model_name', $model)
//            ->where('device_name', $supplyItem)
            ->first();

        $check = array();
        $checkserial = ItemFileEntry::get();

        foreach ($checkserial as $row) {
            $check[] = $row->serialNumber;
        }


        $serialNumbers = SerialnumberDetail::where('clientId', $client)->where('deviceId', $device['id'])
            ->whereNotIn('serialNumber', $check)->get();

        $data = $serialNumbers;

//        $html = "<select name ='serialNumber[]' class='form-control input-type-format serialNumber' id='serialNumber' data-id='" . $request->get('id') . "'><option value=''>Select Serial Number</option>";
//
//        $html .= "<option value='" . $serialNumber . "' SELECTED>" . $serialNumber . "</option>";
//
//        foreach ($data as $row) {
//            $html .= "<option value='" . $row->serialNumber . "'>" . $row->serialNumber . "</option>";
//        }
//
//        $html .= "</select>";

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
}
