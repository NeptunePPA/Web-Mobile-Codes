<?php
/**
 * Created by PhpStorm.
 * User: Punit
 * Date: 1/30/2018
 * Time: 10:16 AM
 */

use App\LoginUser;
use App\order;
use App\userClients;
use App\category;
use App\User;
use App\physciansPreferenceAnswer;
use App\ItemFileEntry;
use App\device;
use App\ItemFileMain;
use App\client_price;
use App\clients;

/**
 * User Total Login and Order Count
 * @param $id
 * @param $clientId
 * @return array
 */
function GetuserLogin($id, $clientId)
{

    $userLogin = LoginUser::where('userId', $id)->count();

    $userOrder = order::where('orderby', $id)
//                    ->where('status','Complete')
        ->count();
    $name = User::where('id', $id)->value('name');

    $data = array('login' => $userLogin, 'order' => $userOrder, 'user_name' => $name);

    return $data;
}

/**
 * Client Total Login ANd Order Count
 * @param $id
 * @param $clientId
 * @return array
 */
function GetclientLogin($id, $clientId, $project)
{

    $userclient = userClients::leftjoin('users', 'users.id', '=', 'user_clients.userId')
        ->leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
        ->whereIn('user_clients.clientId', $clientId)

        ->where('users.roll', 3);
    if (!empty($project)) {
        $userclient = $userclient->where('user_projects.projectId', $project);
    }
    $userclient = $userclient->orderBy('user_clients.id', 'ASC')
        ->select('user_clients.userId')
        ->get()->toArray();


    $clientLogin = LoginUser::whereIn('userId', $userclient)->count();

    $clientOrder = order::whereIn('orderby', $userclient)
//                    ->where('status','Complete')
        ->count();

    $data = array('login' => $clientLogin, 'order' => $clientOrder);

    return $data;
}

/**
 * Get Device By Category
 * @param $id
 * @param $clientId
 * @return array
 */

