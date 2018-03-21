<?php
/**
 * Created by PhpStorm.
 * User: Punit
 * Date: 1/12/2018
 * Time: 11:02 AM
 */

use App\client_price;
use App\ItemFileEntry;
use App\ItemFileMain;
use App\manufacturers;
use App\SerialnumberDetail;
use App\User;

/**
 *Unit App Calculation Start
 */
/**
 * Category Unit Entry APP Calculation Start
 */
function categoryunitentry($organization, $id, $projects, $year)
{

    $getDeviceId = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
        ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
        ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
        ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
        ->where('device.level_name', 'Entry Level')
        ->where('item_file_entry.swapType', '!=', 'Swap Out')
        ->where('item_file_entry.isImplanted', '!=', 'Not Implanted')
        ->orderBy('item_file_main.repcaseID', 'ASC')
        ->orderBy('item_file_main.clientId', 'ASC');


    if (count($organization) > 0) {
        $getItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();
        $getDeviceId = $getDeviceId->whereIn('item_file_entry.itemMainId', $getItemfileId);
    }

    if (!empty($projects)) {
        $getDeviceId = $getDeviceId->where('device.project_name', $projects);
    }

    $getDeviceId = $getDeviceId->whereYear('item_file_main.produceDate', '=', $year)
        ->get();

    $repcaseId = '';
    $isimplanted = '';
    foreach ($getDeviceId as $row) {

        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

        $row->discount = SerialnumberDetail::where('deviceId', $row->id)
            ->where('status', '')
            ->where('purchaseType', 'Bulk')
            ->where('clientId', $row->clientId)
            ->max('discount');

//        $row->discount = $maxserial;

//
        $row->unitprice = $unitprice['unit_cost'];

        $row->price = $row->discount != '' ? $row->unitprice - (($row->unitprice * $row->discount) / 100) : $row->unitprice;
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

//		 $totalprice = array_sum(array_column($value, 'price'));
        $totalprice = array_sum(array_map(function ($var) {
            return $var['price'];
        }, $value));

//		 $maxvalue = max(array_map($value, 'price'));
        $maxvalue = max(array_map(function ($var) {
            return $var['price'];
        }, $value));

//		 $minvalue = min(array_map($value, 'price'));

        $minvalue = min(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $totaldevice = count($value);

        if ($totalprice != 0 && $totaldevice != 0) {
            $avgvalue = round($totalprice / $totaldevice, 0);
        } else {
            $avgvalue = 0;
        }

//        $totalprice = array_sum(array_column($value, 'price'));
        //        $maxvalue = max(array_column($value, 'price'));
        //        $minvalue = min(array_column($value, 'price'));

        if ($id == $item) {

            $devices = device_price($organization, $projects, 'Entry Level', $id, 'Unit');

            $categoryAppvalue = array(
                'totalprice' => $totalprice,
                'maxvalue' => $devices['maxvalue'],
                'minvalue' => $devices['minvalue'],
                'totaldevice' => $totaldevice,
                'avgvalue' => $avgvalue,
            );
        }

    }

    $categoryAppEntryApp = $categoryAppvalue;

    return $categoryAppEntryApp;

}

/**
 * Category Unit Entry APP Calculation End
 */

/**
 * Category Unit Advanced APP Calculation Start
 */
function categoryunitadvanced($organization, $id, $projects, $year)
{


    $AdvancedgetDeviceId = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
        ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
        ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
        ->select('device.*', 'item_file_entry.repcaseID', 'item_file_main.produceDate', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
        ->where('device.level_name', 'Advanced Level')
        ->where('item_file_entry.swapType', '!=', 'Swap Out')
        ->where('item_file_entry.isImplanted', '!=', 'Not Implanted')
        ->orderBy('item_file_main.repcaseID', 'ASC')
        ->orderBy('item_file_main.clientId', 'ASC');


    if (count($organization) > 0) {
        $AdvancedgetItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();
        $AdvancedgetDeviceId = $AdvancedgetDeviceId->whereIn('item_file_entry.itemMainId', $AdvancedgetItemfileId);
    }

    if (!empty($projects)) {
        $AdvancedgetDeviceId = $AdvancedgetDeviceId->where('device.project_name', $projects);
    }

    $AdvancedgetDeviceId = $AdvancedgetDeviceId->whereYear('item_file_main.produceDate', '=', $year)
        ->get();

    $AdvancedrepcaseId = '';
    $Advancedisimplanted = '';
    foreach ($AdvancedgetDeviceId as $row) {

        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

        $row->discount = SerialnumberDetail::where('deviceId', $row->id)
            ->where('status', ''
            )->where('purchaseType', 'Bulk')
            ->where('clientId', $row->clientId)
            ->max('discount');

        $row->unitprice = $unitprice['unit_cost'];

        $row->price = $row->discount != '' ? $row->unitprice - (($row->unitprice * $row->discount) / 100) : $row->unitprice;


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

        $AdvancedrepcaseId = $row->repcaseID;
        $Advancedisimplanted = $row->isImplanted;
    }

    $Advancedcategory = array();
    foreach ($AdvancedgetDeviceId as $item) {
        $Advancedcategory[$item->category_name][] = $item;
    }
    $Advancedtotalprice = '';
    $Advancedmaxvalue = '';
    $Advancedminvalue = '';
    $Advancedtotaldevice = '';
    $Advancedavgvalue = '';

    $AdvancedcategoryAppvalue = array();
    foreach ($Advancedcategory as $item => $value) {

        $Advancedtotalprice = array_sum(array_map(function ($var) {
            return $var['price'];
        }, $value));

        // $maxvalue = max(array_map($value, 'price'));
        $Advancedmaxvalue = max(array_map(function ($var) {
            return $var['price'];
        }, $value));

        // $minvalue = min(array_map($value, 'price'));

        $Advancedminvalue = min(array_map(function ($var) {
            return $var['price'];
        }, $value));

        // $Advancedtotalprice = array_sum(array_column($value, 'price'));
        // $Advancedmaxvalue = max(array_column($value, 'price'));
        // $Advancedminvalue = min(array_column($value, 'price'));
        $Advancedtotaldevice = count($value);
        if ($Advancedtotalprice != 0 && $Advancedtotaldevice != 0) {
            $Advancedavgvalue = round($Advancedtotalprice / $Advancedtotaldevice, 0);
        } else {
            $Advancedavgvalue = 0;
        }

        if ($id == $item) {

            $devices = device_price($organization, $projects, 'Entry Level', $id, 'Unit');

            $AdvancedcategoryAppvalue = array(
                'totalprice' => $Advancedtotalprice,
                'maxvalue' => $devices['maxvalue'],
                'minvalue' => $devices['minvalue'],
                'totaldevice' => $Advancedtotaldevice,
                'avgvalue' => $Advancedavgvalue,
            );
        }

    }

    $categoryAppAdvancedApp = $AdvancedcategoryAppvalue;

    return $categoryAppAdvancedApp;
}

/**
 * Category Unit Advanced APP Calculation End
 */

/**
 * Category Unit Entry Manufacturer APP Calculation Start
 */
function categoryunitentrymanufacture($organization, $id, $category, $projects, $year)
{


    $EntrymanufacaturegetDeviceId = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
        ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
        ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
        ->where('device.category_name', $id)
        ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'item_file_main.produceDate', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
        ->where('device.level_name', 'Entry Level')
        ->where('item_file_entry.swapType', '!=', 'Swap Out')
        ->where('item_file_entry.isImplanted', '!=', 'Not Implanted')
        ->orderBy('item_file_main.repcaseID', 'ASC')
        ->orderBy('item_file_main.clientId', 'ASC');

    if (count($organization) > 0) {
        $EntrymanufacatureItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();
        $EntrymanufacaturegetDeviceId = $EntrymanufacaturegetDeviceId->whereIn('item_file_entry.itemMainId', $EntrymanufacatureItemfileId);
    }
    if (!empty($projects)) {
        $EntrymanufacaturegetDeviceId = $EntrymanufacaturegetDeviceId->where('device.project_name', $projects);
    }

    $EntrymanufacaturegetDeviceId = $EntrymanufacaturegetDeviceId->whereYear('item_file_main.produceDate', '=', $year)
        ->get();

    $EntrymanufacaturerepcaseId = '';
    $Entrymanufacatureisimplanted = '';
    foreach ($EntrymanufacaturegetDeviceId as $row) {

        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

        $row->discount = SerialnumberDetail::where('deviceId', $row->id)->where('status', '')->where('purchaseType', 'Bulk')->where('clientId', $row->clientId)->max('discount');


        $row->unitprice = $unitprice['unit_cost'];

        $row->price = $row->discount != '' ? $row->unitprice - (($row->unitprice * $row->discount) / 100) : $row->unitprice;

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

//        $Entrymanufacaturetotalprice = array_sum(array_column($value, 'price'));
        //        $Entrymanufacaturemaxvalue = max(array_column($value, 'price'));
        //        $Entrymanufacatureminvalue = min(array_column($value, 'price'));

        $Entrymanufacaturetotalprice = array_sum(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $Entrymanufacaturemaxvalue = max(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $Entrymanufacatureminvalue = min(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $Entrymanufacaturetotaldevice = count($value);

        if ($Entrymanufacaturetotalprice != 0 && $Entrymanufacaturetotaldevice != 0) {
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
            'appavgvalue' => $category['avgvalue'],
            'avgvalue' => $Entrymanufacatureavgvalue,
            'manufacturer_name' => $manufacture_name,
        );

        $avgApp[] = array(
            'avgvalue' => $Entrymanufacatureavgvalue,
            'manufacturer_name' => $manufacture_name,
        );

    }

    $categoryEntrymanufacatureApp = $EntrymanufacatureAppvalue;

    if (!empty($category)) {
        $avgApp[] = array(
            'avgvalue' => $category['avgvalue'],
            'manufacturer_name' => 'Average',
        );
    }
    $names = array();
    foreach ($avgApp as $user) {
        $names[] = $user['avgvalue'];
    }

    array_multisort($names, SORT_ASC, $avgApp);
//        $data = array_multisort($avgApp);

    return $avgApp;
}

/**
 * Category Unit Entry Manufacturer APP Calculation End
 */

/**
 * Category Unit Advanced Manufacturer APP Calculation Start
 */
function categoryunitadvancedmanufacture($organization, $id, $category, $projects, $year)
{
    $AdvancedmanufacaturegetDeviceId = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
        ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
        ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
        ->where('device.category_name', $id)
        ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'item_file_main.produceDate', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
        ->where('device.level_name', 'Advanced Level')
        ->where('item_file_entry.swapType', '!=', 'Swap Out')
        ->where('item_file_entry.isImplanted', '!=', 'Not Implanted')
        ->orderBy('item_file_main.repcaseID', 'ASC')
        ->orderBy('item_file_main.clientId', 'ASC');

    if (count($organization) > 0) {
        $AdvancedmanufacatureItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();
        $AdvancedmanufacaturegetDeviceId = $AdvancedmanufacaturegetDeviceId->whereIn('item_file_entry.itemMainId', $AdvancedmanufacatureItemfileId);

    }

    if (!empty($projects)) {
        $AdvancedmanufacaturegetDeviceId = $AdvancedmanufacaturegetDeviceId->where('device.project_name', $projects);
    }

    $AdvancedmanufacaturegetDeviceId = $AdvancedmanufacaturegetDeviceId->whereYear('item_file_main.produceDate', '=', $year)
        ->get();

    $AdvancedmanufacaturerepcaseId = '';
    $Advancedmanufacatureisimplanted = '';
    foreach ($AdvancedmanufacaturegetDeviceId as $row) {
        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

//        $maxserial = SerialnumberDetail::where('deviceId', $row->id)
//            ->where('clientId', $row->clientId)
//            ->where('status', '')
//            ->where('purchaseType', 'Bulk')
//            ->orderBy('discount', 'DESC')
//            ->value('discount');

        $row->discount = SerialnumberDetail::where('deviceId', $row->id)->where('status', '')->where('purchaseType', 'Bulk')->where('clientId', $row->clientId)->max('discount');

//        $row->discount = $maxserial;

        $row->unitprice = $unitprice['unit_cost'];

        $row->price = $row->discount != '' ? $row->unitprice - (($row->unitprice * $row->discount) / 100) : $row->unitprice;


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

        $AdvancedmanufacaturerepcaseId = $row->repcaseID;
        $Advancedmanufacatureisimplanted = $row->isImplanted;
    }

    $Advancedmanufacature = array();

    foreach ($AdvancedmanufacaturegetDeviceId as $item) {
        $Advancedmanufacature[$item->manufacturer_name][] = $item;
    }
    $Advancedmanufacaturetotalprice = '';
    $Advancedmanufacaturemaxvalue = '';
    $Advancedmanufacatureminvalue = '';
    $Advancedmanufacaturetotaldevice = '';
    $categoryAdvancedmanufacatureApp = '';

    $AdvancedmanufacatureAppvalue = array();
    $avgApp = array();
    foreach ($Advancedmanufacature as $item => $value) {

//        $Advancedmanufacaturetotalprice = array_sum(array_column($value, 'price'));
        //        $Advancedmanufacaturemaxvalue = max(array_column($value, 'price'));
        //        $Advancedmanufacatureminvalue = min(array_column($value, 'price'));
        $Advancedmanufacaturetotalprice = array_sum(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $Advancedmanufacaturemaxvalue = max(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $Advancedmanufacatureminvalue = min(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $Advancedmanufacaturetotaldevice = count($value);

        if ($Advancedmanufacaturetotalprice != 0 && $Advancedmanufacaturetotaldevice != 0) {
            $Advancedmanufacatureavgvalue = round($Advancedmanufacaturetotalprice / $Advancedmanufacaturetotaldevice, 0);
        } else {
            $Advancedmanufacatureavgvalue = 0;
        }

        $manufacture_name = manufacturers::where('id', $item)->value('short_name');

        $AdvancedmanufacatureAppvalue[$item] = array(
            'totalprice' => $Advancedmanufacaturetotalprice,
            'maxvalue' => $category['maxvalue'],
            'minvalue' => $category['minvalue'],
            'totaldevice' => $Advancedmanufacaturetotaldevice,
            'appavgvalue' => $category['avgvalue'],
            'avgvalue' => $Advancedmanufacatureavgvalue,
            'manufacturer_name' => $manufacture_name,
        );

        $avgApp[] = array(
            'avgvalue' => $Advancedmanufacatureavgvalue,
            'manufacturer_name' => $manufacture_name,
        );

    }

    $categoryAdvancedmanufacatureApp = $AdvancedmanufacatureAppvalue;

    if (!empty($category)) {
        $avgApp[] = array(
            'avgvalue' => $category['avgvalue'],
            'manufacturer_name' => 'Average App',
        );
    }
    $names = array();
    foreach ($avgApp as $user) {
        $names[] = $user['avgvalue'];
    }

    array_multisort($names, SORT_ASC, $avgApp);

    return $avgApp;

}

/**
 * Category Unit Advanced Manufacturer APP Calculation End
 */

/**
 * Category Unit Entry Physician APP Calculation Start
 */
function categoryunitentryphysician($organization, $id, $category, $projects, $year)
{

    $EntryphysiciangetDeviceId = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
        ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
        ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
        ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'item_file_main.produceDate', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_main.physician', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
        ->where('device.level_name', 'Entry Level')
        ->where('device.category_name', $id)
        ->where('item_file_entry.swapType', '!=', 'Swap Out')
        ->where('item_file_entry.isImplanted', '!=', 'Not Implanted')
        ->orderBy('item_file_main.repcaseID', 'ASC')
        ->orderBy('item_file_main.clientId', 'ASC');


    if (count($organization) > 0) {
        $EntryphysicianItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();
        $EntryphysiciangetDeviceId = $EntryphysiciangetDeviceId->whereIn('item_file_entry.itemMainId', $EntryphysicianItemfileId);
    }

    if (!empty($projects)) {
        $EntryphysiciangetDeviceId = $EntryphysiciangetDeviceId->where('device.project_name', $projects);
    }

    $EntryphysiciangetDeviceId = $EntryphysiciangetDeviceId->whereYear('item_file_main.produceDate', '=', $year)
        ->get();

    $EntryphysicianrepcaseId = '';
    $Entryphysicianisimplanted = '';
    foreach ($EntryphysiciangetDeviceId as $row) {

        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

        $row->discount = SerialnumberDetail::where('deviceId', $row->id)->where('status', '')->where('purchaseType', 'Bulk')->where('clientId', $row->clientId)->max('discount');

        $row->unitprice = $unitprice['unit_cost'];

        $row->price = $row->discount != '' ? $row->unitprice - (($row->unitprice * $row->discount) / 100) : $row->unitprice;


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
//        $Entryphysiciantotalprice = array_sum(array_column($value, 'price'));
        //        $Entryphysicianmaxvalue = max(array_column($value, 'price'));
        //        $Entryphysicianminvalue = min(array_column($value, 'price'));

        $Entryphysiciantotalprice = array_sum(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $Entryphysicianmaxvalue = max(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $Entryphysicianminvalue = min(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $Entryphysiciantotaldevice = count($value);

        if ($Entryphysiciantotalprice != 0 && $Entryphysiciantotaldevice != 0) {
            $Entryphysicianavgvalue = round($Entryphysiciantotalprice / $Entryphysiciantotaldevice, 0);
        } else {
            $Entryphysicianavgvalue = 0;
        }

        $EntryphysicianAppvalue[$item] = array(
            'totalprice' => $Entryphysiciantotalprice,
            'maxvalue' => $category['maxvalue'],
            'minvalue' => $category['minvalue'],
            'totaldevice' => $Entryphysiciantotaldevice,
            'appavgvalue' => $category['avgvalue'],
            'avgvalue' => $Entryphysicianavgvalue,
            'physician_name' => $item,
        );

    }

    $categoryEntryphysicianApp = $EntryphysicianAppvalue;

    return $categoryEntryphysicianApp;
}

/**
 * Category Unit Entry Physician APP Calculation End
 */

/**
 * Category Unit Advanced Physician APP Calculation Start
 */
function categoryunitadvancedphysician($organization, $id, $category, $projects, $year)
{

    $AdvancedphysiciangetDeviceId = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
        ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
        ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
        ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'item_file_main.produceDate', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_main.physician', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
        ->where('device.level_name', 'Advanced Level')
        ->where('device.category_name', $id)
        ->where('item_file_entry.swapType', '!=', 'Swap Out')
        ->where('item_file_entry.isImplanted', '!=', 'Not Implanted')
        ->orderBy('item_file_main.repcaseID', 'ASC')
        ->orderBy('item_file_main.clientId', 'ASC');


    if (count($organization) > 0) {
        $AdvancedphysicianItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();
        $AdvancedphysiciangetDeviceId = $AdvancedphysiciangetDeviceId->whereIn('item_file_entry.itemMainId', $AdvancedphysicianItemfileId);
    }

    if (!empty($projects)) {
        $AdvancedphysiciangetDeviceId = $AdvancedphysiciangetDeviceId->where('device.project_name', $projects);
    }

    $AdvancedphysiciangetDeviceId = $AdvancedphysiciangetDeviceId->whereYear('item_file_main.produceDate', '=', $year)
        ->get();

    $AdvancedphysicianrepcaseId = '';
    $Advancedphysicianisimplanted = '';
    foreach ($AdvancedphysiciangetDeviceId as $row) {

        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

        $row->discount = SerialnumberDetail::where('deviceId', $row->id)->where('status', '')->where('purchaseType', 'Bulk')->where('clientId', $row->clientId)->max('discount');

        $row->unitprice = $unitprice['unit_cost'];

        $row->price = $row->discount != '' ? $row->unitprice - (($row->unitprice * $row->discount) / 100) : $row->unitprice;

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

        $AdvancedphysicianrepcaseId = $row->repcaseID;
        $Advancedphysicianisimplanted = $row->isImplanted;
    }

    $Advancedphysician = array();
    foreach ($AdvancedphysiciangetDeviceId as $item) {
        $Advancedphysician[$item->physician][] = $item;
    }
    $Advancedphysiciantotalprice = '';
    $Advancedphysicianmaxvalue = '';
    $Advancedphysicianminvalue = '';
    $Advancedphysiciantotaldevice = '';
    $categoryAdvancedphysicianApp = '';

    $AdvancedphysicianAppvalue = array();
    foreach ($Advancedphysician as $item => $value) {
//        $Advancedphysiciantotalprice = array_sum(array_column($value, 'price'));
        //        $Advancedphysicianmaxvalue = max(array_column($value, 'price'));
        //        $Advancedphysicianminvalue = min(array_column($value, 'price'));

        $Advancedphysiciantotalprice = array_sum(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $Advancedphysicianmaxvalue = max(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $Advancedphysicianminvalue = min(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $Advancedphysiciantotaldevice = count($value);

        if ($Advancedphysiciantotalprice != 0 && $Advancedphysiciantotaldevice != 0) {
            $Advancedphysicianavgvalue = round($Advancedphysiciantotalprice / $Advancedphysiciantotaldevice, 0);
        } else {
            $Advancedphysicianavgvalue = 0;
        }

        $AdvancedphysicianAppvalue[$item] = array(
            'totalprice' => $Advancedphysiciantotalprice,
            'maxvalue' => $category['maxvalue'],
            'minvalue' => $category['minvalue'],
            'totaldevice' => $Advancedphysiciantotaldevice,
            'avgvalue' => $Advancedphysicianavgvalue,
            'physician_name' => $item,
        );

    }

    $categoryAdvancedphysicianApp = $AdvancedphysicianAppvalue;

    return $categoryAdvancedphysicianApp;
}

/**
 * Category Unit Advanced Physician APP Calculation End
 */

/**
 * Category Unit Entry Physician Manufacture App Calculation Start
 */
function categoryunitenrtyphysicianmanufacture($organization, $id, $physician, $projects, $year)
{

    $EntryphysicianManufacturegetDeviceId = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
        ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
        ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
        ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'item_file_main.produceDate', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_main.physician', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
        ->where('device.level_name', 'Entry Level')
        ->where('device.category_name', $id)
        ->where('item_file_entry.swapType', '!=', 'Swap Out')
        ->where('item_file_entry.isImplanted', '!=', 'Not Implanted')
        ->orderBy('item_file_main.repcaseID', 'ASC')
        ->orderBy('item_file_main.clientId', 'ASC');


    if (count($organization) > 0) {
        $EntryphysicianManufactureItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();
        $EntryphysicianManufacturegetDeviceId = $EntryphysicianManufacturegetDeviceId->whereIn('item_file_entry.itemMainId', $EntryphysicianManufactureItemfileId);

    }

    if (!empty($projects)) {
        $EntryphysicianManufacturegetDeviceId = $EntryphysicianManufacturegetDeviceId->where('device.project_name', $projects);
    }

    $EntryphysicianManufacturegetDeviceId = $EntryphysicianManufacturegetDeviceId->whereYear('item_file_main.produceDate', '=', $year)
        ->get();

    $EntryphysicianmanufacaturerepcaseId = '';
    $Entryphysicianmanufacatureisimplanted = '';
    foreach ($EntryphysicianManufacturegetDeviceId as $row) {

        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();


        $row->discount = SerialnumberDetail::where('deviceId', $row->id)->where('status', '')->where('purchaseType', 'Bulk')->where('clientId', $row->clientId)->max('discount');
        $row->unitprice = $unitprice['unit_cost'];

        $row->price = $row->discount != '' ? $row->unitprice - (($row->unitprice * $row->discount) / 100) : $row->unitprice;


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

//            $EntryPhysicianManufacaturetotalprice = array_sum(array_column($value, 'price'));
            //            $EntryPhysicianManufacaturemaxvalue = max(array_column($value, 'price'));
            //            $EntryPhysicianManufacatureminvalue = min(array_column($value, 'price'));

            $EntryPhysicianManufacaturetotalprice = array_sum(array_map(function ($var) {
                return $var['price'];
            }, $value));

            $EntryPhysicianManufacaturemaxvalue = max(array_map(function ($var) {
                return $var['price'];
            }, $value));

            $EntryPhysicianManufacatureminvalue = min(array_map(function ($var) {
                return $var['price'];
            }, $value));

            $EntryPhysicianManufacaturetotaldevice = count($value);

            if ($EntryPhysicianManufacaturetotalprice != 0 && $EntryPhysicianManufacaturetotaldevice != 0) {
                $EntryPhysicianManufacatureavgvalue = round($EntryPhysicianManufacaturetotalprice / $EntryPhysicianManufacaturetotaldevice, 0);
            } else {
                $EntryPhysicianManufacatureavgvalue = 0;
            }

            $manufacture_name = manufacturers::where('id', $item)->value('short_name');

            $EntryPhysicianManufacatureAppvalue[$row][$item] = array(
                'totalprice' => $EntryPhysicianManufacaturetotalprice,
                'maxvalue' => $EntryPhysicianManufacaturemaxvalue,
                'minvalue' => $EntryPhysicianManufacatureminvalue,
                'totaldevice' => $EntryPhysicianManufacaturetotaldevice,
                'avgvalue' => $EntryPhysicianManufacatureavgvalue,
                'physician_name' => $row,
                'manufacturer_name' => $manufacture_name,
            );

            foreach ($physician as $phy => $value) {
                if ($phy == $row) {
                    $phymanufactures[$row][] = array(
                        'avgvalue' => $value['avgvalue'],
                        'physician_name' => 'Avg Value',
                        'manufacturer_name' => '',
                    );

                }

            }
            $phymanufactures[$row][] = array(
                'avgvalue' => $EntryPhysicianManufacatureavgvalue,
                'physician_name' => $row,
                'manufacturer_name' => $manufacture_name,
            );

        }
    }

    $categoryEntryPhysicianManufacatureApp = $EntryPhysicianManufacatureAppvalue;

    foreach ($phymanufactures as $mahuphy => $mnphy) {

        $newphy = array_map("unserialize", array_unique(array_map("serialize", $mnphy)));
        $names = array();
        foreach ($newphy as $user) {
            $names[] = $user['avgvalue'];
        }

        array_multisort($names, SORT_ASC, $newphy);

        $phymanufacture[$mahuphy] = $newphy;

    }

    return $phymanufacture;

}

/**
 * Category Unit Entry Physician Manufacture App Calculation End
 */

/**
 * Category Unit Advanced Physician Manufacture App Calculation Start
 */
function cateogryunitadvancedphysicianmanufacture($organization, $id, $physician, $projects, $year)
{

    $AdvancedphysicianManufacturegetDeviceId = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
        ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
        ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
        ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'item_file_main.produceDate', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_main.physician', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
        ->where('device.level_name', 'Advanced Level')
        ->where('device.category_name', $id)
        ->where('item_file_entry.swapType', '!=', 'Swap Out')
        ->where('item_file_entry.isImplanted', '!=', 'Not Implanted')
        ->orderBy('item_file_main.repcaseID', 'ASC')
        ->orderBy('item_file_main.clientId', 'ASC');


    if (count($organization) > 0) {
        $AdvancedphysicianManufactureItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();
        $AdvancedphysicianManufacturegetDeviceId = $AdvancedphysicianManufacturegetDeviceId->whereIn('item_file_entry.itemMainId', $AdvancedphysicianManufactureItemfileId);
    }

    if (!empty($projects)) {
        $AdvancedphysicianManufacturegetDeviceId = $AdvancedphysicianManufacturegetDeviceId->where('device.project_name', $projects);
    }

    $AdvancedphysicianManufacturegetDeviceId = $AdvancedphysicianManufacturegetDeviceId->whereYear('item_file_main.produceDate', '=', $year)
        ->get();

    $AdvancedphysicianmanufacaturerepcaseId = '';
    $Advancedphysicianmanufacatureisimplanted = '';
    foreach ($AdvancedphysicianManufacturegetDeviceId as $row) {
        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

        $row->discount = SerialnumberDetail::where('deviceId', $row->id)->where('status', '')->where('purchaseType', 'Bulk')->where('clientId', $row->clientId)->max('discount');

        $row->unitprice = $unitprice['unit_cost'];

        $row->price = $row->discount != '' ? $row->unitprice - (($row->unitprice * $row->discount) / 100) : $row->unitprice;


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

        $AdvancedphysicianmanufacaturerepcaseId = $row->repcaseID;
        $Advancedphysicianmanufacatureisimplanted = $row->isImplanted;
    }

    $AdvancedPhysicianManufacature = array();
    foreach ($AdvancedphysicianManufacturegetDeviceId as $item => $value) {
        $AdvancedPhysicianManufacature[$value->manufacturer_name][$value->physician][] = $value;
    }

    $AdvancedPhysicianManufacaturetotalprice = '';
    $AdvancedPhysicianManufacaturemaxvalue = '';
    $AdvancedPhysicianManufacatureminvalue = '';
    $AdvancedPhysicianManufacaturetotaldevice = '';
    $categoryAdvancedPhysicianManufacatureApp = '';

    $AdvancedPhysicianManufacatureAppvalue = array();
    $phymanufactures = array();
    $phymanufacture = array();
    foreach ($AdvancedPhysicianManufacature as $item => $data) {
        foreach ($data as $row => $value) {
//            $AdvancedPhysicianManufacaturetotalprice = array_sum(array_column($value, 'price'));
            //            $AdvancedPhysicianManufacaturemaxvalue = max(array_column($value, 'price'));
            //            $AdvancedPhysicianManufacatureminvalue = min(array_column($value, 'price'));

            $AdvancedPhysicianManufacaturetotalprice = array_sum(array_map(function ($var) {
                return $var['price'];
            }, $value));

            $AdvancedPhysicianManufacaturemaxvalue = max(array_map(function ($var) {
                return $var['price'];
            }, $value));

            $AdvancedPhysicianManufacatureminvalue = min(array_map(function ($var) {
                return $var['price'];
            }, $value));

            $AdvancedPhysicianManufacaturetotaldevice = count($value);

            if ($AdvancedPhysicianManufacaturetotalprice != 0 && $AdvancedPhysicianManufacaturetotaldevice != 0) {
                $AdvancedPhysicianManufacatureavgvalue = round($AdvancedPhysicianManufacaturetotalprice / $AdvancedPhysicianManufacaturetotaldevice, 0);
            } else {
                $AdvancedPhysicianManufacatureavgvalue = 0;
            }

            $manufacture_name = manufacturers::where('id', $item)->value('short_name');

            $AdvancedPhysicianManufacatureAppvalue[$row][$item] = array(
                'totalprice' => $AdvancedPhysicianManufacaturetotalprice,
                'maxvalue' => $AdvancedPhysicianManufacaturemaxvalue,
                'minvalue' => $AdvancedPhysicianManufacatureminvalue,
                'totaldevice' => $AdvancedPhysicianManufacaturetotaldevice,
                'avgvalue' => $AdvancedPhysicianManufacatureavgvalue,
                'physician_name' => $row,
                'manufacturer_name' => $manufacture_name,
            );

            foreach ($physician as $phy => $value) {
                if ($phy == $row) {
                    $phymanufactures[$row][] = array(
                        'avgvalue' => $value['avgvalue'],
                        'physician_name' => 'Avg Value',
                        'manufacturer_name' => '',
                    );

                }

            }
            $phymanufactures[$row][] = array(
                'avgvalue' => $AdvancedPhysicianManufacatureavgvalue,
                'physician_name' => $row,
                'manufacturer_name' => $manufacture_name,
            );
        }
    }

    $categoryAdvancedPhysicianManufacatureApp = $AdvancedPhysicianManufacatureAppvalue;

    foreach ($phymanufactures as $mahuphy => $mnphy) {

        $newphy = array_map("unserialize", array_unique(array_map("serialize", $mnphy)));
        $names = array();
        foreach ($newphy as $user) {
            $names[] = $user['avgvalue'];
        }

        array_multisort($names, SORT_ASC, $newphy);

        $phymanufacture[$mahuphy] = $newphy;

    }

    return $phymanufacture;

}

/**
 * Category Unit Advanced Physician Manufacture App Calculation End
 */

/**
 *Unit App Calculation End
 */

/**
 * System App Calculation Start
 */
/**
 * Category System App Entry Start
 */
function categorysystementry($organization, $id, $projects, $year)
{

    $entrydevice = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
        ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
        ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
        ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'item_file_main.produceDate', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
        ->where('device.level_name', 'Entry Level')
        ->where('item_file_entry.swapType', '!=', 'Swap Out')
        ->where('item_file_entry.isImplanted', '!=', 'Not Implanted')
        ->orderBy('item_file_main.repcaseID', 'ASC')
        ->orderBy('item_file_main.clientId', 'ASC');

    if (count($organization) > 0) {
        $entrySystemItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();
        $entrydevice = $entrydevice->whereIn('item_file_entry.itemMainId', $entrySystemItemfileId);
    }

    if (!empty($projects)) {
        $entrydevice = $entrydevice->where('device.project_name', $projects);
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

        $row->unitprice = $unitprice['system_cost'];

        $row->price = $row->discount != '' ? $row->unitprice - (($row->unitprice * $row->discount) / 100) : $row->unitprice;

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
//        $EntrySystemtotalprice = array_sum(array_column($value, 'price'));
        //        $EntrySystemmaxvalue = max(array_column($value, 'price'));
        //        $EntrySystemminvalue = min(array_column($value, 'price'));

        $EntrySystemtotalprice = array_sum(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $EntrySystemmaxvalue = max(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $EntrySystemminvalue = min(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $EntrySystemtotaldevice = count($value);

        if ($EntrySystemtotalprice != 0 && $EntrySystemtotaldevice != 0) {
            $EntrySystemavgvalue = round($EntrySystemtotalprice / $EntrySystemtotaldevice, 0);
        } else {
            $EntrySystemavgvalue = 0;
        }

        if ($id == $item) {

            $devices = device_price($organization, $projects, 'Entry Level', $id, 'System');

            $EntrySystemcategoryAppvalue = array(
                'totalprice' => $EntrySystemtotalprice,
                'maxvalue' => $devices['maxvalue'],
                'minvalue' => $devices['minvalue'],
                'totaldevice' => $EntrySystemtotaldevice,
                'avgvalue' => $EntrySystemavgvalue,
            );
        }
    }

    $categorySystemAppEntryApp = $EntrySystemcategoryAppvalue;

    return $categorySystemAppEntryApp;
}

/**
 * Category System App Entry End
 */
/**
 * Category System App Advanced Start
 */
function categorysystemadvanced($organization, $id, $projects, $year)
{

    $Advanceddevice = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
        ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
        ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
        ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'item_file_main.produceDate', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
        ->where('device.level_name', 'Advanced Level')
        ->where('item_file_entry.swapType', '!=', 'Swap Out')
        ->where('item_file_entry.isImplanted', '!=', 'Not Implanted')
        ->orderBy('item_file_main.repcaseID', 'ASC')
        ->orderBy('item_file_main.clientId', 'ASC');

    if (count($organization) > 0) {
        $AdvancedSystemItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();
        $Advanceddevice = $Advanceddevice->whereIn('item_file_entry.itemMainId', $AdvancedSystemItemfileId);
    }

    if (!empty($projects)) {
        $Advanceddevice = $Advanceddevice->where('device.project_name', $projects);
    }

    $Advanceddevice = $Advanceddevice->whereYear('item_file_main.produceDate', '=', $year)
        ->get();

    $AdvancedSystemrepcaseId = '';
    $AdvancedSystemisimplanted = '';
    foreach ($Advanceddevice as $row) {
        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

        $row->discount = SerialnumberDetail::where('deviceId', $row->id)->where('status', '')->where('purchaseType', 'Bulk')->where('clientId', $row->clientId)->max('discount');


        $row->unitprice = $unitprice['system_cost'];

        $row->price = $row->discount != '' ? $row->unitprice - (($row->unitprice * $row->discount) / 100) : $row->unitprice;

        if ($row->repless_check == 'True') {
            if ($unitprice['system_repless_discount_check'] == 'True') {
                $row->price = $row->price - ($row->price * $unitprice['system_repless_discount']) / 100;
            } else if ($unitprice['system_repless_cost_check'] == 'True') {
                $row->price = $row->price - $unitprice['system_repless_cost'];
            }
        }

        $AdvancedSystemrepcaseId = $row->repcaseID;
        $AdvancedSystemisimplanted = $row->isImplanted;
    }

    $AdvancedSystemcategory = array();
    foreach ($Advanceddevice as $item) {
        $AdvancedSystemcategory[$item->category_name][] = $item;
    }
    $AdvancedSystemtotalprice = '';
    $AdvancedSystemmaxvalue = '';
    $AdvancedSystemminvalue = '';
    $AdvancedSystemtotaldevice = '';
    $AdvancedSystemavgvalue = '';

    $AdvancedSystemcategoryAppvalue = array();
    foreach ($AdvancedSystemcategory as $item => $value) {
//        $AdvancedSystemtotalprice = array_sum(array_column($value, 'price'));
        //        $AdvancedSystemmaxvalue = max(array_column($value, 'price'));
        //        $AdvancedSystemminvalue = min(array_column($value, 'price'));

        $AdvancedSystemtotalprice = array_sum(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $AdvancedSystemmaxvalue = max(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $AdvancedSystemminvalue = min(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $AdvancedSystemtotaldevice = count($value);

        if ($AdvancedSystemtotalprice != 0 && $AdvancedSystemtotaldevice != 0) {
            $AdvancedSystemavgvalue = round($AdvancedSystemtotalprice / $AdvancedSystemtotaldevice, 0);
        } else {
            $AdvancedSystemavgvalue = 0;
        }
        if ($id == $item) {

            $devices = device_price($organization, $projects, 'Advanced Level', $id, 'System');

            $AdvancedSystemcategoryAppvalue = array(
                'totalprice' => $AdvancedSystemtotalprice,
                'maxvalue' => $devices['maxvalue'],
                'minvalue' => $devices['minvalue'],
                'totaldevice' => $AdvancedSystemtotaldevice,
                'avgvalue' => $AdvancedSystemavgvalue,
            );
        }
    }

    $categorySystemAppAdvancedApp = $AdvancedSystemcategoryAppvalue;

    return $categorySystemAppAdvancedApp;

}

/**
 * Category System App Advanced End
 */
/**
 * Physician System App Start
 */
function physiciansystem($organization, $id, $category, $projects, $year)
{

    $PhysicianDevice = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
        ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
        ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
        ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'item_file_main.produceDate', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_main.physician', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
        ->where('item_file_entry.swapType', '!=', 'Swap Out')
        ->where('device.category_name', $id)
        ->where('item_file_entry.isImplanted', '!=', 'Not Implanted')
        ->orderBy('item_file_main.repcaseID', 'ASC')
        ->orderBy('item_file_main.clientId', 'ASC');

    if (count($organization) > 0) {
        $PhysicianSystemItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();
        $PhysicianDevice = $PhysicianDevice->whereIn('item_file_entry.itemMainId', $PhysicianSystemItemfileId);
    }

    if (!empty($projects)) {

        $PhysicianDevice = $PhysicianDevice->where('device.project_name', $projects);
    }

    $PhysicianDevice = $PhysicianDevice->whereYear('item_file_main.produceDate', '=', $year)
        ->get();

    $PhysicianSystemrepcaseId = '';
    $PhysicianSystemisimplanted = '';
    foreach ($PhysicianDevice as $row) {

        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

        $row->discount = SerialnumberDetail::where('deviceId', $row->id)->where('status', '')->where('purchaseType', 'Bulk')->where('clientId', $row->clientId)->max('discount');


        $row->unitprice = $unitprice['system_cost'];

        $row->price = $row->discount != '' ? $row->unitprice - (($row->unitprice * $row->discount) / 100) : $row->unitprice;

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
//        $PhysicianSystemtotalprice = array_sum(array_column($value, 'price'));
        //        $PhysicianSystemmaxvalue = max(array_column($value, 'price'));
        //        $PhysicianSystemminvalue = min(array_column($value, 'price'));

        $PhysicianSystemtotalprice = array_sum(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $PhysicianSystemmaxvalue = max(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $PhysicianSystemminvalue = min(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $PhysicianSystemtotaldevice = count($value);

        if ($PhysicianSystemtotalprice != 0 && $PhysicianSystemtotaldevice != 0) {
            $PhysicianSystemavgvalue = round($PhysicianSystemtotalprice / $PhysicianSystemtotaldevice, 0);
        } else {
            $PhysicianSystemavgvalue = 0;
        }

        $PhysicianSystemAppvalue[$item] = array(
            'totalprice' => $PhysicianSystemtotalprice,
            'maxvalue' => $category['maxvalue'],
            'minvalue' => $category['minvalue'],
            'totaldevice' => $PhysicianSystemtotaldevice,
            'avgvalue' => $PhysicianSystemavgvalue,
            'physician_name' => $item,
        );

    }

    return $PhysicianSystemAppvalue;
}

function physicianmanufacturesystem($organization, $id, $category, $projects, $year,$physician)
{

    $PhysicianDevice = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
        ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
        ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
        ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'item_file_main.produceDate', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_main.physician', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
        ->where('item_file_entry.swapType', '!=', 'Swap Out')
        ->where('device.category_name', $id)
        ->where('item_file_entry.isImplanted', '!=', 'Not Implanted')
        ->orderBy('item_file_main.repcaseID', 'ASC')
        ->orderBy('item_file_main.clientId', 'ASC');

    if (count($organization) > 0) {
        $PhysicianSystemItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();
        $PhysicianDevice = $PhysicianDevice->whereIn('item_file_entry.itemMainId', $PhysicianSystemItemfileId);
    }

    if (!empty($projects)) {

        $PhysicianDevice = $PhysicianDevice->where('device.project_name', $projects);
    }

    $PhysicianDevice = $PhysicianDevice->whereYear('item_file_main.produceDate', '=', $year)
        ->get();

    $PhysicianSystemrepcaseId = '';
    $PhysicianSystemisimplanted = '';
    foreach ($PhysicianDevice as $row) {

        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

        $row->discount = SerialnumberDetail::where('deviceId', $row->id)->where('status', '')->where('purchaseType', 'Bulk')->where('clientId', $row->clientId)->max('discount');


        $row->unitprice = $unitprice['system_cost'];

        $row->price = $row->discount != '' ? $row->unitprice - (($row->unitprice * $row->discount) / 100) : $row->unitprice;

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
        $PhysicianSystemcategory[$item->manufacturer_name][$item->physician][] = $item;
    }
    $PhysicianSystemtotalprice = '';
    $PhysicianSystemmaxvalue = '';
    $PhysicianSystemminvalue = '';
    $PhysicianSystemtotaldevice = '';
    $PhysicianSystemavgvalue = '';

    $PhysicianSystemAppvalue = array();
    $PhysicianSystemAppvalues1 = array();
    foreach ($PhysicianSystemcategory as $item => $value) {

        foreach ($value as $keys => $values){

            $PhysicianSystemtotalprice = array_sum(array_map(function ($var) {
                return $var['price'];
            }, $values));

            $PhysicianSystemmaxvalue = max(array_map(function ($var) {
                return $var['price'];
            }, $values));

            $PhysicianSystemminvalue = min(array_map(function ($var) {
                return $var['price'];
            }, $values));

            $PhysicianSystemtotaldevice = count($values);

            if ($PhysicianSystemtotalprice != 0 && $PhysicianSystemtotaldevice != 0) {
                $PhysicianSystemavgvalue = round($PhysicianSystemtotalprice / $PhysicianSystemtotaldevice, 0);
            } else {
                $PhysicianSystemavgvalue = 0;
            }
            $manufacture_name = manufacturers::where('id', $item)->value('short_name');



            $PhysicianSystemAppvalues1[$keys][$item] = array(
                'totalprice' => $PhysicianSystemtotalprice,
                'maxvalue' => $category['maxvalue'],
                'minvalue' => $category['minvalue'],
                'totaldevice' => $PhysicianSystemtotaldevice,
                'avgvalue' => $PhysicianSystemavgvalue,
                'physician_name' => $item,
                'manufacturer_name' => $manufacture_name,
            );


            foreach ($physician as $phy => $phy_data) {
                if ($keys == $phy) {
                    $PhysicianSystemAppvalue[$keys][] = array(
                        'avgvalue' => $phy_data['avgvalue'],
                        'physician_name' => 'Avg Value',
                        'manufacturer_name' => '',
                    );

                }

            }
            $PhysicianSystemAppvalue[$keys][] = array(
                'avgvalue' => $PhysicianSystemavgvalue,
                'physician_name' => $keys,
                'manufacturer_name' => $manufacture_name,
            );
        }


    }


    return $PhysicianSystemAppvalue;
}

/**
 * Physician System App End
 */
/**
 * Manufacture System App Entry Start
 */
function manufacturesystementry($organization, $id, $category, $projects, $year)
{
    $entrydeviceManufacture = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
        ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
        ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
        ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'item_file_main.produceDate', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
        ->where('device.level_name', 'Entry Level')
        ->where('item_file_entry.swapType', '!=', 'Swap Out')
        ->where('item_file_entry.isImplanted', '!=', 'Not Implanted')
        ->where('device.category_name', $id)
        ->orderBy('item_file_main.repcaseID', 'ASC')
        ->orderBy('item_file_main.clientId', 'ASC');

    if (count($organization) > 0) {
        $entryManufactureSystemItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();
        $entrydeviceManufacture = $entrydeviceManufacture->whereIn('item_file_entry.itemMainId', $entryManufactureSystemItemfileId);
    }

    if (!empty($projects)) {
        $entrydeviceManufacture = $entrydeviceManufacture->where('device.project_name', $projects);
    }

    $entrydeviceManufacture = $entrydeviceManufacture->whereYear('item_file_main.produceDate', '=', $year)
        ->get();

    $ManufatureSystemrepcaseId = '';
    $ManufatureSystemisimplanted = '';
    foreach ($entrydeviceManufacture as $row) {

        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

        $row->discount = SerialnumberDetail::where('deviceId', $row->id)->where('status', '')->where('purchaseType', 'Bulk')->where('clientId', $row->clientId)->max('discount');

        $row->unitprice = $unitprice['system_cost'];

        $row->price = $row->discount != '' ? $row->unitprice - (($row->unitprice * $row->discount) / 100) : $row->unitprice;

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
        $Entrymanufacature[$item['short_name']][] = $item;
    }

    $Entrymanufacaturetotalprice = '';
    $Entrymanufacaturemaxvalue = '';
    $Entrymanufacatureminvalue = '';
    $Entrymanufacaturetotaldevice = '';
    $categoryEntrymanufacatureApp = '';

    $EntrymanufacatureAppvalue = array();
    $avgApp = array();
    foreach ($Entrymanufacature as $item => $value) {
//        $Entrymanufacaturetotalprice = array_sum(array_column($value, 'price'));
        //        $Entrymanufacaturemaxvalue = max(array_column($value, 'price'));
        //        $Entrymanufacatureminvalue = min(array_column($value, 'price'));

        $Entrymanufacaturetotalprice = array_sum(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $Entrymanufacaturemaxvalue = max(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $Entrymanufacatureminvalue = min(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $Entrymanufacaturetotaldevice = count($value);

        if ($Entrymanufacaturetotalprice != 0 && $Entrymanufacaturetotaldevice != 0) {
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
            'appavgvalue' => $category['avgvalue'],
            'avgvalue' => $Entrymanufacatureavgvalue,
            'manufacturer_name' => $manufacture_name,
        );

        $avgApp[] = array(
            'avgvalue' => $Entrymanufacatureavgvalue,
            'manufacturer_name' => $manufacture_name,
        );

    }

    $categoryEntrymanufacatureApp = $EntrymanufacatureAppvalue;

    if (!empty($category)) {
        $avgApp[] = array(
            'avgvalue' => $category['avgvalue'],
            'manufacturer_name' => 'Average App',
        );
    }
    $names = array();
    foreach ($avgApp as $user) {
        $names[] = $user['avgvalue'];
    }

    array_multisort($names, SORT_ASC, $avgApp);
//        $data = array_multisort($avgApp);

    return $avgApp;
}

/**
 * Manufacture System App Entry End
 */
/**
 * Manufacture System App Advanced Start
 */
function manufacturesystemadvanced($organization, $id, $category, $projects, $year)
{

    $entrydeviceManufacture = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
        ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
        ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
        ->select('device.*', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'item_file_main.produceDate', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
        ->where('device.level_name', 'Advanced Level')
        ->where('item_file_entry.swapType', '!=', 'Swap Out')
        ->where('item_file_entry.isImplanted', '!=', 'Not Implanted')
        ->where('device.category_name', $id)
        ->orderBy('item_file_main.repcaseID', 'ASC')
        ->orderBy('item_file_main.clientId', 'ASC');

    if (count($organization) > 0) {
        $entryManufactureSystemItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();
        $entrydeviceManufacture = $entrydeviceManufacture->whereIn('item_file_entry.itemMainId', $entryManufactureSystemItemfileId);
    }

    if (!empty($projects)) {
        $entrydeviceManufacture = $entrydeviceManufacture->where('device.project_name', $projects);
    }

    $entrydeviceManufacture = $entrydeviceManufacture->whereYear('item_file_main.produceDate', '=', $year)
        ->get();

    $ManufatureSystemrepcaseId = '';
    $ManufatureSystemisimplanted = '';
    foreach ($entrydeviceManufacture as $row) {

        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();


        $row->discount = SerialnumberDetail::where('deviceId', $row->id)->where('status', '')->where('purchaseType', 'Bulk')->where('clientId', $row->clientId)->max('discount');


        $row->unitprice = $unitprice['system_cost'];

        $row->price = $row->discount != '' ? $row->unitprice - (($row->unitprice * $row->discount) / 100) : $row->unitprice;

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

    $Advancedmanufacature = array();

    foreach ($manufapp as $item) {
        $Advancedmanufacature[$item->short_name][] = $item;
    }

    $Advancedmanufacaturetotalprice = '';
    $Advancedmanufacaturemaxvalue = '';
    $Advancedmanufacatureminvalue = '';
    $Advancedmanufacaturetotaldevice = '';
    $categoryAdvancedmanufacatureApp = '';

    $AdvancedmanufacatureAppvalue = array();
    $avgApp = array();
    foreach ($Advancedmanufacature as $item => $value) {
//        $Advancedmanufacaturetotalprice = array_sum(array_column($value, 'price'));
        //        $Advancedmanufacaturemaxvalue = max(array_column($value, 'price'));
        //        $Advancedmanufacatureminvalue = min(array_column($value, 'price'));

        $Advancedmanufacaturetotalprice = array_sum(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $Advancedmanufacaturemaxvalue = max(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $Advancedmanufacatureminvalue = min(array_map(function ($var) {
            return $var['price'];
        }, $value));

        $Advancedmanufacaturetotaldevice = count($value);

        if ($Advancedmanufacaturetotalprice != 0 && $Advancedmanufacaturetotaldevice != 0) {
            $Advancedmanufacatureavgvalue = round($Advancedmanufacaturetotalprice / $Advancedmanufacaturetotaldevice, 0);
        } else {
            $Advancedmanufacatureavgvalue = 0;
        }

        $manufacture_name = manufacturers::where('id', $item)->value('short_name');

        $AdvancedmanufacatureAppvalue[$item] = array(
            'totalprice' => $Advancedmanufacaturetotalprice,
            'maxvalue' => $category['maxvalue'],
            'minvalue' => $category['minvalue'],
            'totaldevice' => $Advancedmanufacaturetotaldevice,
            'appavgvalue' => $category['avgvalue'],
            'avgvalue' => $Advancedmanufacatureavgvalue,
            'manufacturer_name' => $manufacture_name,
        );

        $avgApp[] = array(
            'avgvalue' => $Advancedmanufacatureavgvalue,
            'manufacturer_name' => $manufacture_name,
        );

    }

    $categoryAdvancedmanufacatureApp = $AdvancedmanufacatureAppvalue;

    if (!empty($category)) {
        $avgApp[] = array(
            'avgvalue' => $category['avgvalue'],
            'manufacturer_name' => 'Average App',
        );
    }

    $names = array();
    foreach ($avgApp as $user) {
        $names[] = $user['avgvalue'];
    }

    array_multisort($names, SORT_ASC, $avgApp);

    return $avgApp;
}
/**
 * Manufacture System App Advanced End
 */

/**
 * System App Calculation End
 */
