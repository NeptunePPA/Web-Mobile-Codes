<?php

/**
 * Created by PhpStorm.
 * User: Punit
 * Date: 12/29/2017
 * Time: 4:01 PM
 */

use App\category;
use App\client_price;
use App\device;
use App\Import_app;
use App\ItemFileEntry;
use App\ItemFileMain;
use App\manufacturers;
use App\SerialnumberDetail;
use App\User;
use App\CategoryGroup;

/**
 * core Function for Autoscore Card Generation
 * @param $category
 * @param $clientId
 * @return \Illuminate\Database\Eloquent\Collection|static[]
 */
function getdata($month, $year, $user, $organization)
{

    $data = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
        ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
        ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
        ->leftJoin('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
        ->leftJoin('item_files_details', 'item_files_details.email', '=', 'item_file_main.phyEmail')
        ->leftjoin('category_group','category_group.category_id','=','device.category_name')
        ->select('device.*', 'manufacturers.short_name as manufacturer','category_group.category_group_name', 'item_file_main.produceDate', 'item_file_entry.purchaseType', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
        ->where('item_file_main.phyEmail', $user)
        ->where('item_file_entry.isImplanted', 'Implanted')
        ->where('item_file_entry.swapType', '!=', 'Swap Out')
        ->orderBy('item_file_main.repcaseID', 'ASC')
        ->orderBy('item_file_main.clientId', 'ASC')
        ->groupBy('item_file_entry.id');


    if (count($organization) > 0) {
        $getItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();

        $data = $data->whereIn('item_file_entry.itemMainId', $getItemfileId);
    }

    if (!empty($month)) {
        $data = $data->whereMonth('item_file_main.produceDate', '=', $month);
    }

    if (!empty($year)) {
        $data = $data->whereYear('item_file_main.produceDate', '=', $year);
    }

    $data = $data->get();


    foreach ($data as $row) {

        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

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

    }

    $category = array();
    foreach ($data as $item) {
        $category[$item->category_name][] = $item;
    }
    $datas = '';

    foreach ($category as $key => $value) {

        foreach ($value as $tem) {
            $datas = deviceId($key, $tem['clientId'], $tem['level_name'], $tem['price'], $tem['id']);
            $tem['comparecompany'] = $datas['manufacturer'];
            $tem['comparedevice_name'] = $datas['device_name'];
            $tem['compareprice'] = $datas['price'];
            $tem['countprice'] = abs($tem['price'] - $datas['price']);
            $tem['count'] = $datas['count'];
        }
    }
    return $category;

}

function deviceId($category, $clientId, $level, $price, $deviceId)
{

    $datas = device::leftJoin('client_price', 'client_price.device_id', '=', 'device.id')
        ->where('device.category_name', $category)
        ->where('client_price.client_name', $clientId)
        ->where('device.level_name', $level)
        ->where('device.id', '!=', $deviceId)
        ->select('device.id', 'device.device_name', 'device.model_name', 'device.manufacturer_name', 'client_price.unit_cost as unitprice')
        ->get();

    $min = array();
    $max = array();

    foreach ($datas as $row) {

        $maxserial = SerialnumberDetail::where('deviceId', $row->id)
            ->where('clientId', $clientId)
            ->where('status', '')
            ->where('purchaseType', 'Bulk')
            ->orderBy('discount', 'DESC')
            ->max('discount');
        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $clientId)->first();

        $row->unitprice = $unitprice['unit_cost'];

        if ($maxserial > 0) {
            $row->price = $row->unitprice - (($row->unitprice * $maxserial) / 100);
        } else {
            $row->price = $row->unitprice;
        }

        if ($unitprice['cco_discount_check'] == 'True') {
            $row->price = $row->price - ($row->price * $unitprice['cco_discount']) / 100;
        } else if ($unitprice['cco_check'] == 'True') {
            $row->price = $row->price - $unitprice['cco'];
        }

        if ($unitprice['unit_repless_discount_check'] == 'True') {
            $row->price = $row->price - ($row->price * $unitprice['unit_repless_discount']) / 100;
        } else if ($unitprice['unit_rep_cost_check'] == 'True') {
            $row->price = $row->price - $unitprice['unit_rep_cost'];
        }

        $row->max = $maxserial;
        $row->manufacturer = $row->manufacturer['manufacturer_name'];

        if (count($min) == 0) {
            $min = $row;
            $max = $row;
        } else {
            if ($min->price > $row->price) {
                $min = $row;
            }
            if ($max->price < $row->price) {
                $max = $row;
            }
        }

        if ($min->price < $price) {
            $data = $min;
            $data['count'] = 'loss';
        } else {
            $data = $max;
            $data['count'] = 'profite';
        }

    }

    return $data;
}

/**
 * Market Share Count Start
 * @param $data
 */
function manufacture($data)
{

    $manufacture = array();
    foreach ($data as $item) {
        $manufacture[$item->manufacturer][] = $item;
    }
    $company = array();
    foreach ($manufacture as $key => $value) {
        $total = array_sum(array_column($value, 'price'));

        $manu = manufacturers::where('manufacturer_name', $key)->value('short_name');
        $company[] = array(
            'totalspend' => intval($total),
            'manufacture' => $key,
            'manufacture_short' => $manu,

        );
    }

    $totalspend = array_sum(array_column($company, 'totalspend'));
    $manu = array();
    foreach ($company as $row) {
        $manu[] = array(
            'totalspend' => intval($row['totalspend']),
            'manufacture' => $row['manufacture'],
            'manufacture_short' => $row['manufacture_short'],
            'marketshare' => intval(round(($row['totalspend'] / $totalspend) * 100, 0)),
            'total' => intval($totalspend),
        );

    }

    return $manu;
}

/**
 * Market Share Count End
 */
/**
 * Bulk Count Start
 * @param $data
 */
function bulkcount($data)
{
    $bulk = 0;
    $consignment = 0;

    foreach ($data as $row) {
        if ($row->purchaseType == "Bulk") {
            $bulk++;
        }
        if ($row->purchaseType == 'Consignment') {
            $consignment++;
        }
    }

    $totalbulk = $bulk + $consignment;

    $bulkcount[0] = array(
        'value' => 'Bulk',
        'count' => $bulk,
        'percenatge' => $bulk == '0' ? '0' : round(($bulk / $totalbulk) * 100, 2),
    );
    $bulkcount[1] = array(
        'value' => 'Consignment',
        'count' => $consignment,
        'percenatge' => $consignment == '0' ? '0' : round(($consignment / $totalbulk) * 100, 2),
    );

    return $bulkcount;

}

/**
 * Bulk Count End
 */
/**
 * Technology Count Start
 * @param $data
 */
function technology($data)
{

    $entry = 0;
    $advanced = 0;

    foreach ($data as $row) {
        if ($row->level_name == "Entry Level") {
            $entry++;
        }
        if ($row->level_name == 'Advanced Level') {
            $advanced++;
        }
    }

    $totaldevice = $entry + $advanced;

    $techcount[0] = array(
        'value' => 'Entry Level',
        'count' => $entry,
        'percenatge' => $entry == '0' ? '0' : round(($entry / $totaldevice) * 100, 2),
    );
    $techcount[1] = array(
        'value' => 'Advanced Level',
        'count' => $advanced,
        'percenatge' => $advanced == '0' ? '0' : round(($advanced / $totaldevice) * 100, 2),
    );

    return $techcount;
}

/**
 * Technology Count End
 */
/**
 * Category Count Start
 * @param $data
 */
function category($data, $totalspend)
{

    $category = array();
    foreach ($data as $key => $value) {
        $loss = '0';
        foreach ($value as $row) {
            if ($row['count'] == 'loss') {
                $loss += $row['countprice'];
            }
        }
        $category[] = array(
            'CategoryName' => categoryname($key),
            'totalSpend' => intval($total = array_sum(array_column($value, 'price'))),
            'loss' => intval($loss),
            'MarketShare' => intval(round(($total / $totalspend) * 100, 2)),
        );
    }

    return $category;
}

/**
 * Category Count End
 */
function categoryname($id)
{
    $data = category::where('id', $id)->value('category_name');
    return $data;
}

/**
 * total Loss Vender Wise Start
 * @param $data
 */
function venderCd($data)
{
    $manufacture = array();
    foreach ($data as $item) {
        $manufacture[$item->manufacturer][] = $item;
    }

    $vender = array();
    foreach ($manufacture as $key => $value) {
        $loss = 0;
        foreach ($value as $row) {
            if ($row['count'] == 'loss') {
                $loss += $row['countprice'];
            }
        }
        $vender[] = array(
            'manufacture' => $key,
            'totalSpend' => intval($total = array_sum(array_column($value, 'price'))),
            'loss' => intval($loss),
            'marketShare' => intval(round(($loss / $total) * 100, 2)),
        );

    }

    return $vender;
}

/**
 * total Loss Vender wise End
 */

/**
 * Bulk Inventory Calculation in Dashboard Start
 */

function Bulkcategory($organization, $projects)
{

    $datas = device::leftJoin('client_price', 'client_price.device_id', '=', 'device.id')
        ->where('device.status', 'Enabled')
        ->select('device.id', 'device.device_name', 'device.model_name', 'device.category_name', 'device.manufacturer_name', 'client_price.unit_cost as unitprice');


    if (!empty($organization)) {
        $datas = $datas->whereIn('client_price.client_name', $organization);
    }

    if (!empty($projects)) {
        $datas = $datas->where('device.project_name', $projects);
    }
    $datas = $datas->groupBy('device.id')->get();


    $categories = category::leftjoin('category_sort', 'category_sort.category_name', '=', 'category.id')
        ->orderBy('category_sort.sort_number', 'ASC')
        ->whereIn('category_sort.client_name', $organization)
        ->where('category.is_active', '=', '1');
    if (!empty($projects)) {
        $categories = $categories->where('category.project_name', $projects);
    }
    $categories = $categories->select('category.short_name')->get()->toArray();

    $category = array();


    foreach ($datas as $row) {
        $row->bulk = SerialnumberDetail::where('deviceId', $row->id);
        if (count($organization) > 0) {
            $row->bulk = $row->bulk->whereIn('clientId', $organization);
        }

        $row->bulk = $row->bulk->where('status', '=', '')->count();

        $category[$row->category_name][] = $row;
    }


    $datas = array();
    $data = array();

    foreach ($category as $key => $value) {
        $categoryName = category::where('id', $key)->value('short_name');

        if ($categoryName != '') {
            $datas[] = array(
                'category_name' => $categoryName,
                'category_id' => $key,
                'bulk' => array_sum(array_column($value, 'bulk')),
            );
        }
    }

    foreach ($categories as $ids) {
        foreach ($datas as $items) {
            if (in_array($ids['short_name'], $items)) {
                $data[] = $items;
            }
        }
    }

    return $datas;
}

function CategoryBulk($organization, $projects)
{

    if (count($organization) > 0) {
        $datas = device::leftJoin('client_price', 'client_price.device_id', '=', 'device.id')
            ->whereIn('client_price.client_name', $organization)
            ->where('device.status', 'Enabled')
            ->select('device.id', 'device.device_name', 'device.model_name', 'device.category_name', 'device.manufacturer_name', 'client_price.unit_cost as unitprice');

    } else {
        $datas = device::leftJoin('client_price', 'client_price.device_id', '=', 'device.id')
            ->where('device.status', 'Enabled')
            ->select('device.id', 'device.device_name', 'device.model_name', 'device.category_name', 'device.manufacturer_name', 'client_price.unit_cost as unitprice');

    }
    if (!empty($projects)) {
        $datas = $datas->where('device.project_name', $projects);
    }
    $datas = $datas->groupBy('device.id')
        ->get();

    $category = array();
    foreach ($datas as $row) {
        $row->bulk = SerialnumberDetail::where('deviceId', $row->id);
        if (count($organization) > 0) {
            $row->bulk = $row->bulk->whereIn('clientId', $organization);
        }

        $row->bulk = $row->bulk->where('status', '=', '')
            ->where('purchaseType', 'Bulk')
            ->count();

        $category[$row->category_name][] = $row;
    }

    $categories = category::leftjoin('category_sort', 'category_sort.category_name', '=', 'category.id')
        ->orderBy('category_sort.sort_number', 'ASC')
        ->whereIn('category_sort.client_name', $organization)
        ->where('category.is_active', '=', '1');
    if (!empty($projects)) {
        $categories = $categories->where('category.project_name', $projects);
    }
    $categories = $categories->select('category.short_name')->get()->toArray();

    $manufactures = array();
    foreach ($category as $item => $values) {
        foreach ($values as $items) {
            $manufactures[$item][$items->manufacturer_name][] = $items;
        }
    }
    $datas = array();
    $data = array();

    foreach ($manufactures as $key => $value) {
        $categoryName = category::where('id', $key)->value('short_name');

        foreach ($value as $finalmanu => $manud) {
            $manufacture_name = manufacturers::where('id', $finalmanu)->value('short_name');

            if ($categoryName != '' && $manufacture_name != '') {
                $data[$categoryName][] = array(
                    'manufacture_name' => $manufacture_name,
                    'manufacture_id' => $key,
                    'bulk' => array_sum(array_column($manud, 'bulk')),
                );
            }
        }
    }


    return $data;
}

/**
 * Bulk Inventory Calculation in Dashboard End
 */

/**
 * Scorecard For client Start
 */
/**
 * Client Marketshare Start
 */

function clientData($month, $year, $user, $organization, $project)
{

    $data = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
        ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
        ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
        ->leftJoin('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
        ->leftJoin('item_files_details', 'item_files_details.email', '=', 'item_file_main.phyEmail')
        ->select('device.*', 'manufacturers.short_name as manufacturer', 'item_file_main.phyEmail', 'item_file_main.produceDate', 'item_file_entry.purchaseType', 'item_file_entry.repcaseID', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_main.projectId', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
        ->where('item_file_entry.isImplanted', 'Implanted')
        ->where('item_file_entry.swapType', '!=', 'Swap Out')
        ->orderBy('item_file_main.repcaseID', 'ASC')
        ->orderBy('item_file_main.clientId', 'ASC')
        ->groupBy('item_file_entry.id');


    if (!empty($organization)) {
        $getItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();
        $data = $data->whereIn('item_file_entry.itemMainId', $getItemfileId);
    }

    if (count($project) > 0) {
        $data = $data->whereIn('item_file_main.projectId', $project);
    }

    if (!empty($user)) {
        $data = $data->where('item_file_main.phyEmail', $user);
    }

    if (!empty($month)) {

        $data = $data->whereMonth('item_file_main.produceDate', '=', $month);
    }
    if (!empty($year)) {
        $data = $data->whereYear('item_file_main.produceDate', '=', $year);
    }

    $data = $data->get();

    foreach ($data as $row) {

        $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

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
    }
    $datas = array();
    foreach ($data as $keys => $values) {
        $datas[] = $values;
    }

    return $datas;
}

function client_marketshare($data)
{

    $totalspends = array_sum(array_column($data, 'price'));

    $manufacture = array();
    foreach ($data as $item) {
        $manufacture[$item->manufacturer][] = $item;
    }

    $company = array();

    foreach ($manufacture as $key => $value) {
        $total = array_sum(array_column($value, 'price'));
        $company[] = array(
            'totalspend' => intval($total),
            'manufacture' => $key,
            'ms' => round(($total / $totalspends) * 100, 0),
        );
    }

    return array('marketshare' => $company, 'totalspend' => $totalspends);
}

/**
 * Client Marketshare End
 */

function Appcalculationoldyear($organization, $level, $year, $categoryId, $user, $project)
{
    $checkdata = Import_app::where('category_name', $categoryId)
        ->whereIn('client_name', $organization)
        ->where('device_level', $level)
        ->whereIn('project_name', $project)
        ->where('year', $year)
        ->first();

    if (empty($checkdata)) {
        $checkdata = Import_app::where('category_name', $categoryId)
            ->whereIn('client_name', $organization)
            ->whereIn('project_name', $project)
            ->where('year', $year)
            ->first();
    }

    if (!empty($checkdata)) {

        $categoryAppvalue = array('oldavgvlaue' => $checkdata['category_avg_app']);
    } else {


        $getDeviceId = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
            ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
            ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
            ->select('device.*', 'item_file_entry.repcaseID', 'item_file_main.phyEmail', 'item_file_main.produceDate', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_entry.cco_check', 'item_file_entry.repless_check', 'item_file_main.projectId')
            ->where('item_file_entry.swapType', '!=', 'Swap Out')
            ->where('item_file_entry.isImplanted', '!=', 'Not Implanted')
            ->orderBy('item_file_main.repcaseID', 'ASC')
            ->orderBy('item_file_main.clientId', 'ASC')
            ->groupBy('item_file_entry.id');

        if (!empty($organization)) {
            $getItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();
            $getDeviceId = $getDeviceId->whereIn('item_file_entry.itemMainId', $getItemfileId);
        }

        if (!empty($level)) {

            $getDeviceId = $getDeviceId->where('device.level_name', $level);
        }

        if (!empty($categoryId)) {

            $getDeviceId = $getDeviceId->where('device.category_name', $categoryId);
        }

        if (!empty($user)) {

            $getDeviceId = $getDeviceId->where('item_file_main.phyEmail', $user);
        }

        if (count($project) > 0) {

            $getDeviceId = $getDeviceId->whereIn('item_file_main.projectId', $project);
        }

        if (!empty($year)) {
            $getDeviceId = $getDeviceId->whereYear('item_file_main.produceDate', '=', $year);
        }

        $getDeviceId = $getDeviceId->get();

        $repcaseId = '';
        $isimplanted = '';
        foreach ($getDeviceId as $row) {

            $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

            if ($row->repcaseID == $repcaseId && $isimplanted == 'yes' && $row->isImplanted == 'yes') {
                $row->unitprice = $unitprice['system_cost'];
                $row->price = $row->discount != '' ? $row->unitprice - (($row->unitprice * $row->discount) / 100) : $row->unitprice;

            } else {
                $row->unitprice = $unitprice['unit_cost'];
                $row->price = $row->discount != '' ? $row->unitprice - (($row->unitprice * $row->discount) / 100) : $row->unitprice;

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

        $category = array();
        foreach ($getDeviceId as $item) {
            $category[$item->category_name][] = $item;
        }
        $totalprice = '';
        $maxvalue = '';
        $minvalue = '';
        $totaldevice = '';
        $avgvalue = '';

        if (!empty($categoryId)) {
            $categoryAppvalue = array();

            if (count($category) <= 0) {
                $categoryAppvalue = array('oldavgvlaue' => 0);

            } else {

                foreach ($category as $item => $value) {
                    $totalprice = array_sum(array_column($value, 'price'));
//            $maxvalue = max(array_column($value, 'price'));
                    //            $minvalue = min(array_column($value, 'price'));
                    $totaldevice = count($value);

                    if ($totalprice != 0 && $totaldevice != 0) {
                        $avgvalue = round($totalprice / $totaldevice, 2);
                    } else {
                        $avgvalue = 0;
                    }

                    $categoryAppvalue = array('oldavgvlaue' => $avgvalue);
                }
            }
        } else {
            $saving = array();

            foreach ($category as $row => $value) {

                foreach ($value as $item) {
                    $saving[] = $item;
                }
            }
            $totalprice = array_sum(array_column($saving, 'price'));

            $totaldevice = count($totalprice);

            if ($totalprice != 0 && $totaldevice != 0) {
                $avgvalue = round($totalprice / $totaldevice, 2);
            } else {
                $avgvalue = 0;
            }

            $categoryAppvalue = array('oldavgvlaue' => $avgvalue);

        }
    }

    return $categoryAppvalue;
}

function appvlaueCurrentyear($organization, $level, $year, $month, $categoryId, $user, $project)
{

    $checkdata = Import_app::where('category_name', $categoryId)
        ->whereIn('client_name', $organization)
        ->where('device_level', $level)
        ->whereIn('project_name', $project)
        ->where('year', $year)
        ->first();

    if (empty($checkdata)) {
        $checkdata = Import_app::where('category_name', $categoryId)
            ->whereIn('client_name', $organization)
//            ->where('device_level',$level)
            ->whereIn('project_name', $project)
            ->where('year', $year)
            ->first();
    }

    if (!empty($checkdata)) {
        $categoryAppvalue = array(
            'totaldevice' => 1,
            'totalprice' => 1,
            'currentavgvalue' => $checkdata['category_avg_app'],
        );

    } else {


        $getDeviceId = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
            ->join('serialdetail', 'serialdetail.serialNumber', '=', 'item_file_entry.serialNumber')
            ->leftjoin('device', 'device.id', '=', 'serialdetail.deviceId')
            ->select('device.*', 'item_file_entry.repcaseID', 'item_file_main.projectId', 'item_file_main.produceDate', 'item_file_main.phyEmail', 'item_file_entry.isImplanted', 'serialdetail.serialNumber', 'serialdetail.discount', 'item_file_main.clientId', 'item_file_entry.cco_check', 'item_file_entry.repless_check')
            ->where('item_file_entry.swapType', '!=', 'Swap Out')
            ->where('item_file_entry.isImplanted', '!=', 'Not Implanted')
            ->orderBy('item_file_main.repcaseID', 'ASC')
            ->orderBy('item_file_main.clientId', 'ASC')
            ->groupBy('item_file_entry.id');

        if (count($organization) > 0) {
            $getItemfileId = ItemFileMain::whereIn('clientId', $organization)->pluck('id')->all();

            $getDeviceId = $getDeviceId->whereIn('item_file_entry.itemMainId', $getItemfileId);
        }

        if (!empty($level)) {
            $getDeviceId = $getDeviceId->where('device.level_name', $level);

        }
        if (!empty($categoryId)) {

            $getDeviceId = $getDeviceId->where('device.category_name', $categoryId);
        }

        if (!empty($month)) {

            $getDeviceId = $getDeviceId->whereMonth('item_file_main.produceDate', '=', $month);
        }

        if (!empty($user)) {

            $getDeviceId = $getDeviceId->where('item_file_main.phyEmail', $user);
        }

        if (count($project) > 0) {

            $getDeviceId = $getDeviceId->whereIn('item_file_main.projectId', $project);
        }

        if (!empty($year)) {

            $getDeviceId = $getDeviceId->whereYear('item_file_main.produceDate', '=', $year);
        }

        $getDeviceId = $getDeviceId->get();

        $repcaseId = '';
        $isimplanted = '';
        foreach ($getDeviceId as $row) {

            $unitprice = client_price::where('device_id', $row->id)->where('client_name', $row->clientId)->first();

            if ($row->repcaseID == $repcaseId && $isimplanted == 'yes' && $row->isImplanted == 'yes') {
                    $row->unitprice = $unitprice['system_cost'];

                    $row->price = $row->discount != '' ? $row->unitprice - (($row->unitprice * $row->discount) / 100) : $row->unitprice;

            } else {
                $row->unitprice = $unitprice['unit_cost'];
                $row->price = $row->discount != '' ? $row->unitprice - (($row->unitprice * $row->discount) / 100) : $row->unitprice;
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

        $category = array();

        foreach ($getDeviceId as $item) {
            $category[$item->category_name][] = $item;
        }

        $totalprice = '';
        $maxvalue = '';
        $minvalue = '';
        $totaldevice = '';
        $avgvalue = '';

        if (!empty($categoryId)) {

            $categoryAppvalue = array();
            if (count($category) <= 0 || count($getDeviceId) <= 0) {
                $categoryAppvalue = array(
                    'totaldevice' => 0,
                    'totalprice' => 0,
                    'currentavgvalue' => 0,
                );
            } else {
                foreach ($category as $item => $value) {
                    $totalprice = array_sum(array_column($value, 'price'));
//            $maxvalue = max(array_column($value, 'price'));
                    //            $minvalue = min(array_column($value, 'price'));
                    $totaldevice = count($value);

                    if ($totalprice != 0 && $totaldevice != 0) {
                        $avgvalue = round($totalprice / $totaldevice, 2);
                    } else {
                        $avgvalue = 0;
                    }

                    $categoryAppvalue = array(
                        'totaldevice' => $totaldevice,
                        'totalprice' => $totalprice,
                        'currentavgvalue' => $avgvalue,
                    );
                }
            }
        } else {

            $saving = array();

            foreach ($category as $row => $value) {

                foreach ($value as $item) {
                    $saving[] = $item;
                }
            }
            $totalprice = array_sum(array_column($saving, 'price'));

            $totaldevice = count($totalprice);

            if ($totalprice != 0 && $totaldevice != 0) {
                $avgvalue = round($totalprice / $totaldevice, 2);
            } else {
                $avgvalue = 0;
            }

            $categoryAppvalue = array(
                'totaldevice' => $totaldevice,
                'totalprice' => $totalprice,
                'currentavgvalue' => $avgvalue,
            );
        }
    }

    return $categoryAppvalue;
}

/**
 * Client Spend
 */
//function clientSpend($organization, $year, $user, $project)
//{
//
//    $vendorspend = array();
//
//    for ($i = 1; $i <= 12; $i++) {
//
//        $data = clientData($i, $year, $user, $organization, $project);
//
//        $total = array_sum(array_column($data, 'price'));
//
//        $monthname = getMonthName($i);
//
//        $vendorspend[] = array(
//            'totalspend' => $total,
//            'month' => $monthname,
//        );
//
//    }
//
//    $totalspend = array_sum(array_column($vendorspend, 'totalspend'));
//
//    $vendorspend[] = array(
//        'totalspend' => $totalspend,
//        'month' => 'Total',
//    );
//
//    return $vendorspend;
//}
//
//function clientSaving($organization, $year, $user, $clientspend, $project)
//{
//    $vendorspend = array();
//
//    for ($i = 1; $i <= 12; $i++) {
//
//        $data = clientData($i, $year, $user, $organization, $project);
//
//        $total = array_sum(array_column($data, 'price'));
//
//        $monthname = getMonthName($i);
//
//        $vendorspend[] = array(
//            'totalspend' => $total,
//            'month' => $monthname,
//        );
//
//    }
//
//    $totalspend = array_sum(array_column($vendorspend, 'totalspend'));
//
//    $vendorspend[] = array(
//        'totalspend' => $totalspend,
//        'month' => 'Total',
//    );
//
//    $vendortotalspend = array();
//    $saving = 0;
//    for ($j = 0; $j < count($vendorspend); $j++) {
//
//        $saving = $clientspend[$j]['totalspend'] - $vendorspend[$j]['totalspend'];
//
//        if ($saving > 0) {
//            $saving = 0;
//        } else {
//            $saving = abs($saving);
//        }
//
//        $vendortotalspend[] = array(
//            'totalspend' => $clientspend[$j]['totalspend'],
//            'month' => $clientspend[$j]['month'],
//            'totalsaving' => $saving,
//        );
//    }
//
//    return $vendortotalspend;
//}

function getMonthName($id)
{

    $monthNum = $id;
    $dateObj = DateTime::createFromFormat('!m', $monthNum);
    $monthName = $dateObj->format('F');

    return $monthName;
}

function getclientName($id)
{
    $client = \App\clients::where('id', $id)->value('client_name');

    return $client;
}

function getuserSaving($organization, $level, $year, $month, $project)
{
}

/**
 * Scorecard For client End
 */

/**
 * Get Device Min and Max Price using category client and project Start
 */

function device_price($organization, $project, $level, $category, $type)
{

    $data = device::orderBy('id', 'DESC');

    if (!empty($category)) {

        $data = $data->where('category_name', $category);
    }

    if (!empty($project)) {

        $data = $data->where('project_name', $project);
    }

//    if (!empty($level)) {
    //
    //        $data = $data->where('level_name', $level);
    //    }

    $data = $data->get();

    foreach ($data as $row) {

        $unit_price = client_price::whereIn('client_name', $organization)->where('device_id', $row->id)->first();

        $row->unitprice = $unit_price['unit_cost'];

        if ($type == 'System') {
            $row->unitprice = $unit_price['system_cost'];
        }

//        dump($row->id);

//        dump($row->unitprice);
        $row->discount = SerialnumberDetail::where('deviceId', $row->id)->where('status', '')->where('purchaseType', 'Bulk')->whereIn('clientId', $organization)->max('discount');

//        $row->discount = SerialnumberDetail::where('deviceId',$row->id)->whereIn('clientId',$organization)->max('discount');

        if ($row->discount != '') {
            $row->price = $row->unitprice - (($row->unitprice * $row->discount) / 100);
        } else {
            $row->price = $row->unitprice;
        }

//        dump($row->price);

        $cco = '';
        $repless = '';

        if ($type == 'Unit') {
            if ($unit_price['cco_discount_check'] == 'True') {

                $cco = ($row->price * $unit_price['cco_discount']) / 100;
                $row->price = $row->price - $cco;
            } else if ($unit_price['cco_check'] == 'True') {
                $row->price = $row->price - $unit_price['cco'];
            }

            if ($unit_price['unit_repless_discount_check'] == 'True') {
                $repless = ($row->price * $unit_price['unit_repless_discount']) / 100;

            } else if ($unit_price['unit_rep_cost_check'] == 'True') {
                $row->price = $row->price - $unit_price['unit_rep_cost'];
            }
        }

        if ($type == 'System') {
            if ($unit_price['system_repless_discount_check'] == 'True') {
                $repless = ($row->price * $unit_price['system_repless_discount']) / 100;
                $row->price = $row->price - $repless;
            } else if ($unit_price['system_repless_cost_check'] == 'True') {
                $row->price = $row->price - $unit_price['system_repless_cost'];
            }
        }
    }

    $numbers = array();
    foreach ($data as $obj) {
        if ($obj->price != null) {
            $numbers[] = $obj->price;
        }
    }
    $datas = $data;
    $maxvalue = 0;
    $minvalue = 0;
    if (count($numbers) > 0) {
        $minvalue = min($numbers);
    }

    foreach ($datas as $item) {
        $unit_price = client_price::whereIn('client_name', $organization)->where('device_id', $item->id)->first();

        $item->price = $unit_price['unit_cost'];

        if ($type == 'System') {
            $item->price = $unit_price['system_cost'];
        }
    }

    $numberss = array();
    foreach ($datas as $objs) {
        if ($objs->price != null) {
            $numberss[] = $objs->price;
        }
    }

    if (count($numbers) > 0) {
        $maxvalue = max($numberss);

    }

    $datas = array(
        'maxvalue' => $maxvalue,
        'minvalue' => $minvalue,
    );

    return $datas;
}

/**
 * Get Device Min and Max Price using category client and project End
 */