function GetDeviceData($id, $clientId)
{

    $device = order::leftjoin('device', 'device.id', '=', 'orders.deviceId')
        ->leftJoin('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
        ->whereIn('orders.clientId', $clientId)
        ->where('orders.orderby', $id)
        ->select('device.id', 'device.project_name', 'device.category_name', 'device.manufacturer_name', 'device.device_name', 'device.model_name', 'manufacturers.manufacturer_logo')
        ->groupBy('device.id')
        ->get();
    $category = array();
    foreach ($device as $row) {

        if (!empty($row->manufacturer_logo) && file_exists('public/upload/' . $row->manufacturer_logo)) {
            $row->manufacturer_logo = URL::to('public/upload/' . $row->manufacturer_logo);
        } else {
            $row->manufacturer_logo = URL::to('public/upload/default.jpg');
        }

        $row->category = category::where('id', $row->category_name)->value('category_name');

        $survey = array();
        $row->survey = physciansPreferenceAnswer::searchsurvey()
            ->whereIn('physciansPreferenceAnswer.clientId', $clientId)
            ->where('physciansPreferenceAnswer.userId', $id)
            ->where('device.id', $row->id)
            ->get();

        foreach ($row->survey as $item) {
            if ($item['queanswer_yes'] != 0) {
                $survey[] = array(
                    'question' => $item['question'],
                    'value' => $item['queanswer_yes'],
                );
            }

        }

        if (!empty($row->category)) {
            $category[$row->category][] = array(
                'id' => $row->id,
                'project_name' => $row->project_name,
                'category_id' => $row->category_name,
                'manufacturer_name' => $row->manufacturer_name,
                'device_name' => $row->device_name,
                'model_name' => $row->model_name,
                'manufacturer_logo' => $row->manufacturer_logo,
                'category_name' => $row->category,
                'survey' => $survey
            );
        }

    }

    $data = array();

    foreach ($category as $key => $value) {
        $data[] = array(
            'category_name' => $key,
            'devicelist' => $value,
        );
    }

    return $data;
}

function userwisedata($id, $clientId, $project)
{

    $userclient = userClients::leftjoin('users', 'users.id', '=', 'user_clients.userId')
        ->leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
        ->whereIn('user_clients.clientId', $clientId)
        ->where('users.roll', 3);

    if (!empty($project)) {
        $userclient = $userclient->where('user_projects.projectId', $project);
    }

    $userclient = $userclient->orderBy('user_clients.id', 'ASC')
        ->select('user_clients.userId')
        ->get()->toArray();

    $datas = array();
    foreach ($userclient as $row) {
        $datas[] = GetuserLogin($row['userId'], $clientId);
    }

    $data = array();
    foreach ($datas as $row) {
        if (!empty($row['user_name'])) {
            $data[] = $row;
        }
    }

    return $data;
}

/**
 * Analytics Data Start
 */

function oldyearsaving($organization, $year, $month, $user)
{
//    dd($user);
    if (count($organization) > 0) {
        $getItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();

        $getDeviceId = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
            ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
            ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
            ->whereIn('item_file_entry.itemMainId', $getItemfileId)
            ->select('device.*', 'item_file_entry.repcaseID', 'item_file_main.produceDate', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
            ->orderBy('item_file_main.repcaseID', 'ASC')
            ->orderBy('item_file_main.clientId', 'ASC')
            ->groupBy('item_file_entry.id');

    } else {

        $getDeviceId = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
            ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
            ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
            ->select('device.*', 'item_file_entry.repcaseID', 'item_file_main.produceDate', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
            ->orderBy('item_file_main.repcaseID', 'ASC')
            ->orderBy('item_file_main.clientId', 'ASC')
            ->groupBy('item_file_entry.id');
    }

    if (!empty($year)) {
        $getDeviceId = $getDeviceId->whereYear('item_file_main.produceDate', '=', $year);
    }
    if (!empty($month)) {
        $getDeviceId = $getDeviceId->whereMonth('item_file_main.produceDate', '=', $month);
    }

    if (!empty($user)) {
        $getDeviceId = $getDeviceId->where('item_file_main.phyEmail', $user);
    }

    $getDeviceId = $getDeviceId->get();

    $repcaseId = '';
    $isimplanted = '';
    foreach ($getDeviceId as $row) {

        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

        if ($row->repcaseID == $repcaseId && $isimplanted == 'yes' && $row->isImplanted == 'yes') {
            $row->unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->value('system_cost');
            if ($row->discount != '') {
                $row->price = $row->unitprice - (($row->unitprice * $row->discount) / 100);
            } else {
                $row->price = $row->unitprice;
            }
        } else {
            $row->unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->value('unit_cost');
            if ($row->discount != '') {
                $row->price = $row->unitprice - (($row->unitprice * $row->discount) / 100);
            } else {
                $row->price = $row->unitprice;
            }
        }

        if ($row->cco_check == 'True') {
            if ($unitprice['cco_discount_check'] == 'True') {
                $row->price = $row->price - ($row->price * $unitprice['cco_discount']) / 100;
            } else if ($unitprice['cco_check'] == 'True') {
                $row->price = $row->price - $unitprice['cco'];
            }
        }

        if ($row->repless_check == 'True') {
            if ($unitprice['unit_repless_discount_check'] == 'True') {
                $row->price = $row->price - ($row->price * $unitprice['unit_repless_discount']) / 100;
            } else if ($unitprice['unit_rep_cost_check'] == 'True') {
                $row->price = $row->price - $unitprice['unit_rep_cost'];
            }
        }

        $repcaseId = $row->repcaseID;
        $isimplanted = $row->isImplanted;
    }

    $totalprice = '';
    $maxvalue = '';
    $minvalue = '';
    $totaldevice = '';
    $avgvalue = '';


    $device_price = array();

    foreach ($getDeviceId as $row) {
        $device_price[] = array('price' => $row->price);
    }

    $categoryAppvalue = array();

    $totalprice = array_sum(array_column($device_price, 'price'));
//        $maxvalue = max(array_column($getDeviceId, 'price'));
//        $minvalue = min(array_column($getDeviceId, 'price'));
    $totaldevice = count($getDeviceId);

    if ($totalprice != 0 || $totaldevice != 0) {
        $avgvalue = round($totalprice / $totaldevice, 0);
    } else {
        $avgvalue = 0;
    }

    $data = array('avgvalue' => $avgvalue,
        'totaldevice' => $totaldevice,
        'totalprice' => $totalprice,
    );

    return $data;
}

/**
 * Analytics Data End
 */