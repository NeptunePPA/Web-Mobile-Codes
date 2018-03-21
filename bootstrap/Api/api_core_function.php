<?php
/**
 * Created by PhpStorm.
 * User: Punit
 * Date: 1/6/2018
 * Time: 9:45 AM
 */

use App\device;
use App\DeviceFeatureImage;
use App\device_custom_field;
use App\SerialnumberDetail;
use App\User;
use App\userProjects;

/**
 * Device List Core Function
 * @param $clientId
 * @param $categoryId
 * @param $type
 * @param $level
 * @param $bulk
 * @return array
 */
function deviceList($clientId, $categoryId, $type, $level, $bulk)
{

    $device = array();

    $getdevices = device::join('client_price', 'client_price.device_id', '=', 'device.id')
        ->leftjoin('device_features', 'device_features.device_id', '=', 'device.id')
        ->join('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
        ->where('client_price.client_name', '=', $clientId)
        ->where('device_features.client_name', '=', $clientId)
        ->select('device.*', 'client_price.client_name', 'client_price.device_id', 'client_price.unit_cost', 'client_price.unit_cost_check', 'client_price.bulk_unit_cost', 'client_price.bulk_unit_cost_check'
            , 'client_price.bulk', 'client_price.bulk_check', 'client_price.cco_discount', 'client_price.cco', 'client_price.cco_check', 'client_price.cco_discount_check', 'client_price.unit_rep_cost', 'client_price.unit_rep_cost_check', 'client_price.unit_repless_discount'
            , 'client_price.unit_repless_discount_check', 'client_price.system_cost', 'client_price.system_bulk', 'client_price.system_bulk_check', 'client_price.system_cost_check', 'client_price.bulk_system_cost', 'client_price.bulk_system_cost_check', 'client_price.system_repless_cost', 'client_price.system_repless_cost_check'
            , 'client_price.system_repless_discount', 'client_price.system_repless_discount_check', 'client_price.reimbursement', 'client_price.reimbursement_check', 'client_price.unit_cost_delta_check', 'client_price.cco_delta_check', 'client_price.cco_discount_delta_check', 'client_price.unit_repless_delta_check', 'client_price.unit_repless_discount_delta_check', 'client_price.system_cost_delta_check'
            , 'client_price.system_repless_delta_check', 'client_price.system_repless_discount_delta_check', 'client_price.reimbursement_delta_check', 'client_price.is_delete as clientprice_delete', 'device_features.longevity_check',
            'device_features.shock_check', 'device_features.size_check', 'device_features.research_check', 'device_features.siteinfo_check', 'device_features.overall_value_check', 'device_features.longevity_delta_check', 'device_features.shock_delta_check', 'device_features.size_delta_check', 'device_features.research_delta_check', 'device_features.site_info_delta_check', 'device_features.overall_value_delta_check', 'manufacturers.manufacturer_logo')
        ->where('device.category_name', '=', $categoryId)
        ->where('device.level_name', '=', $level . ' Level');

    $getdevices = $getdevices->where('device.is_delete', '=', 0)
        ->where('device.status', '=', 'Enabled');

    if ($type == 'Unit') {
        $getdevices = $getdevices->where('client_price.unit_cost_check', '=', 'True');
    } else if ($type == 'System') {
        $getdevices = $getdevices->where('client_price.system_cost_check', '=', 'True');
    }

    $getdevices = $getdevices->where('client_price.is_delete', '=', 0)
        ->get();

    $getdevice = array();

    if ($bulk == 'Yes' && $type == 'Unit' || $bulk == 'Yes' && $type == 'System') {


        if (count($getdevices) > 0) {

            foreach ($getdevices as $item) {

                $serials = SerialnumberDetail::where('deviceId', $item->id)
                    ->where('clientId', $clientId)
                    ->where('purchaseType', 'Bulk')
                    ->where('status', '=', '')
                    ->select('serialNumber', 'purchaseDate', 'expiryDate')
                    ->get();

                if (count($serials) > 0) {
                    $getdevice[] = $item;

                }
            }
        }
    } else {
        $getdevice = $getdevices;

    }

    foreach ($getdevice as $row) {

        $maxserial = SerialnumberDetail::where('deviceId', $row->id)
            ->where('clientId', $clientId)
            ->where('status', '=', '')
            ->where('purchaseType', 'Bulk')
            ->select('discount')
            ->max('discount');

//        Log::debug($maxserial);

        if ($maxserial > 0) {

            if ($type == 'Unit') {
                if ($row->bulk_check == 'True') {
                    $price = $row->unit_cost - (($row->unit_cost * $maxserial) / 100);
                } else {
                    $price = $row->unit_cost;
                }
            } else {
                if ($row->system_bulk_check == 'True') {
                    $price = $row->system_cost - (($row->system_cost * $maxserial) / 100);
                } else {
                    $price = $row->system_cost;
                }
            }
        } else {
            $price = $type == 'Unit' ? $row->unit_cost : $row->system_cost;
        }

        $cco = '';
        $repless = '';

        if ($type == 'Unit') {
            if ($row->cco_discount_check == 'True') {

                $cco = ($price * $row->cco_discount) / 100;
                $cco = $price - $cco;
            } else if ($row->cco_check == 'True') {
                $cco = $price - $row->cco;
            }

            if ($row->unit_repless_discount_check == 'True') {

                $repless = ($cco == '' ? $price : $cco * $row->unit_repless_discount) / 100;
                $repless = ($cco == '' ? $price : $cco) - $repless;
            } else if ($row->unit_rep_cost_check == 'True') {
                $repless = ($cco == '' ? $price : $cco) - $row->unit_rep_cost;
            }
        }

        if ($type == 'System') {
            if ($row->system_repless_discount_check == 'True') {

                $repless = ($price * $row->system_repless_discount) / 100;
                $repless = $price - $repless;
            } else if ($row->system_repless_cost_check == 'True') {
                $repless = $price - $row->system_repless_cost;
            }
        }

        $shock = '';
        if ($row->shock != "") {
            $shock = explode('/', $row->shock);
//            Log::debug($shock);
            if (count($shock) > 0) {
                $shock1 = $shock[0] == "" ? "0" : $shock[0];
                $shock2 = $shock[1] == "" ? "0" : $shock[1];
                $shock = $shock1 . 'J/' . $shock2 . 's';
            } else {
                $size = $shock . 'J/00s';
            }

            $shock = $shock1 . 'J/' . $shock2 . 's';
        }

        $size = '';
        if ($row->size != "") {
            $size = explode('/', $row->size);
            if (count($size) > 0) {
                $size1 = "" ? "0" : $size[0];
                $size2 = "" ? "0" : $size[1];
                $size = $size1 . 'g/' . $size2 . 'cc';
            } else {
                $size = $size . 'g/00cc';
            }

        }

        $custom = array();
        $customs = device_custom_field::leftJoin('client_custom_field', 'client_custom_field.c_id', '=', 'device_custom_field.id')
            ->select('device_custom_field.id', 'device_custom_field.field_name', 'device_custom_field.field_value', 'client_custom_field.field_check', 'client_custom_field.fileld_highlight', 'device_custom_field.fileld_delta_check', 'device_custom_field.fieldside', 'device_custom_field.fieldimage')
            ->where('client_custom_field.device_id', $row->id)
            ->where('client_custom_field.client_name', '=', $clientId)
            ->get();

        foreach ($customs as $cus) {
            if (!empty($cus->fieldimage) && file_exists('public/upload/devicefeature/custom/' . $cus->fieldimage)) {
                $cus->fieldimage = URL::to('public/upload/devicefeature/custom/' . $cus->fieldimage);
            } else {
                $cus->fieldimage = URL::to('public/upload/default.jpg');
            }
            $custom[] = array(
                'name' => $cus->field_name,
                'value' => $cus->field_value,
                'check' => $cus->field_value == '' ? 'False' : ($cus->field_check == '' ? 'False' : $cus->field_check),
                'side' => $cus->fieldside == '' ? 'Left' : $cus->fieldside,
                'image' => $cus->fieldimage,
            );
        }

        $deviceFeatureImage = DeviceFeatureImage::first();

        $serial = SerialnumberDetail::where('deviceId', $row->id)
            ->where('clientId', $clientId)
            ->where('purchaseType', 'Bulk')
            ->where('status', '=', '')
            ->select('serialNumber', 'purchaseDate', 'expiryDate')
            ->get();

        if (!empty($row->device_image) && file_exists('public/upload/' . $row->device_image)) {
            $row->device_image = URL::to('public/upload/' . $row->device_image);
        } else {
            $row->device_image = URL::to('public/upload/default.jpg');
        }

        /**
         * Bulk Color Checking Start
         */

        $expirydate = SerialnumberDetail::where('deviceId', $row->id)
            ->where('clientId', $clientId)
            ->where('status', '=', '')
            ->where('purchaseType', 'Bulk')
            ->where('expiryDate', '>=', \Carbon\Carbon::now()->format('m-d-Y'))
            ->orderBy('expiryDate', 'ASC')
            ->first();


        $your_date = $expirydate['expiryDate'];

        $bulk_color = '#073F84';
        /**
         * Bulk Color Checking End
         */

        $performance = $row->performance;

        $device[] = array(
            'id' => $row->id,
            'device_name' => $row->device_name,
            'model_name' => $row->model_name,
            'device_image' => $row->device_image,
            'price' => $price,
            'bulk' => $type == 'Unit' ? $row->bulk : $row->system_bulk,
            'bulk_check' => $type == 'Unit' ? $row->bulk_check : $row->system_bulk_check,
            'bulk_highlight' => 'False',
            'bulk_color' => $bulk_color,
            'cco' => $cco,
            'cco_check' => $cco == '' ? 'False' : 'True',
            'repless' => $repless,
            'repless_check' => $repless == '' ? 'False' : 'True',
            'feature' => array(
                array(
                    'name' => 'longevity',
                    'value' => $row->longevity . ' Years',
                    'check' => $row->longevity == '' ? 'False' :($row->longevity_check == '' ? 'False' : $row->longevity_check),
                    'side' => $row->longevity_side == '' ? 'Left' : $row->longevity_side,
                    'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->longevityimage),
                ),
                array(
                    'name' => 'shock',
                    'value' => $shock,
                    'check' => $shock == '' ? 'False' : ($row->shock_check == '' ? 'False' : $row->shock_check),
                    'side' => $row->shock_side == '' ? 'Left' : $row->shock_side,
                    'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->shockimage),
                ),
                array(
                    'name' => 'size',
                    'value' => $size,
                    'check' => $size == '' ? 'False' :($row->size_check == '' ? 'False' : $row->size_check),
                    'side' => $row->size_side == '' ? 'Left' : $row->size_side,
                    'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->sizeimage),
                ),
                array(
                    'name' => 'research',
                    'value' => $row->research,
                    'check' => $row->research == '' ? 'False' :($row->research_check == '' ? 'False' : $row->research_check),
                    'side' => $row->research_side == '' ? 'Left' : $row->research_side,
                    'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->researchimage),
                ),
                array(
                    'name' => 'website_page',
                    'value' => $row->website_page,
                    'check' => $row->url == '' ? "False" : "True",
                    'side' => $row->websitepage_side == '' ? 'Left' : $row->websitepage_side,
                    'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->websiteimage),
                    'weburl' => $row->url,
                ),
                array(
                    'name' => 'overall_value',
                    'value' => $row->overall_value,
                    'check' => $row->overall_value == '' ? 'False' : ($row->overall_value_check == '' ? 'False' : $row->overall_value_check),
                    'side' => $row->overall_value_side == '' ? 'Left' : $row->overall_value_side,
                    'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->overallimage),
                ),
                array(
                    'name' => 'performance',
                    'value' => $row->performance,
                    'check' => $performance == '' ? "False" : "True",
                    'side' => 'Left',
                    'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->performanceImage),
                    'weburl' => $row->performance,
                ),
            ),
            'research_email' => $row->research_email,
            'manufacturer_logo' => URL::to('public/upload/' . $row->manufacturer_logo),
            'manufacture_name' => $row->manufacturer->short_name,
            'custom' => $custom,
            'serial' => $serial,
            'expire_date' => $your_date,
            'expire_range'=>array(
                array(
                    'day' => day1,
                    'color'=>color1
                ),
                array(
                    'day' => day2,
                    'color'=>color2
                ),
                array(
                    'day' => day3,
                    'color'=>color3
                ),
            )
        );

    }

    if (count($device) > 0) {
        foreach ($device as $key => $row) {
            $pricess[$key] = $row['price'];
        }

        array_multisort($pricess, SORT_NUMERIC, $device);
    }

    $devicemanu = array();

    foreach ($device as $man) {
        $devicemanu[$man['manufacturer_logo']][] = $man;
    }

    $newdevice = array();

    foreach ($devicemanu as $key => $value) {
        $newdevice[] = array(
            'manufacture_image' => $key,
            'devicelist' => $value,
        );
    }
    return $newdevice;
}

/**
 * Device Comapare Api
 * @param $clientId
 * @param $categoryId
 * @param $device1
 * @param $device2
 */
function deviceCompare($clientId, $categoryId, $type, $device1, $device2, $user, $device1_cco, $device1_repless, $device2_cco, $device2_repless)
{

    /**
     * First Device
     */
    $first_device = array();
    $device_first = device::join('client_price', 'client_price.device_id', '=', 'device.id')
        ->leftjoin('device_features', 'device_features.device_id', '=', 'device.id')
        ->join('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
        ->where('client_price.client_name', '=', $clientId)
        ->where('device_features.client_name', '=', $clientId)
        ->select('device.*', 'client_price.client_name', 'client_price.device_id', 'client_price.unit_cost', 'client_price.unit_cost_check', 'client_price.bulk_unit_cost', 'client_price.bulk_unit_cost_check'
            , 'client_price.bulk', 'client_price.bulk_check', 'client_price.cco_discount', 'client_price.cco', 'client_price.cco_check', 'client_price.cco_discount_check', 'client_price.unit_rep_cost', 'client_price.unit_rep_cost_check', 'client_price.unit_repless_discount'
            , 'client_price.unit_repless_discount_check', 'client_price.system_cost', 'client_price.system_bulk', 'client_price.system_bulk_check', 'client_price.system_cost_check', 'client_price.bulk_system_cost', 'client_price.bulk_system_cost_check', 'client_price.system_repless_cost', 'client_price.system_repless_cost_check'
            , 'client_price.system_repless_discount', 'client_price.system_repless_discount_check', 'client_price.reimbursement', 'client_price.reimbursement_check', 'client_price.unit_cost_delta_check', 'client_price.cco_delta_check', 'client_price.cco_discount_delta_check', 'client_price.unit_repless_delta_check', 'client_price.unit_repless_discount_delta_check', 'client_price.system_cost_delta_check'
            , 'client_price.system_repless_delta_check', 'client_price.system_repless_discount_delta_check', 'client_price.reimbursement_delta_check', 'client_price.is_delete as clientprice_delete', 'device_features.longevity_check',
            'device_features.shock_check', 'device_features.size_check', 'device_features.research_check', 'device_features.siteinfo_check', 'device_features.overall_value_check', 'device_features.longevity_delta_check', 'device_features.shock_delta_check', 'device_features.size_delta_check', 'device_features.research_delta_check', 'device_features.site_info_delta_check', 'device_features.overall_value_delta_check', 'manufacturers.manufacturer_logo')
        ->where('device.category_name', '=', $categoryId)
        ->where('device.id', '=', $device1)
        ->where('device.is_delete', '=', 0)
        ->where('device.status', '=', 'Enabled');

    if ($type == 'Unit') {
        $device_first = $device_first->where('client_price.unit_cost_check', '=', 'True');
    } else if ($type == 'System') {
        $device_first = $device_first->where('client_price.system_cost_check', '=', 'True');
    }
    $device_first = $device_first->where('client_price.is_delete', '=', 0)
        ->get();

    foreach ($device_first as $row) {

        $maxserial = SerialnumberDetail::where('deviceId', $row->id)->where('clientId', $clientId)
            ->where('status', '=', '')
            ->where('purchaseType', 'Bulk')
            ->select('discount')
            ->max('discount');
        if ($maxserial > 0) {

            if ($type == 'Unit') {
                if ($row->bulk_check == 'True') {
                    $price = $row->unit_cost - (($row->unit_cost * $maxserial) / 100);
                } else {
                    $price = $row->unit_cost;
                }
            } else {
                if ($row->system_bulk_check == 'True') {
                    $price = $row->system_cost - (($row->system_cost * $maxserial) / 100);
                } else {
                    $price = $row->system_cost;
                }
            }
        } else {
            $price = $type == 'Unit' ? $row->unit_cost : $row->system_cost;
        }

        $cco = '';
        $repless = '';
        $cco_delta = '';
        $repless_delta = '';

        if ($type == 'Unit') {
            if ($device1_cco == 'true') {
                if ($row->cco_discount_check == 'True') {

                    $cco = ($price * $row->cco_discount) / 100;
                    $cco = $price - $cco;
                    $cco_delta = $row->cco_discount_delta_check;
                } else if ($row->cco_check == 'True') {
                    $cco = $price - $row->cco;
                    $cco_delta = $row->cco_delta_check;
                }
            }

            if ($device1_repless == 'true') {

                if ($row->cco_discount_check == 'True') {

                    $cco = ($price * $row->cco_discount) / 100;
                    $cco = $price - $cco;
                    $cco_delta = $row->cco_discount_delta_check;
                } else if ($row->cco_check == 'True') {
                    $cco = $price - $row->cco;
                    $cco_delta = $row->cco_delta_check;
                }

                if ($row->unit_repless_discount_check == 'True') {

                    $repless = (($cco == '' ? $price : $cco) * $row->unit_repless_discount) / 100;
                    $repless = ($cco == '' ? $price : $cco) - $repless;
                    $repless_delta = $row->unit_repless_discount_delta_check;
                } else if ($row->unit_rep_cost_check == 'True') {
                    $repless = ($cco == '' ? $price : $cco) - $row->unit_rep_cost;
                    $repless_delta = $row->unit_repless_delta_check;
                }
            }

        }

        if ($type == 'System') {
            if ($device1_repless == true) {
                if ($row->system_repless_discount_check == 'True') {

                    $repless = ($price * $row->system_repless_discount) / 100;
                    $repless = $price - $repless;
                    $repless_delta = $row->system_repless_discount_delta_check;
                } else if ($row->system_repless_cost_check == 'True') {
                    $repless = $price - $row->system_repless_cost;
                    $repless_delta = $row->system_repless_delta_check;
                }
            }

        }

        $shock = '';
        if ($row->shock != "") {
            $shock = explode('/', $row->shock);
            $shock1 = "" ? "0" : $shock[0];
            $shock2 = "" ? "0" : $shock[1];
            $shock = $shock1 . 'J/' . $shock2 . 's';
        }

        $size = '';
        if ($row->size != "") {
            $size = explode('/', $row->size);
            $size1 = "" ? "0" : $size[0];
            $size2 = "" ? "0" : $size[1];
            $size = $size1 . 'g/' . $size2 . 'cc';
        }

        $custom1 = array();
        $customs = device_custom_field::leftJoin('client_custom_field', 'client_custom_field.c_id', '=', 'device_custom_field.id')
            ->select('device_custom_field.id', 'device_custom_field.field_name', 'device_custom_field.field_value', 'client_custom_field.field_check', 'client_custom_field.fileld_highlight', 'device_custom_field.fileld_delta_check', 'device_custom_field.fieldside', 'device_custom_field.fieldimage')
            ->where('client_custom_field.device_id', $row->id)
            ->where('client_custom_field.client_name', '=', $clientId)
            ->get();

        foreach ($customs as $cus) {
            if (!empty($cus->fieldimage) && file_exists('public/upload/devicefeature/custom/' . $cus->fieldimage)) {
                $cus->fieldimage = URL::to('public/upload/devicefeature/custom/' . $cus->fieldimage);
            } else {
                $cus->fieldimage = URL::to('public/upload/default.jpg');
            }
            $custom1[] = array(
                'name' => $cus->field_name,
                'value' => $cus->field_value,
                'check' => $cus->field_value == '' ? 'False' : ($cus->field_check == '' ? 'False' : $cus->field_check),
                'side' => $cus->fieldside == '' ? 'Left' : $cus->fieldside,
                'image' => $cus->fieldimage,
            );
        }

        $deviceFeatureImage = DeviceFeatureImage::first();

        $serial = SerialnumberDetail::where('deviceId', $row->id)
            ->where('clientId', $clientId)
            ->where('purchaseType', 'Bulk')
            ->where('status', '=', '')
            ->select('serialNumber', 'purchaseDate', 'expiryDate')
            ->get();

        if (!empty($row->device_image) && file_exists('public/upload/' . $row->device_image)) {
            $row->device_image = URL::to('public/upload/' . $row->device_image);
        } else {
            $row->device_image = URL::to('public/upload/default.jpg');
        }


        $performance = $row->performance;

        $feature1 = array(
            array(
                'name' => 'longevity',
                'value' => $row->longevity . ' Years',
                'check' => $row->longevity == '' ? 'False' : ($row->longevity_check == '' ? 'False' : $row->longevity_check),
                'side' => $row->longevity_side == '' ? 'Left' : $row->longevity_side,
                'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->longevityimage),
            ),
            array(
                'name' => 'shock',
                'value' => $shock,
                'check' => $shock == '' ? 'False' :($row->shock_check == '' ? 'False' : $row->shock_check),
                'side' => $row->shock_side == '' ? 'Left' : $row->shock_side,
                'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->shockimage),
            ),
            array(
                'name' => 'size',
                'value' => $size,
                'check' => $size == '' ? 'False' :($row->size_check == '' ? 'False' : $row->size_check),
                'side' => $row->size_side == '' ? 'Left' : $row->size_side,
                'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->sizeimage),
            ),
            array(
                'name' => 'research',
                'value' => $row->research,
                'check' => $row->research == '' ? 'False' :($row->research_check == '' ? 'False' : $row->research_check),
                'side' => $row->research_side == '' ? 'Left' : $row->research_side,
                'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->researchimage),
            ),
            array(
                'name' => 'website_page',
                'value' => $row->website_page,
                'check' => $row->url == '' ? "False" : "True",
                'side' => $row->websitepage_side == '' ? 'Left' : $row->websitepage_side,
                'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->websiteimage),
                'weburl' => $row->url,
            ),
            array(
                'name' => 'overall_value',
                'value' => $row->overall_value,
                'check' => $row->overall_value == '' ? 'False' :($row->overall_value_check == '' ? 'False' : $row->overall_value_check),
                'side' => $row->overall_value_side == '' ? 'Left' : $row->overall_value_side,
                'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->overallimage),
            ),
            array(
                'name' => 'performance',
                'value' => $row->performance,
                'check' => $performance == '' ? "False" : "True",
                'side' => 'Left',
                'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->performanceImage),
                'weburl' => $row->performance,
            ),
        );

        /**
         * Bulk Color Checking Start
         */

        $expirydate = SerialnumberDetail::where('deviceId', $row->id)
            ->where('clientId', $clientId)
            ->where('status', '=', '')
            ->where('purchaseType', 'Bulk')
            ->where('expiryDate', '>=', \Carbon\Carbon::now()->format('m-d-Y'))
            ->orderBy('expiryDate', 'ASC')
            ->first();


        $your_date = $expirydate['expiryDate'];
        $bulk_color = '#073F84';
        /**
         * Bulk Color Checking End
         */

        $first_device = array(
            'id' => $row->id,
            'device_name' => $row->device_name,
            'model_name' => $row->model_name,
            'device_image' => $row->device_image,
            'price' => $price,
            'price_delta' => $type == 'Unit' ? $row->unit_cost_delta_check : $row->system_cost_delta_check,
            'bulk' => $type == 'Unit' ? $row->bulk : $row->system_bulk,
            'bulk_check' => $type == 'Unit' ? $row->bulk_check : $row->system_bulk_check,
            'bulk_highlight' => 'False',
            'bulk_color' => $bulk_color,
            'cco' => $cco,
            'cco_check' => $cco == '' ? 'False' : 'True',
            'cco_delta' => $cco_delta,
            'repless' => $repless,
            'repless_check' => $repless == '' ? 'False' : 'True',
            'repless_delta' => $repless_delta,
            'feature' => array(
                array(
                    'name' => 'longevity',
                    'value' => $row->longevity . ' Years',
                    'check' => $row->longevity == '' ? 'False' :($row->longevity_check == '' ? 'False' : $row->longevity_check),
                    'side' => $row->longevity_side == '' ? 'Left' : $row->longevity_side,
                    'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->longevityimage),
                ),
                array(
                    'name' => 'shock',
                    'value' => $shock,
                    'check' => $shock == '' ? 'False' :($row->shock_check == '' ? 'False' : $row->shock_check),
                    'side' => $row->shock_side == '' ? 'Left' : $row->shock_side,
                    'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->shockimage),
                ),
                array(
                    'name' => 'size',
                    'value' => $size,
                    'check' => $size == '' ? 'False' :($row->size_check == '' ? 'False' : $row->size_check),
                    'side' => $row->size_side == '' ? 'Left' : $row->size_side,
                    'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->sizeimage),
                ),
                array(
                    'name' => 'research',
                    'value' => $row->research,
                    'check' => $row->research == '' ? 'False' :($row->research_check == '' ? 'False' : $row->research_check),
                    'side' => $row->research_side == '' ? 'Left' : $row->research_side,
                    'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->researchimage),
                ),
                array(
                    'name' => 'website_page',
                    'value' => $row->website_page,
                    'check' => $row->url == '' ? "False" : "True",
                    'side' => $row->websitepage_side == '' ? 'Left' : $row->websitepage_side,
                    'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->websiteimage),
                    'weburl' => $row->url,
                ),
                array(
                    'name' => 'overall_value',
                    'value' => $row->overall_value,
                    'check' => $row->overall_value == '' ? 'False' :($row->overall_value_check == '' ? 'False' : $row->overall_value_check),
                    'side' => $row->overall_value_side == '' ? 'Left' : $row->overall_value_side,
                    'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->overallimage),
                ),
                array(
                    'name' => 'performance',
                    'value' => $row->performance,
                    'check' => $performance == '' ? "False" : "True",
                    'side' => 'Left',
                    'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->performanceImage),
                    'weburl' => $row->performance,
                ),
            ),
            'research_email' => $row->research_email,
            'manufacturer_logo' => URL::to('public/upload/' . $row->manufacturer_logo),
            'manufacture_name' => $row->manufacturer->short_name,
            'custom' => $custom1,
            'serial' => $serial,
            'expire_date' => $your_date,
            'expire_range'=>array(
                array(
                    'day' => day1,
                    'color'=>color1
                ),
                array(
                    'day' => day2,
                    'color'=>color2
                ),
                array(
                    'day' => day3,
                    'color'=>color3
                ),
            )
        );
    }

    /**
     * Second Device
     */

    $second_device = array();
    $device_second = device::join('client_price', 'client_price.device_id', '=', 'device.id')
        ->leftjoin('device_features', 'device_features.device_id', '=', 'device.id')
        ->join('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
        ->where('client_price.client_name', '=', $clientId)
        ->where('device_features.client_name', '=', $clientId)
        ->select('device.*', 'client_price.client_name', 'client_price.device_id', 'client_price.unit_cost', 'client_price.unit_cost_check', 'client_price.bulk_unit_cost', 'client_price.bulk_unit_cost_check'
            , 'client_price.bulk', 'client_price.bulk_check', 'client_price.cco_discount', 'client_price.cco', 'client_price.cco_check', 'client_price.cco_discount_check', 'client_price.unit_rep_cost', 'client_price.unit_rep_cost_check', 'client_price.unit_repless_discount'
            , 'client_price.unit_repless_discount_check', 'client_price.system_cost', 'client_price.system_bulk', 'client_price.system_bulk_check', 'client_price.system_cost_check', 'client_price.bulk_system_cost', 'client_price.bulk_system_cost_check', 'client_price.system_repless_cost', 'client_price.system_repless_cost_check'
            , 'client_price.system_repless_discount', 'client_price.system_repless_discount_check', 'client_price.reimbursement', 'client_price.reimbursement_check', 'client_price.unit_cost_delta_check', 'client_price.cco_delta_check', 'client_price.cco_discount_delta_check', 'client_price.unit_repless_delta_check', 'client_price.unit_repless_discount_delta_check', 'client_price.system_cost_delta_check'
            , 'client_price.system_repless_delta_check', 'client_price.system_repless_discount_delta_check', 'client_price.reimbursement_delta_check', 'client_price.is_delete as clientprice_delete', 'device_features.longevity_check',
            'device_features.shock_check', 'device_features.size_check', 'device_features.research_check', 'device_features.siteinfo_check', 'device_features.overall_value_check', 'device_features.longevity_delta_check', 'device_features.shock_delta_check', 'device_features.size_delta_check', 'device_features.research_delta_check', 'device_features.site_info_delta_check', 'device_features.overall_value_delta_check', 'manufacturers.manufacturer_logo')
        ->where('device.category_name', '=', $categoryId)
        ->where('device.id', '=', $device2)
        ->where('device.is_delete', '=', 0)
        ->where('device.status', '=', 'Enabled');
    if ($type == 'Unit') {
        $device_second = $device_second->where('client_price.unit_cost_check', '=', 'True');
    } else if ($type == 'System') {
        $device_second = $device_second->where('client_price.system_cost_check', '=', 'True');
    }
    $device_second = $device_second->where('client_price.is_delete', '=', 0)
        ->get();

    foreach ($device_second as $row) {

        $maxserial = SerialnumberDetail::where('deviceId', $row->id)->where('clientId', $clientId)
            ->where('status', '=', '')
            ->where('purchaseType', 'Bulk')
            ->select('discount')
            ->max('discount');

        if ($maxserial > 0) {

            if ($type == 'Unit') {
                if ($row->bulk_check == 'True') {
                    $prices = $row->unit_cost - (($row->unit_cost * $maxserial) / 100);
                } else {
                    $prices = $row->unit_cost;
                }
            } else {
                if ($row->system_bulk_check == 'True') {
                    $prices = $row->system_cost - (($row->system_cost * $maxserial) / 100);
                } else {
                    $prices = $row->system_cost;
                }
            }
        } else {
            $prices = $type == 'Unit' ? $row->unit_cost : $row->system_cost;
        }

        $cco = '';
        $repless = '';
        $cco_delta = '';
        $repless_delta = '';

        if ($type == 'Unit') {

            if ($device2_cco == 'true') {

                if ($row->cco_discount_check == 'True') {

                    $cco = ($prices * $row->cco_discount) / 100;
                    $cco = $prices - $cco;
                    $cco_delta = $row->cco_discount_delta_check;
                } else if ($row->cco_check == 'True') {
                    $cco = $prices - $row->cco;
                    $cco_delta = $row->cco_delta_check;
                }

            }

            if ($device2_repless == "true") {

                if ($row->cco_discount_check == 'True') {

                    $cco = ($prices * $row->cco_discount) / 100;
                    $cco = $prices - $cco;
                    $cco_delta = $row->cco_discount_delta_check;
                } else if ($row->cco_check == 'True') {
                    $cco = $prices - $row->cco;
                    $cco_delta = $row->cco_delta_check;
                }

                if ($row->unit_repless_discount_check == 'True') {

                    $repless = (($cco == '' ? $price : $cco) * $row->unit_repless_discount) / 100;
                    $repless = ($cco == '' ? $price : $cco) - $repless;
                    $repless_delta = $row->unit_repless_discount_delta_check;
                } else if ($row->unit_rep_cost_check == 'True') {
                    $repless = ($cco == '' ? $price : $cco) - $row->unit_rep_cost;
                    $repless_delta = $row->unit_repless_delta_check;
                }

            }

        }

        if ($type == 'System') {

            if ($device2_repless == "true") {

                if ($row->system_repless_discount_check == 'True') {

                    $repless = ($prices * $row->system_repless_discount) / 100;
                    $repless = $prices - $repless;
                    $repless_delta = $row->system_repless_discount_delta_check;
                } else if ($row->system_repless_cost_check == 'True') {
                    $repless = $prices - $row->system_repless_cost;
                    $repless_delta = $row->system_repless_delta_check;
                }
            }
        }

        $shock = '';
        if ($row->shock != "") {
            $shock = explode('/', $row->shock);
            $shock1 = "" ? "0" : $shock[0];
            $shock2 = "" ? "0" : $shock[1];
            $shock = $shock1 . 'J/' . $shock2 . 's';
        }

        $size = '';
        if ($row->size != "") {
            $size = explode('/', $row->size);
            $size1 = "" ? "0" : $size[0];
            $size2 = "" ? "0" : $size[1];
            $size = $size1 . 'g/' . $size2 . 'cc';
        }

        $custom2 = array();
        $customs = device_custom_field::leftJoin('client_custom_field', 'client_custom_field.c_id', '=', 'device_custom_field.id')
            ->select('device_custom_field.id', 'device_custom_field.field_name', 'device_custom_field.field_value', 'client_custom_field.field_check', 'client_custom_field.fileld_highlight', 'device_custom_field.fileld_delta_check', 'device_custom_field.fieldside', 'device_custom_field.fieldimage')
            ->where('client_custom_field.device_id', $row->id)
            ->where('client_custom_field.client_name', '=', $clientId)
            ->get();

        foreach ($customs as $cus) {
            if (!empty($cus->fieldimage) && file_exists('public/upload/devicefeature/custom/' . $cus->fieldimage)) {
                $cus->fieldimage = URL::to('public/upload/devicefeature/custom/' . $cus->fieldimage);
            } else {
                $cus->fieldimage = URL::to('public/upload/default.jpg');
            }
            $custom2[] = array(
                'name' => $cus->field_name,
                'value' => $cus->field_value,
                'check' => $cus->field_value == '' ? 'False' : ($cus->field_check == '' ? 'False' : $cus->field_check),
                'side' => $cus->fieldside == '' ? 'Left' : $cus->fieldside,
                'image' => $cus->fieldimage,
            );
        }

        $deviceFeatureImage = DeviceFeatureImage::first();

        $serial = SerialnumberDetail::where('deviceId', $row->id)
            ->where('clientId', $clientId)
            ->where('purchaseType', 'Bulk')
            ->where('status', '=', '')
            ->select('serialNumber', 'purchaseDate', 'expiryDate')
            ->get();

        if (!empty($row->device_image) && file_exists('public/upload/' . $row->device_image)) {
            $row->device_image = URL::to('public/upload/' . $row->device_image);
        } else {
            $row->device_image = URL::to('public/upload/default.jpg');
        }

        $performance = $row->performance;

        $feature2 = array(
            array(
                'name' => 'longevity',
                'value' => $row->longevity . ' Years',
                'check' => $row->longevity == '' ? 'False' :($row->longevity_check == '' ? 'False' : $row->longevity_check),
                'side' => $row->longevity_side == '' ? 'Left' : $row->longevity_side,
                'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->longevityimage),
            ),
            array(
                'name' => 'shock',
                'value' => $shock,
                'check' => $shock == '' ? 'False' :($row->shock_check == '' ? 'False' : $row->shock_check),
                'side' => $row->shock_side == '' ? 'Left' : $row->shock_side,
                'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->shockimage),
            ),
            array(
                'name' => 'size',
                'value' => $size,
                'check' => $size == '' ? 'False' :($row->size_check == '' ? 'False' : $row->size_check),
                'side' => $row->size_side == '' ? 'Left' : $row->size_side,
                'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->sizeimage),
            ),
            array(
                'name' => 'research',
                'value' => $row->research,
                'check' => $row->research == '' ? 'False' :($row->research_check == '' ? 'False' : $row->research_check),
                'side' => $row->research_side == '' ? 'Left' : $row->research_side,
                'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->researchimage),
            ),
            array(
                'name' => 'website_page',
                'value' => $row->website_page,
                'check' => $row->url == '' ? "False" : "True",
                'side' => $row->websitepage_side == '' ? 'Left' : $row->websitepage_side,
                'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->websiteimage),
                'weburl' => $row->url,
            ),
            array(
                'name' => 'overall_value',
                'value' => $row->overall_value,
                'check' => $row->overall_value == '' ? 'False' :($row->overall_value_check == '' ? 'False' : $row->overall_value_check),
                'side' => $row->overall_value_side == '' ? 'Left' : $row->overall_value_side,
                'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->overallimage),
            ),
            array(
                'name' => 'performance',
                'value' => $row->performance,
                'check' => $performance == '' ? "False" : "True",
                'side' => 'Left',
                'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->performanceImage),
                'weburl' => $row->performance,
            ),
        );

        /**
         * Bulk Color Checking Start
         */

        $expirydates = SerialnumberDetail::where('deviceId', $row->id)
            ->where('clientId', $clientId)
            ->where('status', '=', '')
            ->where('purchaseType', 'Bulk')
            ->where('expiryDate', '>=', \Carbon\Carbon::now()->format('m-d-Y'))
            ->orderBy('expiryDate', 'ASC')
            ->first();


        $your_dates = $expirydates['expiryDate'];

        $bulk_color = '#073F84';

        /**
         * Bulk Color Checking End
         */

        $second_device = array(
            'id' => $row->id,
            'device_name' => $row->device_name,
            'model_name' => $row->model_name,
            'device_image' => $row->device_image,
            'price' => $prices,
            'price_delta' => $type == 'Unit' ? $row->unit_cost_delta_check : $row->system_cost_delta_check,
            'bulk' => $type == 'Unit' ? $row->bulk : $row->system_bulk,
            'bulk_check' => $type == 'Unit' ? $row->bulk_check : $row->system_bulk_check,
            'bulk_highlight' => 'False',
            'bulk_color' => $bulk_color,
            'cco' => $cco,
            'cco_check' => $cco == '' ? 'False' : 'True',
            'cco_delta' => $cco_delta,
            'repless' => $repless,
            'repless_check' => $repless == '' ? 'False' : 'True',
            'repless_delta' => $repless_delta,
            'feature' => array(
                array(
                    'name' => 'longevity',
                    'value' => $row->longevity . ' Years',
                    'check' => $row->longevity == '' ? 'False' :($row->longevity_check == '' ? 'False' : $row->longevity_check),
                    'side' => $row->longevity_side == '' ? 'Left' : $row->longevity_side,
                    'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->longevityimage),
                ),
                array(
                    'name' => 'shock',
                    'value' => $shock,
                    'check' => $shock == '' ? 'False' :($row->shock_check == '' ? 'False' : $row->shock_check),
                    'side' => $row->shock_side == '' ? 'Left' : $row->shock_side,
                    'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->shockimage),
                ),
                array(
                    'name' => 'size',
                    'value' => $size,
                    'check' => $size == '' ? 'False' :($row->size_check == '' ? 'False' : $row->size_check),
                    'side' => $row->size_side == '' ? 'Left' : $row->size_side,
                    'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->sizeimage),
                ),
                array(
                    'name' => 'research',
                    'value' => $row->research,
                    'check' => $row->research == '' ? 'False' :($row->research_check == '' ? 'False' : $row->research_check),
                    'side' => $row->research_side == '' ? 'Left' : $row->research_side,
                    'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->researchimage),
                ),
                array(
                    'name' => 'website_page',
                    'value' => $row->website_page,
                    'check' => $row->url == '' ? "False" : "True",
                    'side' => $row->websitepage_side == '' ? 'Left' : $row->websitepage_side,
                    'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->websiteimage),
                    'weburl' => $row->url,

                ),
                array(
                    'name' => 'overall_value',
                    'value' => $row->overall_value,
                    'check' => $row->overall_value == '' ? 'False' :($row->overall_value_check == '' ? 'False' : $row->overall_value_check),
                    'side' => $row->overall_value_side == '' ? 'Left' : $row->overall_value_side,
                    'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->overallimage),
                ),
                array(
                    'name' => 'performance',
                    'value' => $row->performance,
                    'check' => $performance == '' ? "False" : "True",
                    'side' => 'Left',
                    'image' => URL::to('public/upload/devicefeature/' . $deviceFeatureImage->performanceImage),
                    'weburl' => $row->performance,
                ),
            ),
            'performance' => $row->performance,
            'performance_image' => URL::to('public/upload/devicefeature/' . $row->performanceImage),
            'research_email' => $row->research_email,
            'manufacturer_logo' => URL::to('public/upload/' . $row->manufacturer_logo),
            'manufacture_name' => $row->manufacturer->short_name,
            'custom' => $custom2,
            'serial' => $serial,
            'expire_date' => $your_dates,
            'expire_range'=>array(
                array(
                    'day' => day1,
                    'color'=>color1
                ),
                array(
                    'day' => day2,
                    'color'=>color2
                ),
                array(
                    'day' => day3,
                    'color'=>color3
                ),
            )
        );
    }

    /**
     * Check Delta Value
     */

    $first_cost = $first_device['price'];
    $second_cost = $second_device['price'];
    $check_price = min($first_cost, $second_cost);

    $first_cost = $check_price == $first_cost ? 'True' : 'False';

    $delta_product_id = $first_cost == 'True' ? $first_device['id'] : $second_device['id'];
    $delta_product_name = $first_cost == 'True' ? $first_device['device_name'] : $second_device['device_name'];
    $delta_prodeuct_model = $first_cost == 'True' ? $first_device['model_name'] : $second_device['model_name'];
    $delta_product_image = $first_cost == 'True' ? $first_device['device_image'] : $second_device['device_image'];
    $delta_manufacture_image = $first_cost == 'True' ? $first_device['manufacturer_logo'] : $second_device['manufacturer_logo'];

    if ($first_cost == 'True') {
        $price_delta_check = "False";
        $cco_discount_delta_check = "False";
        $reimbursement_delta_check = "False";
        $repless_delta_check = "False";
        $longevity_delta_check = "False";
        $longevity_diff = "";
        $research_delta_check = "False";
        $site_info_delta_check = "False";
        $overall_value_delta_check = "False";

        $cco_diff = 0;
        $repless_diff = 0;

        $shock_diff = 0;
        $ct_diff = 0;

        $size_g_diff = 0;
        $size_cc_diff = 0;

        if ($second_device['price_delta'] == "True" && $first_device['price_delta'] == "True") {
            $price_delta_check = "True";
        }
        if ($second_device['cco_delta'] == "True" && $first_device['cco_delta'] == "True") {
            $cco_discount_delta_check = "True";
        }

        $cco_diff = $second_device['cco'] == '' ? 0 : $second_device['cco'] - $first_device['cco'] == '' ? 0 : $first_device['cco'];

        if ($second_device['repless_delta'] == "True" && $first_device['repless_delta'] == "True") {
            $repless_delta_check = "True";
        }

        $repless_diff = $second_device['repless'] == '' ? 0 : $second_device['repless'] - $first_device['repless'] == '' ? 0 : $first_device['repless'];

        $first_device_price = $first_device['price'];
        $second_device_price = $second_device['price'];

        if ($device1_cco == "true") {
            $first_device_price = $first_device['cco'];
        }

        if ($device1_repless == "true") {
            $first_device_price = $first_device['repless'];
        }

        if ($device2_cco == "true") {
            $second_device_price = $second_device['cco'];
        }

        if ($device2_repless == "true") {
            $second_device_price = $second_device['repless'];
        }


        $delta_price = $second_device_price - $first_device_price;

        if ($device_second[0]['research_check'] == "True" && $device_first[0]['research_check'] == "True") {
            if ($device_second[0]['research_delta_check'] == "True" && $device_first[0]['research_delta_check'] == "True") {
                $research_delta_check = "True";
            }
        }
        if ($device_second[0]['overall_value_check'] == "True" && $device_first[0]['overall_value_check'] == "True") {
            if ($device_second[0]['overall_value_delta_check'] == "True" && $device_first[0]['overall_value_delta_check'] == "True") {
                $overall_value_delta_check = "True";
            }
        }

        if ($device_second[0]['longevity_check'] == "True" && $device_first[0]['longevity_check'] == "True") {
            if ($device_second[0]['longevity_delta_check'] == "True" && $device_first[0]['longevity_delta_check'] == "True") {
                $longevity_delta_check = "True";
                $longevity_diff = $device_second[0]['longevity'] - $device_first[0]['longevity'];
            }
        }
        $shock_ct = "False";
        if ($device_second[0]['shock_check'] == "True" && $device_first[0]['shock_check'] == "True") {
            if ($device_second[0]['shock'] != "" && $device_first[0]['shock'] != "") {

                $shock_ct_f_product = explode('/', $device_first[0]['shock']);
                $shock_ct_s_product = explode('/', $device_second[0]['shock']);
                $shock_f_product = $shock_ct_f_product[0];
                $ct_f_product = $shock_ct_f_product[1];
                $shock_s_product = $shock_ct_s_product[0];
                $ct_s_product = $shock_ct_s_product[1];
                $shock_diff = $shock_f_product - $shock_s_product;
                $ct_diff = $ct_f_product - $ct_s_product;
                $shock_ct = "True";

                if ($device_second[0]['shock_delta_check'] != "True" || $device_first[0]['shock_delta_check'] != "True") {
                    $shock_ct = "False";
                }
            }
        }
        $size_delta = "False";
        if ($device_second[0]['shock_check'] == "True" && $device_first[0]['shock_check'] == "True") {
            if ($device_second[0]['size'] != "" && $device_first[0]['size'] != "") {

                $size_f_product = explode('/', $device_first[0]['size']);
                $size_s_product = explode('/', $device_second[0]['size']);
                $size_g_f_product = $size_f_product[0];
                $size_cc_f_product = $size_f_product[1];
                $size_g_s_product = $size_s_product[0];
                $size_cc_s_product = $size_s_product[1];
                $size_g_diff = $size_g_f_product - $size_g_s_product;
                $size_cc_diff = $size_cc_f_product - $size_cc_s_product;

                $size_delta = 'True';
                if ($device_second[0]['size_delta_check'] != "True" || $device_first[0]['size_delta_check'] != "True") {
                    $size_delta = "False";
                }
            }
        }

    } else {
        $price_delta_check = "False";
        $cco_discount_delta_check = "False";
        $reimbursement_delta_check = "False";
        $repless_delta_check = "False";
        $longevity_delta_check = "False";
        $longevity_diff = "";
        $research_delta_check = "False";
        $site_info_delta_check = "False";
        $overall_value_delta_check = "False";

        $cco_diff = 0;
        $repless_diff = 0;

        $shock_diff = 0;
        $ct_diff = 0;

        $size_g_diff = 0;
        $size_cc_diff = 0;

        if ($second_device['price_delta'] == "True" && $first_device['price_delta'] == "True") {
            $price_delta_check = "True";
        }
        if ($second_device['cco_delta'] == "True" && $first_device['cco_delta'] == "True") {
            $cco_discount_delta_check = "True";
        }

        $cco_diff = $second_device['cco'] == '' ? 0 : $first_device['cco'] - $second_device['cco'] == '' ? 0 : $second_device['cco'];

        if ($second_device['repless_delta'] == "True" && $first_device['repless_delta'] == "True") {
            $repless_delta_check = "True";
        }

        $repless_diff = $second_device['repless'] == '' ? 0 : $first_device['repless'] - $second_device['repless'] == '' ? 0 : $second_device['repless'];

        $first_device_price = $first_device['price'];
        $second_device_price = $second_device['price'];

        if ($device1_cco == "true") {
            $first_device_price = $first_device['cco'];
        }

        if ($device1_repless == "true") {
            $first_device_price = $first_device['repless'];
        }

        if ($device2_cco == "true") {
            $second_device_price = $second_device['cco'];
        }

        if ($device2_repless == "true") {
            $second_device_price = $second_device['repless'];
        }


        $delta_price = $first_device_price - $second_device_price;

        if ($device_second[0]['research_check'] == "True" && $device_first[0]['research_check'] == "True") {
            if ($device_second[0]['research_delta_check'] == "True" && $device_first[0]['research_delta_check'] == "True") {
                $research_delta_check = "True";
            }
        }
        if ($device_second[0]['overall_value_check'] == "True" && $device_first[0]['overall_value_check'] == "True") {
            if ($device_second[0]['overall_value_delta_check'] == "True" && $device_first[0]['overall_value_delta_check'] == "True") {
                $overall_value_delta_check = "True";
            }
        }

        if ($device_second[0]['longevity_check'] == "True" && $device_first[0]['longevity_check'] == "True") {
            if ($device_second[0]['longevity_delta_check'] == "True" && $device_first[0]['longevity_delta_check'] == "True") {
                $longevity_delta_check = "True";
                $longevity_diff = $device_second[0]['longevity'] - $device_first[0]['longevity'];
            }
        }
        $shock_ct = "False";
        if ($device_second[0]['shock_check'] == "True" && $device_first[0]['shock_check'] == "True") {
            if ($device_second[0]['shock'] != "" && $device_first[0]['shock'] != "") {

                $shock_ct_f_product = explode('/', $device_first[0]['shock']);
                $shock_ct_s_product = explode('/', $device_second[0]['shock']);
                $shock_f_product = $shock_ct_f_product[0];
                $ct_f_product = $shock_ct_f_product[1];
                $shock_s_product = $shock_ct_s_product[0];
                $ct_s_product = $shock_ct_s_product[1];
                $shock_diff = $shock_f_product - $shock_s_product;
                $ct_diff = $ct_f_product - $ct_s_product;
                $shock_ct = "True";

                if ($device_second[0]['shock_delta_check'] != "True" || $device_first[0]['shock_delta_check'] != "True") {
                    $shock_ct = "False";
                }
            }
        }
        $size_delta = "False";
        if ($device_second[0]['shock_check'] == "True" && $device_first[0]['shock_check'] == "True") {
            if ($device_second[0]['size'] != "" && $device_first[0]['size'] != "") {

                $size_f_product = explode('/', $device_first[0]['size']);
                $size_s_product = explode('/', $device_second[0]['size']);
                $size_g_f_product = $size_f_product[0];
                $size_cc_f_product = $size_f_product[1];
                $size_g_s_product = $size_s_product[0];
                $size_cc_s_product = $size_s_product[1];
                $size_g_diff = $size_g_f_product - $size_g_s_product;
                $size_cc_diff = $size_cc_f_product - $size_cc_s_product;

                $size_delta = 'True';
                if ($device_second[0]['size_delta_check'] != "True" || $device_first[0]['size_delta_check'] != "True") {
                    $size_delta = "False";
                }
            }
        }

    }

    $deltadevice = array(
        'id' => $delta_product_id,
        'device_name' => $delta_product_name,
        'device_image' => $delta_product_image,
        'model_name' => $delta_prodeuct_model,
        'price' => $delta_price,
        'price_delta' => $price_delta_check,
        'cco' => $cco_diff,
        'cco_delta' => $cco_discount_delta_check,
        'repless' => $repless_diff,
        'repless_delta' => $repless_delta_check,
        'research' => $first_cost == 'True' ? $device_first[0]['research'] :$device_second[0]['research'] ,
        'reserach_delta' => $research_delta_check,
        'overall_value' => $first_cost == 'True' ? $device_first[0]['overall_value'] : $device_second[0]['overall_value'],
        'overall_value_delta' => $overall_value_delta_check,
        'longevity' => $longevity_diff . ' Years',
        'longevity_delta' => $longevity_delta_check,
        'shock' => $shock_diff . 'J/' . $ct_diff . 's',
        'shock_delta' => $shock_ct,
        'size' => $size_g_diff . 'g/' . $size_cc_diff . 'cc',
        'size_delta' => $size_delta,
        'manufacturer_logo' => $delta_manufacture_image,
        'custom' => customcompare($custom1, $custom2, $second_device['id'], $first_device['id'], $clientId, 'first'),
    );

    /**
     * Compare Custom
     */
    $first_device['customcompare'] = customcompare($custom1, $custom2, $second_device['id'], $first_device['id'], $clientId, 'first');
    $second_device['customcompare'] = customcompare($custom1, $custom2, $second_device['id'], $first_device['id'], $clientId, 'second');

    /**
     * Compare Custom not
     */
    $first_device['custom'] = customnotcompare($custom1, $custom2, $second_device['id'], $first_device['id'], $clientId, 'first');
    $second_device['custom'] = customnotcompare($custom1, $custom2, $second_device['id'], $first_device['id'], $clientId, 'second');


    $project = userProjects::where('userId', $user['id'])->value('projectId');
    $organization = array($clientId);

    if ($type == 'Unit') {

        $category = categoryAppvalue($organization, $categoryId, $project, Current_Year, '');
    } else if ($type == "System") {

        $category = systemappvalue($organization, $categoryId, '', Current_Year, $project);
    }

    $compare_device = array(
        'first_device' => $first_device,
        'second_device' => $second_device,
        'delta' => $deltadevice,
        'categoryAPP' => $category,
    );

    return $compare_device;
}

function customcompare($custom1, $custom2, $seconddevice, $firstdevice, $clientId, $side)
{
    $f_custom_f = array();
    $s_custom_f = array();

    foreach ($custom2 as $s_custom) {

        $s_custom_f[] = $s_custom['name'];

    }
    foreach ($custom1 as $f_custom) {

        $f_custom_f[] = $f_custom['name'];
    }

    $result = array_intersect($f_custom_f, $s_custom_f);

    $custom_fields_data2 = device_custom_field::leftJoin('client_custom_field', 'client_custom_field.c_id', '=', 'device_custom_field.id')
        ->select('device_custom_field.id', 'device_custom_field.field_name', 'device_custom_field.field_value', 'client_custom_field.field_check', 'client_custom_field.fileld_highlight', 'device_custom_field.fileld_delta_check', 'device_custom_field.fieldside', 'device_custom_field.fieldimage')
        ->where('client_custom_field.device_id', '=', $seconddevice)
        ->whereIn('device_custom_field.field_name', $result)
        ->where('client_custom_field.client_name', '=', $clientId)
        ->get();
    foreach ($custom_fields_data2 as $cus) {
        if (!empty($cus->fieldimage) && file_exists('public/upload/devicefeature/custom/' . $cus->fieldimage)) {
            $cus->fieldimage = URL::to('public/upload/devicefeature/custom/' . $cus->fieldimage);
        } else {
            $cus->fieldimage = URL::to('public/upload/default.jpg');
        }
    }

    $custom_fields_data1 = device_custom_field::leftJoin('client_custom_field', 'client_custom_field.c_id', '=', 'device_custom_field.id')
        ->select('device_custom_field.id', 'device_custom_field.field_name', 'device_custom_field.field_value', 'client_custom_field.field_check', 'client_custom_field.fileld_highlight', 'device_custom_field.fileld_delta_check', 'device_custom_field.fieldside', 'device_custom_field.fieldimage')
        ->where('client_custom_field.device_id', '=', $firstdevice)
        ->whereIn('device_custom_field.field_name', $result)
        ->where('client_custom_field.client_name', '=', $clientId)
        ->get();

    foreach ($custom_fields_data1 as $cus1) {
        if (!empty($cus1->fieldimage) && file_exists('public/upload/devicefeature/custom/' . $cus1->fieldimage)) {
            $cus1->fieldimage = URL::to('public/upload/devicefeature/custom/' . $cus1->fieldimage);
        } else {
            $cus1->fieldimage = URL::to('public/upload/default.jpg');
        }
    }

    $data2 = array();
    foreach ($custom_fields_data2 as $key2) {
        $data2[$key2->field_name] = array(
            'name' => $key2->field_name,
            'value' => $key2->field_value,
            'check' => $key2->field_value == '' ? 'False' : ($key2->field_check == '' ? 'False' : $key2->field_check),
            'side' => $key2->fieldside == '' ? 'Left' : $key2->fieldside,
            'image' => $key2->fieldimage,
            'delta' => $key2->fileld_delta_check == 'False' ? 'False' : 'True',
        );
    }

    $data1 = array();
    foreach ($custom_fields_data1 as $key1) {
        $data1[$key1->field_name] = array(
            'name' => $key1->field_name,
            'value' => $key1->field_value,
            'check' => $key1->field_value == '' ? 'False' : ($key1->field_check == '' ? 'False' : $key1->field_check),
            'side' => $key1->fieldside == '' ? 'Left' : $key1->fieldside,
            'image' => $key1->fieldimage,
            'delta' => $key1->fileld_delta_check == 'False' ? 'False' : 'True',
        );
    }
    $custom_diff1 = array();
    $custom_diff2 = array();

    if (count($data2) > 0 && count($data1) > 0) {

        foreach ($data1 as $key => $value) {

            if (array_key_exists($key, $data2)) {
                $difference = $data1[$key];

                if (is_numeric($data1[$key]) && is_numeric($data2[$key])) {
                    $difference = $data1[$key] - $data2[$key];
                }

            }
            $custom_diff1[] = $difference;
        }

    }
    if (count($data2) > 0 && count($data1) > 0) {

        foreach ($data2 as $key => $value) {

            if (array_key_exists($key, $data1)) {
                $difference = $data2[$key];

                if (is_numeric($data2[$key]) && is_numeric($data1[$key])) {
                    $difference = $data2[$key] - $data1[$key];
                }

            }
            $custom_diff2[] = $difference;
        }

    }

    if ($side == 'first') {
        return $custom_diff1;
    } else {
        return $custom_diff2;
    }

}

function customnotcompare($custom1, $custom2, $seconddevice, $firstdevice, $clientId, $side)
{
    $f_custom_f = array();
    $s_custom_f = array();

    foreach ($custom2 as $s_custom) {

        $s_custom_f[] = $s_custom['name'];

    }
    foreach ($custom1 as $f_custom) {

        $f_custom_f[] = $f_custom['name'];
    }

    $result = array_intersect($f_custom_f, $s_custom_f);

    $custom_fields_data2 = device_custom_field::leftJoin('client_custom_field', 'client_custom_field.c_id', '=', 'device_custom_field.id')
        ->select('device_custom_field.id', 'device_custom_field.field_name', 'device_custom_field.field_value', 'client_custom_field.field_check', 'client_custom_field.fileld_highlight', 'device_custom_field.fileld_delta_check', 'device_custom_field.fieldside', 'device_custom_field.fieldimage')
        ->where('client_custom_field.device_id', '=', $seconddevice)
        ->whereNotIn('device_custom_field.field_name', $result)
        ->where('client_custom_field.client_name', '=', $clientId)
//        ->where('client_custom_field.field_check', '=', 'True')
        //        ->where('client_custom_field.fileld_delta_check', '=', 'True')
        ->get();
    foreach ($custom_fields_data2 as $cus) {
        if (!empty($cus->fieldimage) && file_exists('public/upload/devicefeature/custom/' . $cus->fieldimage)) {
            $cus->fieldimage = URL::to('public/upload/devicefeature/custom/' . $cus->fieldimage);
        } else {
            $cus->fieldimage = URL::to('public/upload/default.jpg');
        }
    }

    $custom_fields_data1 = device_custom_field::leftJoin('client_custom_field', 'client_custom_field.c_id', '=', 'device_custom_field.id')
        ->select('device_custom_field.id', 'device_custom_field.field_name', 'device_custom_field.field_value', 'client_custom_field.field_check', 'client_custom_field.fileld_highlight', 'device_custom_field.fileld_delta_check', 'device_custom_field.fieldside', 'device_custom_field.fieldimage')
        ->where('client_custom_field.device_id', '=', $firstdevice)
        ->whereNotIn('device_custom_field.field_name', $result)
        ->where('client_custom_field.client_name', '=', $clientId)
//        ->where('client_custom_field.field_check', '=', 'True')
        //        ->where('client_custom_field.fileld_delta_check', '=', 'True')
        ->get();

    foreach ($custom_fields_data1 as $cus1) {
        if (!empty($cus1->fieldimage) && file_exists('public/upload/devicefeature/custom/' . $cus1->fieldimage)) {
            $cus1->fieldimage = URL::to('public/upload/devicefeature/custom/' . $cus1->fieldimage);
        } else {
            $cus1->fieldimage = URL::to('public/upload/default.jpg');
        }
    }

    $data2 = array();
    foreach ($custom_fields_data2 as $key2) {
        $data2[] = array(
            'name' => $key2->field_name,
            'value' => $key2->field_value,
            'check' => $key2->field_value == '' ? 'False' : ($key2->field_check == '' ? 'False' : $key2->field_check),
            'side' => $key2->fieldside == '' ? 'Left' : $key2->fieldside,
            'image' => $key2->fieldimage,
        );
    }

    $data1 = array();
    foreach ($custom_fields_data1 as $key1) {
        $data1[] = array(
            'name' => $key1->field_name,
            'value' => $key1->field_value,
            'check' => $key1->field_value == '' ? 'False' : ($key1->field_check == '' ? 'False' : $key1->field_check),
            'side' => $key1->fieldside == '' ? 'Left' : $key1->fieldside,
            'image' => $key1->fieldimage,
        );
    }
    $custom_diff1 = array();
    $custom_diff2 = array();

    $datas1 = array();
    $datas2 = array();
    if ($side == 'first') {
        foreach ($data2 as $rows1) {
            $datas2[] = array(
                'name' => $rows1['name'],
                'value' => '',
                'check' => 'False',
                'side' => $rows1['side'],
                'image' => $rows1['image'],
            );
        }

        $custom_diff1 = array_merge($data1, $datas2);
        return $custom_diff1;
    } else {

        foreach ($data1 as $rows) {
            $datas1[] = array(
                'name' => $rows['name'],
                'value' => '',
                'check' => 'False',
                'side' => $rows['side'],
                'image' => $rows['image'],
            );
        }
        $custom_diff2 = array_merge($datas1, $data2);
        return $custom_diff2;
    }

}
