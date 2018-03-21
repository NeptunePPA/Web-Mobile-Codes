<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\order;
use App\manufacturers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Auth;
use App\user;
use Illuminate\Support\Facades\Validator;
use Response;
use App\userClients;
use App\device;


class orders extends Controller
{
    public function index(Request $request)
    {
        $pagesize = $request->get('pagesize');
        if ($pagesize == "") {
            $pagesize = 10;
        }

        $userid = Auth::user()->id;

        //$organization = user::where('id','=',$userid)->value('organization');

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');

        }

        if (Auth::user()->roll == 2 || Auth::user()->roll == 4 || Auth::user()->roll == 1 && count($organization) > 0) {

            $orders = order::leftjoin('manufacturers', 'manufacturers.id', '=', 'orders.manufacturer_name')
                ->leftjoin('users', 'users.id', '=', 'orders.rep')
                ->leftjoin('users as ob', 'ob.id', '=', 'orders.orderby')
                ->leftjoin('clients', 'clients.id', '=', 'orders.clientId')
                //->whereIn('orders.orderby',$physicians_id)
                ->whereIn('orders.clientId', $organization)
                ->where('orders.is_delete', '=', '0')
                ->where('orders.is_archive', '=', '0')
                ->select('orders.*', 'users.name', 'ob.name as ob_name', 'manufacturers.manufacturer_name', 'clients.client_name')
                ->orderby('orders.id', 'DESC')
                ->paginate($pagesize);

            $count = order::where('orders.is_delete', '=', '0')
                //->whereIn('orders.orderby',$physicians_id)
                ->whereIn('orders.clientId', $organization)
                ->where('orders.is_archive', '=', '0')
                ->count();

        } else if(Auth::user()->roll == 1 && count($organization) <= 0) {
            $orders = order::leftjoin('manufacturers', 'manufacturers.id', '=', 'orders.manufacturer_name')
                ->leftjoin('users', 'users.id', '=', 'orders.rep')
                ->leftjoin('users as ob', 'ob.id', '=', 'orders.orderby')
                ->leftjoin('clients', 'clients.id', '=', 'orders.clientId')
                ->where('orders.is_delete', '=', '0')
                ->where('orders.is_archive', '=', '0')
                ->select('orders.*', 'users.name', 'ob.name as ob_name', 'manufacturers.manufacturer_name', 'clients.client_name')
                ->orderby('orders.id', 'DESC')->paginate($pagesize);
            $count = order::where('orders.is_delete', '=', '0')->where('orders.is_archive', '=', '0')->count();
        }
        return view('pages.order', compact('orders', 'count', 'pagesize'));
    }

    public function edit($id)
    {
        $manufacturer = ['0' => 'Select Manufacturer'] + Manufacturers::where('is_delete', '=', 0)->pluck('manufacturer_name', 'id')->all();
        $orders = order::leftjoin('users', 'users.id', '=', 'orders.rep')->leftjoin('users as ob', 'ob.id', '=', 'orders.orderby')->select('orders.*', 'ob.name as obname', 'users.name')->FindOrFail($id);
        return view('pages.editorder', compact('orders', 'manufacturer'));
    }

    public function update(Request $request, $id)
    {

        if (Auth::user()->roll == 1) {
            $updatedata = array(
//                'manufacturer_name' => $request->get('manufacture'),
//                'model_name' => $request->get('model_name'),
//                'unit_cost' => $request->get('unit_cost'),
//                'system_cost' => $request->get('system_cost'),
//                'cco' => $request->get('cco'),
//                'reimbrusement' => $request->get('reimbrusement'),
//                'order_date' => $request->get('order_date'),
//                'orderby' => $request->get('orderbyuser'),
                'status' => $request->get('status'),
//                'is_delete' => "0"
            );
            $update_order = DB::table('orders')->where('id', '=', $id)->update($updatedata);
            return Redirect::to('admin/orders');
        } else {
            $updatedata = array(
                'status' => $request->get('status')
            );
            $update_order = DB::table('orders')->where('id', '=', $id)->update($updatedata);
            return Redirect::to('admin/orders');
        }


    }


    public function updateall()
    {
        $hiddenid = Input::get('hiddenid');
        $status = Input::get('status');

        foreach (array_combine($hiddenid, $status) as $orderid => $order) {
            $updatedata = array('status' => $order);
            $updatestatus = DB::table('orders')->where('id', '=', $orderid)->update($updatedata);
        }
        return Redirect::to('admin/orders');

    }

    public function search(Request $request)
    {
        $data = $request->all();
        $id = $data['search'][0];
        $client_name = $data['search'][1];
        $manufacturer_name = $data['search'][2];
        $model_name = $data['search'][3];
        $model_no = $data['search'][4];
        $unit_cost = $data['search'][5];
        $system_cost = $data['search'][6];
        $cco = $data['search'][7];
        $reimbrusement = $data['search'][8];
        $order_date = $data['search'][9];
        $ob_name = $data['search'][10];
        $user_name = $data['search'][11];
        $sent_to = $data['search'][12];
        $status = $data['search'][13];

        $userid = Auth::user()->id;

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');

        }

        if (Auth::user()->roll == 2 || Auth::user()->roll == 4 || Auth::user()->roll == 1 && count($organization) > 0 ) {

            $search_orders = order::leftjoin('manufacturers', 'manufacturers.id', '=', 'orders.manufacturer_name')
                ->leftjoin('users', 'users.id', '=', 'orders.rep')
                ->leftjoin('users as ob', 'ob.id', '=', 'orders.orderby')
                ->leftjoin('clients', 'clients.id', '=', 'orders.clientId')
                //->whereIn('orders.orderby',$physicians_id)
                ->whereIn('orders.clientId', $organization)
                ->where('orders.is_delete', '=', '0')
                ->where('orders.is_archive', '=', '0')
                ->select('orders.*', 'users.name', 'ob.name as ob_name', 'manufacturers.manufacturer_name', 'clients.client_name')
                ->orderby('orders.id', 'DESC');

            if (!empty($id)) {
                $search_orders = $search_orders->where('orders.id', 'LIKE', $id . '%');
            }
            if (!empty($client_name)) {
                $search_orders = $search_orders->where('clients.client_name', 'LIKE', $client_name . '%');
            }
            if (!empty($manufacturer_name)) {
                $search_orders = $search_orders->where('manufacturers.manufacturer_name', 'LIKE', $manufacturer_name . '%');
            }
            if (!empty($model_name)) {
                $search_orders = $search_orders->where('orders.model_name', 'LIKE', $model_name . '%');
            }
            if (!empty($model_no)) {
                $search_orders = $search_orders->where('orders.model_no', 'LIKE', $model_no . '%');
            }
            if (!empty($unit_cost)) {
                $search_orders = $search_orders->where('orders.unit_cost', 'LIKE', $unit_cost . '%');
            }
            if (!empty($system_cost)) {
                $search_orders = $search_orders->where('orders.system_cost', 'LIKE', $system_cost . '%');
            }
            if (!empty($cco)) {
                $search_orders = $search_orders->where('orders.cco', 'LIKE', $cco . '%');
            }
            if (!empty($reimbrusement)) {
                $search_orders = $search_orders->where('orders.reimbrusement', 'LIKE', $reimbrusement . '%');
            }
            if (!empty($order_date)) {
                $search_orders = $search_orders->where('orders.order_date', 'LIKE', $order_date . '%');
            }
            if (!empty($ob_name)) {
                $search_orders = $search_orders->where('ob.name', 'LIKE', $ob_name . '%');
            }
            if (!empty($user_name)) {
                $search_orders = $search_orders->where('users.name', 'LIKE', $user_name . '%');
            }
            if (!empty($sent_to)) {
                $search_orders = $search_orders->where('orders.sent_to', 'LIKE', $sent_to . '%');
            }
            if (!empty($status)) {
                $search_orders = $search_orders->where('orders.status', 'LIKE', $status . '%');
            }

            $search_orders = $search_orders->get();

        } else  if (Auth::user()->roll == 1 && count($organization) <= 0 ) {

            $search_orders = order::leftjoin('manufacturers', 'manufacturers.id', '=', 'orders.manufacturer_name')
                ->leftjoin('users', 'users.id', '=', 'orders.rep')
                ->leftjoin('users as ob', 'ob.id', '=', 'orders.orderby')
                ->leftjoin('clients', 'clients.id', '=', 'orders.clientId')
                ->where('orders.is_delete', '=', '0')
                ->where('orders.is_archive', '=', '0')
                ->select('orders.*', 'ob.name as ob_name', 'manufacturers.manufacturer_name', 'users.name', 'clients.client_name')
                ->orderby('orders.id', 'DESC');

            if (!empty($id)) {
                $search_orders = $search_orders->where('orders.id', 'LIKE', $id . '%');
            }
            if (!empty($client_name)) {
                $search_orders = $search_orders->where('clients.client_name', 'LIKE', $client_name . '%');
            }
            if (!empty($manufacturer_name)) {
                $search_orders = $search_orders->where('manufacturers.manufacturer_name', 'LIKE', $manufacturer_name . '%');
            }
            if (!empty($model_name)) {
                $search_orders = $search_orders->where('orders.model_name', 'LIKE', $model_name . '%');
            }
            if (!empty($model_no)) {
                $search_orders = $search_orders->where('orders.model_no', 'LIKE', $model_no . '%');
            }
            if (!empty($unit_cost)) {
                $search_orders = $search_orders->where('orders.unit_cost', 'LIKE', $unit_cost . '%');
            }
            if (!empty($system_cost)) {
                $search_orders = $search_orders->where('orders.system_cost', 'LIKE', $system_cost . '%');
            }
            if (!empty($cco)) {
                $search_orders = $search_orders->where('orders.cco', 'LIKE', $cco . '%');
            }
            if (!empty($reimbrusement)) {
                $search_orders = $search_orders->where('orders.reimbrusement', 'LIKE', $reimbrusement . '%');
            }
            if (!empty($order_date)) {
                $search_orders = $search_orders->where('orders.order_date', 'LIKE', $order_date . '%');
            }
            if (!empty($ob_name)) {
                $search_orders = $search_orders->where('ob.name', 'LIKE', $ob_name . '%');
            }
            if (!empty($user_name)) {
                $search_orders = $search_orders->where('users.name', 'LIKE', $user_name . '%');
            }
            if (!empty($sent_to)) {
                $search_orders = $search_orders->where('orders.sent_to', 'LIKE', $sent_to . '%');
            }
            if (!empty($status)) {
                $search_orders = $search_orders->where('orders.status', 'LIKE', $status . '%');
            }

            $search_orders = $search_orders->get();
        }
        $data = $search_orders;
        foreach ($data as $row) {
            $row->device = $row->devicename['device_name'];
            $row->model = $row->devicename['model_name'];
        }

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
        $remove = DB::table('orders')->where('id', '=', $id)->delete();
        return Redirect::to('admin/orders');
    }

    public function archive()
    {
        $orderchecks = Input::get('order_check');
        for ($i = 0; $i < count($orderchecks); $i++) {
            $setarchive = array('is_archive' => 1);
            $add_acrchive = DB::table('orders')->where('id', '=', $orderchecks[$i])->update($setarchive);

        }
        return Redirect::to('admin/orders');
    }

    public function viewarchive(Request $request)
    {
        $pagesize = $request->get('pagesize');
        if ($pagesize == "") {
            $pagesize = 10;
        }

        $userid = Auth::user()->id;

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');

        }

        if (Auth::user()->roll == 2 || Auth::user()->roll == 4 || Auth::user()->roll == 1 && count($organization) > 0) {

            $physicians = user::leftJoin('user_clients', 'user_clients.userId', '=', 'users.id')
                ->whereIn('user_clients.clientId', $organization)
                ->where('users.roll', '=', 3)
                ->select('users.id')
                ->get();

            $physicians_id = [];
            foreach ($physicians as $physician) {
                $physicians_id[] = $physician->id;

            }
            $orders = order::leftjoin('manufacturers', 'manufacturers.id', '=', 'orders.manufacturer_name')
                ->leftjoin('users', 'users.id', '=', 'orders.rep')
                ->leftjoin('users as ob', 'ob.id', '=', 'orders.orderby')
                ->whereIn('orders.orderby', $physicians_id)
                ->where('orders.is_delete', '=', '0')
                ->whereIn('orders.clientId', $organization)
                ->where('orders.is_archive', '=', '1')
                ->select('orders.*', 'users.name', 'ob.name as ob_name', 'manufacturers.manufacturer_name')
                ->orderby('orders.id', 'DESC')
                ->paginate($pagesize);

            $count = order::where('orders.is_delete', '=', '0')->whereIn('orders.orderby', $physicians_id)->where('orders.is_archive', '=', '1')->count();

        } else if(Auth::user()->roll == 1 && count($organization) <= 0) {
            $orders = order::leftjoin('manufacturers', 'manufacturers.id', '=', 'orders.manufacturer_name')
                ->leftjoin('users', 'users.id', '=', 'orders.rep')
                ->leftjoin('users as ob', 'ob.id', '=', 'orders.orderby')
                ->where('orders.is_delete', '=', '0')
                ->where('orders.is_archive', '=', '1')
                ->select('orders.*', 'users.name', 'ob.name as ob_name', 'manufacturers.manufacturer_name')
                ->orderby('orders.id', 'DESC')->paginate($pagesize);

            $count = order::where('orders.is_delete', '=', '0')->where('orders.is_archive', '=', '1')->count();
        }

        return view('pages.viewarchive', compact('orders', 'count', 'pagesize'));
    }


    public function archiveordersearch(Request $request)
    {

        $data = $request->all();
        $id = $data['search'][0];
        $client_name = $data['search'][1];
        $manufacturer_name = $data['search'][2];
        $model_name = $data['search'][3];
        $model_no = $data['search'][4];
        $unit_cost = $data['search'][5];
        $system_cost = $data['search'][6];
        $cco = $data['search'][7];
        $reimbrusement = $data['search'][8];
        $order_date = $data['search'][9];
        $ob_name = $data['search'][10];
        $user_name = $data['search'][11];
        $sent_to = $data['search'][12];
        $status = $data['search'][13];



            $userid = Auth::user()->id;

            $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
            if ($request->session()->has('adminclient')) {
                $organization = session('adminclient');

            }



        $search_orders = order::leftjoin('manufacturers', 'manufacturers.id', '=', 'orders.manufacturer_name')
            ->leftjoin('users', 'users.id', '=', 'orders.rep')
            ->leftjoin('users as ob', 'ob.id', '=', 'orders.orderby')
            ->leftjoin('clients', 'clients.id', '=', 'orders.clientId');
        if (Auth::user()->roll == 2 || Auth::user()->roll == 4 || Auth::user()->roll == 1 && count($organization) > 0) {

            $search_orders = $search_orders->whereIn('orders.clientId', $organization);
        }


        $search_orders = $search_orders->where('orders.is_delete', '=', '0')
            ->where('orders.is_archive', '=', '1')
            ->select('orders.*', 'users.name', 'ob.name as ob_name', 'manufacturers.manufacturer_name', 'clients.client_name')
            ->orderby('orders.id', 'DESC');

        if (!empty($id)) {
            $search_orders = $search_orders->where('orders.id', 'LIKE', $id . '%');
        }
        if (!empty($client_name)) {
            $search_orders = $search_orders->where('clients.client_name', 'LIKE', $client_name . '%');
        }
        if (!empty($manufacturer_name)) {
            $search_orders = $search_orders->where('manufacturers.manufacturer_name', 'LIKE', $manufacturer_name . '%');
        }
        if (!empty($model_name)) {
            $search_orders = $search_orders->where('orders.model_name', 'LIKE', $model_name . '%');
        }
        if (!empty($model_no)) {
            $search_orders = $search_orders->where('orders.model_no', 'LIKE', $model_no . '%');
        }
        if (!empty($unit_cost)) {
            $search_orders = $search_orders->where('orders.unit_cost', 'LIKE', $unit_cost . '%');
        }
        if (!empty($system_cost)) {
            $search_orders = $search_orders->where('orders.system_cost', 'LIKE', $system_cost . '%');
        }
        if (!empty($cco)) {
            $search_orders = $search_orders->where('orders.cco', 'LIKE', $cco . '%');
        }
        if (!empty($reimbrusement)) {
            $search_orders = $search_orders->where('orders.reimbrusement', 'LIKE', $reimbrusement . '%');
        }
        if (!empty($order_date)) {
            $search_orders = $search_orders->where('orders.order_date', 'LIKE', $order_date . '%');
        }
        if (!empty($ob_name)) {
            $search_orders = $search_orders->where('ob.name', 'LIKE', $ob_name . '%');
        }
        if (!empty($user_name)) {
            $search_orders = $search_orders->where('users.name', 'LIKE', $user_name . '%');
        }
        if (!empty($sent_to)) {
            $search_orders = $search_orders->where('orders.sent_to', 'LIKE', $sent_to . '%');
        }
        if (!empty($status)) {
            $search_orders = $search_orders->where('orders.status', 'LIKE', $status . '%');
        }

        $search_orders = $search_orders->get();

        $data = $search_orders;
        foreach ($data as $row) {
            $row->device = $row->devicename['device_name'];
            $row->model = $row->devicename['model_name'];
        }

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


    public function export()
    {

        $orderid = Input::get('order_check');

        $order_id = [];
        foreach ($orderid as $order) {
            $order_id[] = $order;

        }

        $orders = order::leftjoin('manufacturers', 'manufacturers.id', '=', 'orders.manufacturer_name')
            ->leftjoin('users', 'users.id', '=', 'orders.rep')
            ->leftjoin('users as ob', 'ob.id', '=', 'orders.orderby')
            ->leftJoin('clients', 'clients.id', '=', 'orders.clientId')
            ->where('orders.is_delete', '=', '0')
            ->select('orders.*', 'users.name', 'ob.name as ob_name', 'manufacturers.manufacturer_name', 'clients.client_name')
            ->whereIn('orders.id', $order_id)
            ->orderby('orders.id', 'desc')
            ->get();

        $filename = "orders.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('ID', 'Client Name', 'Manufacturer Name', 'Device Name', 'Model No.', 'Unit Cost', 'System cost', 'CCO', 'Reimbursement', 'Order Date', 'Ordered By', 'Rep', 'Sent to', 'Status'));

        foreach ($orders as $row) {
            fputcsv($handle, array($row['id'], $row['client_name'], $row['manufacturer_name'], $row['model_name'], $row['model_no'], $row['unit_cost'], $row['system_cost'], $row['cco'], $row['reimbrusement'], $row['order_date'], $row['ob_name'], $row['name'], $row['sent_to'], $row['status']));
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return Response::download($filename, 'orders.csv', $headers);
        return Redirect::to('admin/orders');
    }


    public function updateid()
    {
        $order = order::get();

        foreach ($order as $row) {
            // print_r($row->model_name);

            $deviceId = device::where('device_name', $row->model_name)->first();
            // print_r($deviceId['id']);
            $data['deviceId'] = $deviceId['id'];

            $custom = order::where('id', '=', $row->id)->update($data);
        }
        exit();
    }


}
