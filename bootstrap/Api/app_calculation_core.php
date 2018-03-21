<?php
/**
 * Created by PhpStorm.
 * User: Punit
 * Date: 2/15/2018
 * Time: 3:32 PM
 */

use App\client_price;
use App\ItemFileEntry;
use App\ItemFileMain;
use App\manufacturers;
use App\SerialnumberDetail;
use App\User;

function categoryAppvalue($organization, $id, $project, $year, $level)
{

    $getDeviceId = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
        ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
        ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
        ->select('device.*', 'item_file_entry.repcaseID', 'item_file_main.produceDate', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
        ->orderBy('item_file_main.repcaseID', 'ASC')
        ->orderBy('item_file_main.clientId', 'ASC');


    if (count($organization) > 0) {
        $getItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();

        $getDeviceId = $getDeviceId->whereIn('item_file_entry.itemMainId', $getItemfileId);
    }

    if (!empty($project)) {
        $getDeviceId = $getDeviceId->where('device.project_name', $project);
    }
    if (!empty($level)) {
        $getDeviceId = $getDeviceId->where('device.level_name', $level);
    }

    $getDeviceId = $getDeviceId->whereYear('item_file_main.produceDate', '=', $year)
        ->get();

    $repcaseId = '';
    $isimplanted = '';
    foreach ($getDeviceId as $row) {

        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

        $row->discount = SerialnumberDetail::where('deviceId',$row->id)
            ->where('status','')
            ->where('purchaseType','Bulk')
            ->where('clientId',$row->clientId)
            ->max('discount');

        $row->unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->value('unit_cost');
        if ($row->discount != '') {
            $row->price = $row->unitprice - (($row->unitprice * $row->discount) / 100);
        } else {
            $row->price = $row->unitprice;
        }
        $type = 'Unit';
//        }

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

    $category = array();
    foreach ($getDeviceId as $item) {
        $category[$item->category_name][] = $item;
    }
    $totalprice = '';
    $maxvalue = '';
    $minvalue = '';
    $totaldevice = '';
    $avgvalue = '';

    $categoryAppvalue = array();
    foreach ($category as $item => $value) {
        $totalprice = array_sum(array_column($value, 'price'));
        $maxvalue = max(array_column($value, 'price'));
        $minvalue = min(array_column($value, 'price'));
        $totaldevice = count($value);

        if ($totalprice != 0 || $totaldevice != 0) {
            $avgvalue = round($totalprice / $totaldevice, 0);
        } else {
            $avgvalue = 0;
        }

        if ($id == $item) {

            $devices = device_price($organization, $project, $level, $id, $type);
//            dd($devices['maxvalue']);
            $categoryAppvalue = array(
                'totalprice' => intval($totalprice),
                'maxvalue' => intval($devices['maxvalue']),
                'minvalue' => intval($devices['minvalue']),
                'totaldevice' => $totaldevice,
                'category_app_avg_value' => intval($avgvalue),
            );
        }

    }

    $categoryAppEntryApp = $categoryAppvalue;

    return $categoryAppEntryApp;
}

function manufacture_App_value($organization, $id, $project, $year, $level, $category)
{
    if (count($organization) > 0) {
        $EntrymanufacatureItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();

        $EntrymanufacaturegetDeviceId = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
            ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
            ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
            ->whereIn('item_file_entry.itemMainId', $EntrymanufacatureItemfileId)
            ->where('device.category_name', $id)
            ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
            ->where('device.level_name', $level)
            ->orderBy('item_file_main.repcaseID', 'ASC')
            ->orderBy('item_file_main.clientId', 'ASC');
//            ->whereMonth('item_file_entry.updated_at', '=', Current_month)

    } else {
        $EntrymanufacaturegetDeviceId = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
            ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
            ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
            ->where('device.category_name', $id)
            ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
            ->where('device.level_name', $level)
            ->orderBy('item_file_main.repcaseID', 'ASC')
            ->orderBy('item_file_main.clientId', 'ASC');
//            ->whereMonth('item_file_entry.updated_at', '=', Current_month)

    }

    if (!empty($project)) {
        $EntrymanufacaturegetDeviceId = $EntrymanufacaturegetDeviceId->where('device.project_name', $project);
    }

    $EntrymanufacaturegetDeviceId = $EntrymanufacaturegetDeviceId->whereYear('item_file_main.produceDate', '=', $year)
        ->get();

    $EntrymanufacaturerepcaseId = '';
    $Entrymanufacatureisimplanted = '';
    foreach ($EntrymanufacaturegetDeviceId as $row) {

        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

        $row->discount = SerialnumberDetail::where('deviceId', $row->id)->where('status', '')->where('purchaseType', 'Bulk')->where('clientId', $row->clientId)->max('discount');

//        if ($row->repcaseID == $EntrymanufacaturerepcaseId && $Entrymanufacatureisimplanted == 'yes' && $row->isImplanted == 'yes') {
        //            $row->unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->value('system_cost');
        //            if ($row->discount != '') {
        //                $row->price = $row->unitprice - (($row->unitprice * $row->discount) / 100);
        //            } else {
        //                $row->price = $row->unitprice;
        //            }
        //        } else {
        $row->unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->value('unit_cost');
        if ($row->discount != '') {
            $row->price = $row->unitprice - (($row->unitprice * $row->discount) / 100);
        } else {
            $row->price = $row->unitprice;
        }
//        }

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

        $EntrymanufacaturerepcaseId = $row->repcaseID;
        $Entrymanufacatureisimplanted = $row->isImplanted;
    }

    $Entrymanufacature = array();
    foreach ($EntrymanufacaturegetDeviceId as $item) {
        $Entrymanufacature[$item->manufacturer_name][] = $item;
    }
    $Entrymanufacaturetotalprice = '';
    $Entrymanufacaturemaxvalue = '';
    $Entrymanufacatureminvalue = '';
    $Entrymanufacaturetotaldevice = '';
    $categoryEntrymanufacatureApp = '';

    $EntrymanufacatureAppvalue = array();
    $avgApp = array();
    foreach ($Entrymanufacature as $item => $value) {
        $Entrymanufacaturetotalprice = array_sum(array_column($value, 'price'));
        $Entrymanufacaturemaxvalue = max(array_column($value, 'price'));
        $Entrymanufacatureminvalue = min(array_column($value, 'price'));
        $Entrymanufacaturetotaldevice = count($value);

        if ($Entrymanufacaturetotalprice != 0 || $Entrymanufacaturetotaldevice != 0) {
            $Entrymanufacatureavgvalue = round($Entrymanufacaturetotalprice / $Entrymanufacaturetotaldevice, 0);
        } else {
            $Entrymanufacatureavgvalue = 0;
        }

        $manufacture_name = manufacturers::where('id', $item)->value('short_name');

        $EntrymanufacatureAppvalue[$item] = array(
            'totalprice' => $Entrymanufacaturetotalprice,
            'maxvalue' => $category['maxvalue'],
            'minvalue' => $category['minvalue'],
            'totaldevice' => $Entrymanufacaturetotaldevice,
            'category_app_avg_value' => $category['category_app_avg_value'],
            'avg_app_value' => $Entrymanufacatureavgvalue,
            'name' => $manufacture_name,
        );

    }

    $avgapp = array();

    foreach ($EntrymanufacatureAppvalue as $entry) {
        $avgapp[] = $entry;
    }

    return $avgapp;
}

function physician_app_value($organization, $id, $project, $year, $level, $category)
{
    if (count($organization) > 0) {
        $EntryphysicianItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();

        $EntryphysiciangetDeviceId = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
            ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
            ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
            ->whereIn('item_file_entry.itemMainId', $EntryphysicianItemfileId)
            ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_main.physician', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
            ->where('device.level_name', $level)
            ->where('device.category_name', $id)
            ->orderBy('item_file_main.repcaseID', 'ASC')
            ->orderBy('item_file_main.clientId', 'ASC');
//            ->whereMonth('item_file_entry.updated_at', '=', Current_month)

    } else {
        $EntryphysiciangetDeviceId = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
            ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
            ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
            ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_main.physician', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
            ->where('device.level_name', $level)
            ->where('device.category_name', $id)
            ->orderBy('item_file_main.repcaseID', 'ASC')
            ->orderBy('item_file_main.clientId', 'ASC');
//            ->whereMonth('item_file_entry.updated_at', '=', Current_month)

    }

    if (!empty($project)) {
        $EntryphysiciangetDeviceId = $EntryphysiciangetDeviceId->where('device.project_name', $project);
    }

    $EntryphysiciangetDeviceId = $EntryphysiciangetDeviceId->whereYear('item_file_main.produceDate', '=', $year)
        ->get();

    $EntryphysicianrepcaseId = '';
    $Entryphysicianisimplanted = '';
    foreach ($EntryphysiciangetDeviceId as $row) {

        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

        $row->discount = SerialnumberDetail::where('deviceId', $row->id)->where('status', '')->where('purchaseType', 'Bulk')->where('clientId', $row->clientId)->max('discount');

//        if ($row->repcaseID == $EntryphysicianrepcaseId && $Entryphysicianisimplanted == 'yes' && $row->isImplanted == 'yes') {
        //            $row->unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->value('system_cost');
        //            if ($row->discount != '') {
        //                $row->price = $row->unitprice - (($row->unitprice * $row->discount) / 100);
        //            } else {
        //                $row->price = $row->unitprice;
        //            }
        //        } else {
        $row->unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->value('unit_cost');
        if ($row->discount != '') {
            $row->price = $row->unitprice - (($row->unitprice * $row->discount) / 100);
        } else {
            $row->price = $row->unitprice;
        }
//        }

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

        $EntryphysicianrepcaseId = $row->repcaseID;
        $Entryphysicianisimplanted = $row->isImplanted;
    }

    $Entryphysician = array();
    foreach ($EntryphysiciangetDeviceId as $item) {
        $Entryphysician[$item->physician][] = $item;
    }
    $Entryphysiciantotalprice = '';
    $Entryphysicianmaxvalue = '';
    $Entryphysicianminvalue = '';
    $Entryphysiciantotaldevice = '';
    $categoryEntryphysicianApp = '';

    $EntryphysicianAppvalue = array();
    foreach ($Entryphysician as $item => $value) {
        $Entryphysiciantotalprice = array_sum(array_column($value, 'price'));
        $Entryphysicianmaxvalue = max(array_column($value, 'price'));
        $Entryphysicianminvalue = min(array_column($value, 'price'));
        $Entryphysiciantotaldevice = count($value);

        if ($Entryphysiciantotalprice != 0 || $Entryphysiciantotaldevice != 0) {
            $Entryphysicianavgvalue = round($Entryphysiciantotalprice / $Entryphysiciantotaldevice, 0);
        } else {
            $Entryphysicianavgvalue = 0;
        }

        $phymanufature = physician_manufacture_app_value($organization, $id, $project, $year, $level, $category);
        $manu = '';
//dd($phymanufature);
        foreach ($phymanufature as $row) {
            if ($row['name'] == $item) {
                $manu = $row['data'];
            }
        }
        $EntryphysicianAppvalue[$item] = array(
            'totalprice' => $Entryphysiciantotalprice,
            'maxvalue' => $category['maxvalue'],
            'minvalue' => $category['minvalue'],
            'totaldevice' => $Entryphysiciantotaldevice,
            'category_app_avg_value' => $category['category_app_avg_value'],
            'avg_app_value' => $Entryphysicianavgvalue,
            'name' => $item,
            'physician_manufacture_app' => $manu,
        );

    }

    $categoryEntryphysicianApp = $EntryphysicianAppvalue;

    $avgapp = array();

    foreach ($categoryEntryphysicianApp as $entry) {
        $avgapp[] = $entry;
    }

    return $avgapp;

}

function physician_manufacture_app_value($organization, $id, $project, $year, $level, $category)
{

    if (count($organization) > 0) {
        $EntryphysicianManufactureItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();

        $EntryphysicianManufacturegetDeviceId = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
            ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
            ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
            ->whereIn('item_file_entry.itemMainId', $EntryphysicianManufactureItemfileId)
            ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_main.physician', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
            ->where('device.level_name', $level)
            ->where('device.category_name', $id)
            ->orderBy('item_file_main.repcaseID', 'ASC')
            ->orderBy('item_file_main.clientId', 'ASC');
//            ->whereMonth('item_file_entry.updated_at', '=', Current_month)

    } else {
        $EntryphysicianManufacturegetDeviceId = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
            ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
            ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
            ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_main.physician', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
            ->where('device.level_name', $level)
            ->where('device.category_name', $id)
            ->orderBy('item_file_main.repcaseID', 'ASC')
            ->orderBy('item_file_main.clientId', 'ASC');
//            ->whereMonth('item_file_entry.updated_at', '=', Current_month)

    }

    if (!empty($projects)) {
        $EntryphysicianManufacturegetDeviceId = $EntryphysicianManufacturegetDeviceId->where('device.project_name', $project);
    }

    $EntryphysicianManufacturegetDeviceId = $EntryphysicianManufacturegetDeviceId->whereYear('item_file_main.produceDate', '=', $year)
        ->get();

    $EntryphysicianmanufacaturerepcaseId = '';
    $Entryphysicianmanufacatureisimplanted = '';
    foreach ($EntryphysicianManufacturegetDeviceId as $row) {

        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

        $row->discount = SerialnumberDetail::where('deviceId', $row->id)->where('status', '')->where('purchaseType', 'Bulk')->where('clientId', $row->clientId)->max('discount');

//        if ($row->repcaseID == $EntryphysicianmanufacaturerepcaseId && $Entryphysicianmanufacatureisimplanted == 'yes' && $row->isImplanted == 'yes') {
        //            $row->unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->value('system_cost');
        //            if ($row->discount != '') {
        //                $row->price = $row->unitprice - (($row->unitprice * $row->discount) / 100);
        //            } else {
        //                $row->price = $row->unitprice;
        //            }
        //        } else {
        $row->unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->value('unit_cost');
        if ($row->discount != '') {
            $row->price = $row->unitprice - (($row->unitprice * $row->discount) / 100);
        } else {
            $row->price = $row->unitprice;
        }
//        }

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

        $EntryphysicianmanufacaturerepcaseId = $row->repcaseID;
        $Entryphysicianmanufacatureisimplanted = $row->isImplanted;
    }

    $EntryPhysicianManufacature = array();
    foreach ($EntryphysicianManufacturegetDeviceId as $item => $value) {
        $EntryPhysicianManufacature[$value->manufacturer_name][$value->physician][] = $value;
    }

    $EntryPhysicianManufacaturetotalprice = '';
    $EntryPhysicianManufacaturemaxvalue = '';
    $EntryPhysicianManufacatureminvalue = '';
    $EntryPhysicianManufacaturetotaldevice = '';
    $categoryEntryPhysicianManufacatureApp = '';

    $EntryPhysicianManufacatureAppvalue = array();
    $phymanufactures = array();
    $phymanufacture = array();

    foreach ($EntryPhysicianManufacature as $item => $data) {

        foreach ($data as $row => $value) {

            $EntryPhysicianManufacaturetotalprice = array_sum(array_column($value, 'price'));
            $EntryPhysicianManufacaturemaxvalue = max(array_column($value, 'price'));
            $EntryPhysicianManufacatureminvalue = min(array_column($value, 'price'));
            $EntryPhysicianManufacaturetotaldevice = count($value);

            if ($EntryPhysicianManufacaturetotalprice != 0 || $EntryPhysicianManufacaturetotaldevice != 0) {
                $EntryPhysicianManufacatureavgvalue = round($EntryPhysicianManufacaturetotalprice / $EntryPhysicianManufacaturetotaldevice, 0);
            } else {
                $EntryPhysicianManufacatureavgvalue = 0;
            }

            $manufacture_name = manufacturers::where('id', $item)->value('short_name');

            $EntryPhysicianManufacatureAppvalue[$row][$item] = array(
                'totalprice' => $EntryPhysicianManufacaturetotalprice,
                'maxvalue' => $category['maxvalue'],
                'minvalue' => $category['minvalue'],
                'totaldevice' => $EntryPhysicianManufacaturetotaldevice,
                'avg_app_value' => $EntryPhysicianManufacatureavgvalue,
                'physician_name' => $row,
                'manufacturer_name' => $manufacture_name,
            );

        }
    }

    $categoryEntryPhysicianManufacatureApp = $EntryPhysicianManufacatureAppvalue;

    foreach ($EntryPhysicianManufacatureAppvalue as $mahuphy => $mnphy) {

        $newphy = array_map("unserialize", array_unique(array_map("serialize", $mnphy)));
        $names = array();
        foreach ($newphy as $user) {
            $names[] = $user['avg_app_value'];
        }

        array_multisort($names, SORT_ASC, $newphy);

        $EntryPhysicianManufacatureAppvalue[$mahuphy] = $newphy;

    }

    $data = array();
    foreach ($EntryPhysicianManufacatureAppvalue as $item => $row) {
        $data[] = array(
            'name' => $item,
            'data' => $row,
        );
    }
    return $data;
}

/**
 * System App calculation Start
 */

function systemappvalue($organization, $id, $level, $year, $project)
{

    $entrydevice = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
        ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
        ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
        ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
        ->where('item_file_entry.swapType', '!=', 'Swap Out')
        ->where('item_file_entry.isImplanted', '!=', 'no')
        ->orderBy('item_file_main.repcaseID', 'ASC')
        ->orderBy('item_file_main.clientId', 'ASC');

    if (count($organization) > 0) {
        $entrySystemItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();

        $entrydevice = $entrydevice->whereIn('item_file_entry.itemMainId', $entrySystemItemfileId);
    }

    if (!empty($project)) {
        $entrydevice = $entrydevice->where('device.project_name', $project);
    }

    if (!empty($level)) {
        $entrydevice = $entrydevice->where('device.level_name', $level);
    }

    $entrydevice = $entrydevice->whereYear('item_file_main.produceDate', '=', $year)
        ->get();

    $EntrySystemrepcaseId = '';
    $EntrySystemisimplanted = '';

    foreach ($entrydevice as $row) {

        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

        $row->discount = SerialnumberDetail::where('deviceId', $row->id)
            ->where('status', '')
            ->where('purchaseType', 'Bulk')
            ->where('clientId', $row->clientId)
            ->max('discount');

        $row->unitprice = client_price::where('device_id', $row->id)
            ->where('client_name', $row->clientId)
            ->value('system_cost');


        if ($row->discount != '') {
            $row->price = $row->unitprice - (($row->unitprice * $row->discount) / 100);
        } else {
            $row->price = $row->unitprice;
        }

        if ($row->repless_check == 'True') {
            if ($unitprice['system_repless_discount_check'] == 'True') {
                $row->price = $row->price - ($row->price * $unitprice['system_repless_discount']) / 100;
            } else if ($unitprice['system_repless_cost_check'] == 'True') {
                $row->price = $row->price - $unitprice['system_repless_cost'];
            }
        }

        $EntrySystemrepcaseId = $row->repcaseID;
        $EntrySystemisimplanted = $row->isImplanted;
    }


    $EntrySystemcategory = array();
    foreach ($entrydevice as $item) {
        $EntrySystemcategory[$item->category_name][] = $item;
    }

    $EntrySystemtotalprice = '';
    $EntrySystemmaxvalue = '';
    $EntrySystemminvalue = '';
    $EntrySystemtotaldevice = '';
    $EntrySystemavgvalue = '';

    $EntrySystemcategoryAppvalue = array();
    foreach ($EntrySystemcategory as $item => $value) {
        $EntrySystemtotalprice = array_sum(array_column($value, 'price'));
        $EntrySystemmaxvalue = max(array_column($value, 'price'));
        $EntrySystemminvalue = min(array_column($value, 'price'));
        $EntrySystemtotaldevice = count($value);

        if ($EntrySystemtotalprice != 0 || $EntrySystemtotaldevice != 0) {
            $EntrySystemavgvalue = round($EntrySystemtotalprice / $EntrySystemtotaldevice, 0);
        } else {
            $EntrySystemavgvalue = 0;
        }

        if ($id == $item) {

            $devices = device_price($organization, $project, $level, $id, 'System');

            $EntrySystemcategoryAppvalue = array(
                'totalprice' => $EntrySystemtotalprice,
                'maxvalue' => $devices['maxvalue'],
                'minvalue' => $devices['minvalue'],
                'totaldevice' => $EntrySystemtotaldevice,
                'category_app_avg_value' => $EntrySystemavgvalue,
            );
        }
    }

    $categorySystemAppEntryApp = $EntrySystemcategoryAppvalue;

    return $categorySystemAppEntryApp;
}

function systemphysician($organization, $id, $category, $level, $year, $project)
{
    if (count($organization) > 0) {
        $PhysicianSystemItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();

        $PhysicianDevice = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
            ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
            ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
            ->whereIn('item_file_entry.itemMainId', $PhysicianSystemItemfileId)
            ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_main.physician', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
            ->where('item_file_entry.swapType', '!=', 'Swap Out')
            ->where('device.category_name', $id)
            ->where('item_file_entry.isImplanted', '!=', 'no')
            ->orderBy('item_file_main.repcaseID', 'ASC')
            ->orderBy('item_file_main.clientId', 'ASC');

    } else {
        $PhysicianDevice = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
            ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
            ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
            ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_main.physician', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
            ->where('item_file_entry.swapType', '!=', 'Swap Out')
            ->where('device.category_name', $id)
            ->where('item_file_entry.isImplanted', '!=', 'no')
            ->orderBy('item_file_main.repcaseID', 'ASC')
            ->orderBy('item_file_main.clientId', 'ASC');
    }

    if (!empty($project)) {

        $PhysicianDevice = $PhysicianDevice->where('device.project_name', $project);
    }

    $PhysicianDevice = $PhysicianDevice->whereYear('item_file_main.produceDate', '=', $year)
        ->get();

    $PhysicianSystemrepcaseId = '';
    $PhysicianSystemisimplanted = '';
    foreach ($PhysicianDevice as $row) {

        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

        $row->discount = SerialnumberDetail::where('deviceId', $row->id)->where('status', '')->where('purchaseType', 'Bulk')->where('clientId', $row->clientId)->max('discount');

        $row->unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->value('system_cost');
        if ($row->discount != '') {
            $row->price = $row->unitprice - (($row->unitprice * $row->discount) / 100);
        } else {
            $row->price = $row->unitprice;
        }

//        if ($row->cco_check == 'True') {
        //            if ($unitprice['cco_discount_check'] == 'True') {
        //                $row->price = $row->price - ($row->price * $unitprice['cco_discount']) / 100;
        //            } else if ($unitprice['cco_check'] == 'True') {
        //                $row->price = $row->price - $unitprice['cco'];
        //            }
        //        }

        if ($row->repless_check == 'True') {
            if ($unitprice['system_repless_discount_check'] == 'True') {
                $row->price = $row->price - ($row->price * $unitprice['system_repless_discount']) / 100;
            } else if ($unitprice['system_repless_cost_check'] == 'True') {
                $row->price = $row->price - $unitprice['system_repless_cost'];
            }
        }

        $PhysicianSystemrepcaseId = $row->repcaseID;
        $PhysicianSystemisimplanted = $row->isImplanted;
    }

    $PhysicianSystemcategory = array();
    foreach ($PhysicianDevice as $item) {
        $PhysicianSystemcategory[$item->physician][] = $item;
    }
    $PhysicianSystemtotalprice = '';
    $PhysicianSystemmaxvalue = '';
    $PhysicianSystemminvalue = '';
    $PhysicianSystemtotaldevice = '';
    $PhysicianSystemavgvalue = '';

    $PhysicianSystemAppvalue = array();
    $PhysicianSystemAppvalues1 = array();
    foreach ($PhysicianSystemcategory as $item => $value) {
        $PhysicianSystemtotalprice = array_sum(array_column($value, 'price'));
        $PhysicianSystemmaxvalue = max(array_column($value, 'price'));
        $PhysicianSystemminvalue = min(array_column($value, 'price'));
        $PhysicianSystemtotaldevice = count($value);

        if ($PhysicianSystemtotalprice != 0 || $PhysicianSystemtotaldevice != 0) {
            $PhysicianSystemavgvalue = round($PhysicianSystemtotalprice / $PhysicianSystemtotaldevice, 0);
        } else {
            $PhysicianSystemavgvalue = 0;
        }
        $PhysicianSystemAppvalue[$item] = array(
            'totalprice' => $PhysicianSystemtotalprice,
            'maxvalue' => $category['maxvalue'],
            'minvalue' => $category['minvalue'],
            'totaldevice' => $PhysicianSystemtotaldevice,
            'category_app_avg_value' => $category['category_app_avg_value'],
            'avg_app_value' => $PhysicianSystemavgvalue,
            'name' => $item,
            'physician_manufacture_app' => array(),

        );

//        $PhysicianSystemAppvalues1[$item][] = array(
        //            'totalprice' => $PhysicianSystemtotalprice,
        //            'maxvalue' => $PhysicianSystemmaxvalue,
        //            'minvalue' => $PhysicianSystemminvalue,
        //            'totaldevice' => $PhysicianSystemtotaldevice,
        //            'avgvalue' => $PhysicianSystemavgvalue,
        //            'physician_name' => $item,
        //        );

    }

    $PhysicianSystemAppEntryApp = $PhysicianSystemAppvalue;

    $avgapp = array();

    foreach ($PhysicianSystemAppEntryApp as $entry) {
        $avgapp[] = $entry;
    }

    return $avgapp;

//    $PhysicianSystemAppEntryApp = array('PhysicianSystemAppvalue' => $PhysicianSystemAppvalue, 'PhysicianSystemAppvalues' => $PhysicianSystemAppvalue);

}

function systemmanufacture($organization, $id, $category, $level, $year, $project)
{

    if (count($organization) > 0) {
        $entryManufactureSystemItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();

        $entrydeviceManufacture = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
            ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
            ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
            ->whereIn('item_file_entry.itemMainId', $entryManufactureSystemItemfileId)
            ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
            ->where('device.level_name', $level)
            ->where('item_file_entry.swapType', '!=', 'Swap Out')
            ->where('item_file_entry.isImplanted', '!=', 'no')
            ->where('device.category_name', $id)
            ->orderBy('item_file_main.repcaseID', 'ASC')
            ->orderBy('item_file_main.clientId', 'ASC');

    } else {
        $entrydeviceManufacture = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
            ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
            ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
            ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
            ->where('device.level_name', $level)
            ->where('item_file_entry.swapType', '!=', 'Swap Out')
            ->where('item_file_entry.isImplanted', '!=', 'no')
            ->where('device.category_name', $id)
            ->orderBy('item_file_main.repcaseID', 'ASC')
            ->orderBy('item_file_main.clientId', 'ASC');
    }

    if (!empty($projects)) {
        $entrydeviceManufacture = $entrydeviceManufacture->where('device.project_name', $project);
    }

    $entrydeviceManufacture = $entrydeviceManufacture->whereYear('item_file_main.produceDate', '=', $year)
        ->get();

    $ManufatureSystemrepcaseId = '';
    $ManufatureSystemisimplanted = '';
    foreach ($entrydeviceManufacture as $row) {

        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

        $row->discount = SerialnumberDetail::where('deviceId', $row->id)->where('status', '')->where('purchaseType', 'Bulk')->where('clientId', $row->clientId)->max('discount');

        $row->unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->value('system_cost');
        if ($row->discount != '') {
            $row->price = $row->unitprice - (($row->unitprice * $row->discount) / 100);
        } else {
            $row->price = $row->unitprice;
        }

//        if ($row->cco_check == 'True') {
        //            if ($unitprice['cco_discount_check'] == 'True') {
        //                $row->price = $row->price - ($row->price * $unitprice['cco_discount']) / 100;
        //            } else if ($unitprice['cco_check'] == 'True') {
        //                $row->price = $row->price - $unitprice['cco'];
        //            }
        //        }

        if ($row->repless_check == 'True') {
            if ($unitprice['system_repless_discount_check'] == 'True') {
                $row->price = $row->price - ($row->price * $unitprice['system_repless_discount']) / 100;
            } else if ($unitprice['system_repless_cost_check'] == 'True') {
                $row->price = $row->price - $unitprice['system_repless_cost'];
            }
        }

        $ManufatureSystemrepcaseId = $row->repcaseID;
        $ManufatureSystemisimplanted = $row->isImplanted;
    }

    $manufatures = array();

    foreach ($entrydeviceManufacture as $value) {
        $manufatures[$value->repcaseID][] = $value;

    }
    $manu = array();

    foreach ($manufatures as $rows => $items) {
        $caseId = '';
        $device = '';
        foreach ($items as $i => $i1) {

            if ($device == '') {
                $device = $i1->manufacturer_name;
            } elseif ($device != $i1->manufacturer_name) {
                $caseId = 'False';
                break;
            } elseif ($device == $i1->manufacturer_name) {
                $caseId = 'True';
            }
//                    $caseId = $i->repcaseID;
            $device = $i1->manufacturer_name;
        }
        if ($caseId == 'True') {

            $manu[$rows] = $items;
        }
    }

    $manufapp = array();

    foreach ($manu as $value => $keys) {
        foreach ($keys as $rows) {
            $manufapp[] = $rows;
        }

    }

    $Entrymanufacature = array();
    foreach ($manufapp as $item) {
        $Entrymanufacature[$item['manufacturer_name']][] = $item;
    }

    $Entrymanufacaturetotalprice = '';
    $Entrymanufacaturemaxvalue = '';
    $Entrymanufacatureminvalue = '';
    $Entrymanufacaturetotaldevice = '';
    $categoryEntrymanufacatureApp = '';

    $EntrymanufacatureAppvalue = array();
    $avgApps = array();
    if (count($Entrymanufacature) > 0) {
        foreach ($Entrymanufacature as $item => $value) {
            $Entrymanufacaturetotalprice = array_sum(array_column($value, 'price'));
            $Entrymanufacaturemaxvalue = max(array_column($value, 'price'));
            $Entrymanufacatureminvalue = min(array_column($value, 'price'));
            $Entrymanufacaturetotaldevice = count($value);

            if ($Entrymanufacaturetotalprice != 0 || $Entrymanufacaturetotaldevice != 0) {
                $Entrymanufacatureavgvalue = round($Entrymanufacaturetotalprice / $Entrymanufacaturetotaldevice, 0);
            } else {
                $Entrymanufacatureavgvalue = 0;
            }

            $manufacture_name = manufacturers::where('id', $item)->value('short_name');

            $EntrymanufacatureAppvalue[$item] = array(
                'totalprice' => $Entrymanufacaturetotalprice,
                'maxvalue' => $category['maxvalue'],
                'minvalue' => $category['minvalue'],
                'totaldevice' => $Entrymanufacaturetotaldevice,
                'category_app_avg_value' => $category['category_app_avg_value'],
                'avg_app_value' => $Entrymanufacatureavgvalue,
                'name' => $manufacture_name,
            );

        }
    }

    $categoryEntrymanufacatureApp = $EntrymanufacatureAppvalue;

    foreach ($categoryEntrymanufacatureApp as $entry) {

        $avgApps[] = $entry;
    }
    return $avgApps;
}

/**
 * User wise App start
 */

function physician_user_app_value($organization, $id, $project, $year, $level, $category, $user)
{
    if (count($organization) > 0) {
        $EntryphysicianItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();

        $EntryphysiciangetDeviceId = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
            ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
            ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
            ->whereIn('item_file_entry.itemMainId', $EntryphysicianItemfileId)
            ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_main.physician', 'item_file_main.phyEmail', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
            ->where('device.level_name', $level)
            ->where('device.category_name', $id)
            ->orderBy('item_file_main.repcaseID', 'ASC')
            ->orderBy('item_file_main.clientId', 'ASC');
//            ->whereMonth('item_file_entry.updated_at', '=', Current_month)

    } else {
        $EntryphysiciangetDeviceId = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
            ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
            ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
            ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_main.physician', 'item_file_main.phyEmail', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
            ->where('device.level_name', $level)
            ->where('device.category_name', $id)
            ->orderBy('item_file_main.repcaseID', 'ASC')
            ->orderBy('item_file_main.clientId', 'ASC');
//            ->whereMonth('item_file_entry.updated_at', '=', Current_month)

    }

    if (!empty($project)) {
        $EntryphysiciangetDeviceId = $EntryphysiciangetDeviceId->where('device.project_name', $project);
    }

    $EntryphysiciangetDeviceId = $EntryphysiciangetDeviceId->whereYear('item_file_main.produceDate', '=', $year)
        ->get();

    $EntryphysicianrepcaseId = '';
    $Entryphysicianisimplanted = '';
    foreach ($EntryphysiciangetDeviceId as $row) {

        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

        $row->discount = SerialnumberDetail::where('deviceId', $row->id)->where('status', '')->where('purchaseType', 'Bulk')->where('clientId', $row->clientId)->max('discount');

//        if ($row->repcaseID == $EntryphysicianrepcaseId && $Entryphysicianisimplanted == 'yes' && $row->isImplanted == 'yes') {
        //            $row->unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->value('system_cost');
        //            if ($row->discount != '') {
        //                $row->price = $row->unitprice - (($row->unitprice * $row->discount) / 100);
        //            } else {
        //                $row->price = $row->unitprice;
        //            }
        //        } else {
        $row->unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->value('unit_cost');
        if ($row->discount != '') {
            $row->price = $row->unitprice - (($row->unitprice * $row->discount) / 100);
        } else {
            $row->price = $row->unitprice;
        }
//        }

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

        $EntryphysicianrepcaseId = $row->repcaseID;
        $Entryphysicianisimplanted = $row->isImplanted;
    }

    $Entryphysician = array();
    foreach ($EntryphysiciangetDeviceId as $item) {
        $Entryphysician[$item->phyEmail][] = $item;
    }
    $Entryphysiciantotalprice = '';
    $Entryphysicianmaxvalue = '';
    $Entryphysicianminvalue = '';
    $Entryphysiciantotaldevice = '';
    $categoryEntryphysicianApp = '';

    $EntryphysicianAppvalue = array();
    foreach ($Entryphysician as $item => $value) {
        $Entryphysiciantotalprice = array_sum(array_column($value, 'price'));
        $Entryphysicianmaxvalue = max(array_column($value, 'price'));
        $Entryphysicianminvalue = min(array_column($value, 'price'));
        $Entryphysiciantotaldevice = count($value);

        if ($Entryphysiciantotalprice != 0 || $Entryphysiciantotaldevice != 0) {
            $Entryphysicianavgvalue = round($Entryphysiciantotalprice / $Entryphysiciantotaldevice, 0);
        } else {
            $Entryphysicianavgvalue = 0;
        }

        $manu = '';

        if ($item == $user['email']) {
            $EntryphysicianAppvalue[$item] = array(

                'totalprice' => $Entryphysiciantotalprice,
                'maxvalue' => $category['maxvalue'],
                'minvalue' => $category['minvalue'],
                'totaldevice' => $Entryphysiciantotaldevice,
                'category_app_avg_value' => $category['category_app_avg_value'],
                'avg_app_value' => $Entryphysicianavgvalue,
                'name' => $user['name'],
                'physician_manufacture_app' => $manu,
            );
        }
    }

    $categoryEntryphysicianApp = $EntryphysicianAppvalue;

    $avgapp = array();

    foreach ($categoryEntryphysicianApp as $entry) {
        $avgapp[] = $entry;
    }

    return $avgapp;

}

function physician_user_manufacture_app_value($organization, $id, $project, $year, $level, $category, $user)
{

    if (count($organization) > 0) {
        $EntryphysicianManufactureItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();

        $EntryphysicianManufacturegetDeviceId = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
            ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
            ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
            ->whereIn('item_file_entry.itemMainId', $EntryphysicianManufactureItemfileId)
            ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_main.physician', 'item_file_main.phyEmail', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
            ->where('device.level_name', $level)
            ->where('device.category_name', $id)
            ->orderBy('item_file_main.repcaseID', 'ASC')
            ->orderBy('item_file_main.clientId', 'ASC');
//            ->whereMonth('item_file_entry.updated_at', '=', Current_month)

    } else {
        $EntryphysicianManufacturegetDeviceId = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
            ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
            ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
            ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_main.physician', 'item_file_main.phyEmail', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
            ->where('device.level_name', $level)
            ->where('device.category_name', $id)
            ->orderBy('item_file_main.repcaseID', 'ASC')
            ->orderBy('item_file_main.clientId', 'ASC');
//            ->whereMonth('item_file_entry.updated_at', '=', Current_month)

    }

    if (!empty($projects)) {
        $EntryphysicianManufacturegetDeviceId = $EntryphysicianManufacturegetDeviceId->where('device.project_name', $project);
    }

    $EntryphysicianManufacturegetDeviceId = $EntryphysicianManufacturegetDeviceId->whereYear('item_file_main.produceDate', '=', $year)
        ->get();

    $EntryphysicianmanufacaturerepcaseId = '';
    $Entryphysicianmanufacatureisimplanted = '';
    foreach ($EntryphysicianManufacturegetDeviceId as $row) {

        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

        $row->discount = SerialnumberDetail::where('deviceId', $row->id)->where('status', '')->where('purchaseType', 'Bulk')->where('clientId', $row->clientId)->max('discount');

//        if ($row->repcaseID == $EntryphysicianmanufacaturerepcaseId && $Entryphysicianmanufacatureisimplanted == 'yes' && $row->isImplanted == 'yes') {
        //            $row->unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->value('system_cost');
        //            if ($row->discount != '') {
        //                $row->price = $row->unitprice - (($row->unitprice * $row->discount) / 100);
        //            } else {
        //                $row->price = $row->unitprice;
        //            }
        //        } else {
        $row->unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->value('unit_cost');
        if ($row->discount != '') {
            $row->price = $row->unitprice - (($row->unitprice * $row->discount) / 100);
        } else {
            $row->price = $row->unitprice;
        }
//        }

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

        $EntryphysicianmanufacaturerepcaseId = $row->repcaseID;
        $Entryphysicianmanufacatureisimplanted = $row->isImplanted;
    }

    $EntryPhysicianManufacature = array();
    foreach ($EntryphysicianManufacturegetDeviceId as $item => $value) {
        $EntryPhysicianManufacature[$value->manufacturer_name][$value->phyEmail][] = $value;
    }

    $EntryPhysicianManufacaturetotalprice = '';
    $EntryPhysicianManufacaturemaxvalue = '';
    $EntryPhysicianManufacatureminvalue = '';
    $EntryPhysicianManufacaturetotaldevice = '';
    $categoryEntryPhysicianManufacatureApp = '';

    $EntryPhysicianManufacatureAppvalue = array();
    $phymanufactures = array();
    $phymanufacture = array();

    foreach ($EntryPhysicianManufacature as $item => $data) {

        foreach ($data as $row => $value) {

            $EntryPhysicianManufacaturetotalprice = array_sum(array_column($value, 'price'));
            $EntryPhysicianManufacaturemaxvalue = max(array_column($value, 'price'));
            $EntryPhysicianManufacatureminvalue = min(array_column($value, 'price'));
            $EntryPhysicianManufacaturetotaldevice = count($value);

            if ($EntryPhysicianManufacaturetotalprice != 0 || $EntryPhysicianManufacaturetotaldevice != 0) {
                $EntryPhysicianManufacatureavgvalue = round($EntryPhysicianManufacaturetotalprice / $EntryPhysicianManufacaturetotaldevice, 0);
            } else {
                $EntryPhysicianManufacatureavgvalue = 0;
            }

            $manufacture_name = manufacturers::where('id', $item)->value('short_name');

            if ($row == $user['email']) {
                $EntryPhysicianManufacatureAppvalue[$row][$item] = array(
                    'totalprice' => $EntryPhysicianManufacaturetotalprice,
                    'maxvalue' => $category['maxvalue'],
                    'minvalue' => $category['minvalue'],
                    'totaldevice' => $EntryPhysicianManufacaturetotaldevice,
                    'avg_app_value' => $EntryPhysicianManufacatureavgvalue,
                    'physician_name' => $user['name'],
                    'manufacturer_name' => $manufacture_name,
                );
            }

        }
    }

    $categoryEntryPhysicianManufacatureApp = $EntryPhysicianManufacatureAppvalue;

    foreach ($EntryPhysicianManufacatureAppvalue as $mahuphy => $mnphy) {

        $newphy = array_map("unserialize", array_unique(array_map("serialize", $mnphy)));
        $names = array();
        foreach ($newphy as $user) {
            $names[] = $user['avg_app_value'];
        }

        array_multisort($names, SORT_ASC, $newphy);

        $EntryPhysicianManufacatureAppvalue[$mahuphy] = $newphy;

    }

    $data = array();
    foreach ($EntryPhysicianManufacatureAppvalue as $item => $row) {
        $data[] = array(
            'name' => $item,
            'data' => $row,
        );
    }
    return $data;
}

function system_physician_user($organization, $id, $category, $level, $year, $project, $user)
{

    if (count($organization) > 0) {
        $PhysicianSystemItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();

        $PhysicianDevice = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
            ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
            ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
            ->whereIn('item_file_entry.itemMainId', $PhysicianSystemItemfileId)
            ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_main.physician', 'item_file_main.phyEmail', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
            ->where('item_file_entry.swapType', '!=', 'Swap Out')
            ->where('device.category_name', $id)
            ->where('item_file_entry.isImplanted', '!=', 'no')
            ->orderBy('item_file_main.repcaseID', 'ASC')
            ->orderBy('item_file_main.clientId', 'ASC');

    } else {
        $PhysicianDevice = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
            ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
            ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
            ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_main.physician', 'item_file_main.phyEmail', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
            ->where('item_file_entry.swapType', '!=', 'Swap Out')
            ->where('device.category_name', $id)
            ->where('item_file_entry.isImplanted', '!=', 'no')
            ->orderBy('item_file_main.repcaseID', 'ASC')
            ->orderBy('item_file_main.clientId', 'ASC');
    }

    if (!empty($project)) {

        $PhysicianDevice = $PhysicianDevice->where('device.project_name', $project);
    }

    $PhysicianDevice = $PhysicianDevice->whereYear('item_file_main.produceDate', '=', $year)
        ->get();

    $PhysicianSystemrepcaseId = '';
    $PhysicianSystemisimplanted = '';
    foreach ($PhysicianDevice as $row) {

        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

        $row->discount = SerialnumberDetail::where('deviceId', $row->id)->where('status', '')->where('purchaseType', 'Bulk')->where('clientId', $row->clientId)->max('discount');

        $row->unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->value('system_cost');
        if ($row->discount != '') {
            $row->price = $row->unitprice - (($row->unitprice * $row->discount) / 100);
        } else {
            $row->price = $row->unitprice;
        }

//        if ($row->cco_check == 'True') {
        //            if ($unitprice['cco_discount_check'] == 'True') {
        //                $row->price = $row->price - ($row->price * $unitprice['cco_discount']) / 100;
        //            } else if ($unitprice['cco_check'] == 'True') {
        //                $row->price = $row->price - $unitprice['cco'];
        //            }
        //        }

        if ($row->repless_check == 'True') {
            if ($unitprice['system_repless_discount_check'] == 'True') {
                $row->price = $row->price - ($row->price * $unitprice['system_repless_discount']) / 100;
            } else if ($unitprice['system_repless_cost_check'] == 'True') {
                $row->price = $row->price - $unitprice['system_repless_cost'];
            }
        }

        $PhysicianSystemrepcaseId = $row->repcaseID;
        $PhysicianSystemisimplanted = $row->isImplanted;
    }

    $PhysicianSystemcategory = array();
    foreach ($PhysicianDevice as $item) {
        $PhysicianSystemcategory[$item->phyEmail][] = $item;
    }
    $PhysicianSystemtotalprice = '';
    $PhysicianSystemmaxvalue = '';
    $PhysicianSystemminvalue = '';
    $PhysicianSystemtotaldevice = '';
    $PhysicianSystemavgvalue = '';

    $PhysicianSystemAppvalue = array();
    $PhysicianSystemAppvalues1 = array();

    foreach ($PhysicianSystemcategory as $item => $value) {
        $PhysicianSystemtotalprice = array_sum(array_column($value, 'price'));

        if (!empty(array_column($value, 'price'))) {

            $PhysicianSystemmaxvalue = max(array_column($value, 'price'));
            $PhysicianSystemminvalue = min(array_column($value, 'price'));
            $PhysicianSystemtotaldevice = count($value);
        }

        if ($PhysicianSystemtotalprice != 0 || $PhysicianSystemtotaldevice != 0) {
            $PhysicianSystemavgvalue = round($PhysicianSystemtotalprice / $PhysicianSystemtotaldevice, 0);
        } else {
            $PhysicianSystemavgvalue = 0;
        }

        if ($item == $user['email']) {
            $PhysicianSystemAppvalue[$item] = array(
                'totalprice' => $PhysicianSystemtotalprice,
                'maxvalue' => $category['maxvalue'],
                'minvalue' => $category['minvalue'],
                'totaldevice' => $PhysicianSystemtotaldevice,
                'category_app_avg_value' => $category['category_app_avg_value'],
                'avg_app_value' => $PhysicianSystemavgvalue,
                'name' => $user['name'],

            );
        }

//        $PhysicianSystemAppvalues1[$item][] = array(
        //            'totalprice' => $PhysicianSystemtotalprice,
        //            'maxvalue' => $PhysicianSystemmaxvalue,
        //            'minvalue' => $PhysicianSystemminvalue,
        //            'totaldevice' => $PhysicianSystemtotaldevice,
        //            'avgvalue' => $PhysicianSystemavgvalue,
        //            'physician_name' => $item,
        //        );

    }

    $PhysicianSystemAppEntryApp = $PhysicianSystemAppvalue;

    $avgapp = array();

    foreach ($PhysicianSystemAppEntryApp as $entry) {
        $avgapp[] = $entry;
    }

    return $avgapp;

//    $PhysicianSystemAppEntryApp = array('PhysicianSystemAppvalue' => $PhysicianSystemAppvalue, 'PhysicianSystemAppvalues' => $PhysicianSystemAppvalue);

}
