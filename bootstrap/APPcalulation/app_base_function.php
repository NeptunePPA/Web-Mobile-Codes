<?php
/**
 * Created by PhpStorm.
 * User: Punit
 * Date: 2/23/2018
 * Time: 3:39 PM
 */

use App\Import_app;
use App\User;
Use App\userProjects;
use App\category;
use App\device;
use App\manufacturers;
use App\project;

function getphysician($categoryId)
{
    $getproject = category::where('id', $categoryId)->value('project_name');

    $user = User::leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
        ->where('user_projects.projectId', $getproject)
        ->where('users.roll', 3)
        ->select('users.name')
        ->get()
        ->toArray();

    $data = array();

    foreach ($user as $item) {
        $data[] = $item['name'];
    }

    return $data;
}

function getmanufacture($categoryId)
{
    $device = device::where('category_name', $categoryId)->groupBy('manufacturer_name')->get();

    $data = array();

    foreach ($device as $row) {
        $data[] = $row->manufacturer->manufacturer_name;
    }

    return $data;
}

function basecategoryApp($checkdata, $type)
{

    $getdevice = device_price(array($checkdata['client_name']), $checkdata['project_name'], '', $checkdata['category_name'], $type);

    $data = array(
        'totalprice' => '',
        'maxvalue' => $getdevice['maxvalue'],
        'minvalue' => $getdevice['minvalue'],
        'totaldevice' => '',
        'category_app_avg_value' => $checkdata['category_avg_app'],
    );

    return $data;
}

function basemanufactureAPP($category, $checkdata)
{


    $getmanufacture = getmanufacture($checkdata['category_name']);

    $data = array();

    foreach ($getmanufacture as $row) {
        $data[] = array(
            'maxvalue' => $category['maxvalue'],
            'minvalue' => $category['minvalue'],
            'category_app_avg_value' => $category['category_app_avg_value'],
            'avg_app_value' => $category['category_app_avg_value'],
            'name' => $row,
        );
    }

    return $data;
}

function basephysicianAPP($category, $checkdata, $name)
{

    $getphysician = getphysician($checkdata['category_name']);

    $data = array();

    foreach ($getphysician as $row) {
        if (!empty($name)) {
            if ($row == $name) {
                $data[] = array(
                    'maxvalue' => $category['maxvalue'],
                    'minvalue' => $category['minvalue'],
                    'category_app_avg_value' => $category['category_app_avg_value'],
                    'avg_app_value' => $category['category_app_avg_value'],
                    'name' => $row,
                    'physician_manufacture_app' => array(),
                );
            }

        } else {
            $data[] = array(
                'maxvalue' => $category['maxvalue'],
                'minvalue' => $category['minvalue'],
                'category_app_avg_value' => $category['category_app_avg_value'],
                'avg_app_value' => $category['category_app_avg_value'],
                'name' => $row,
                'physician_manufacture_app' => array(),
            );
        }
    }

    return $data;
}

function basecategoryApps($checkdata, $type)
{

    $getdevice = device_price(array($checkdata['client_name']), $checkdata['project_name'], '', $checkdata['category_name'], $type);

    $data = array(
        'totalprice' => '',
        'maxvalue' => $getdevice['maxvalue'],
        'minvalue' => $getdevice['minvalue'],
        'totaldevice' => '',
        'avgvalue' => $checkdata['category_avg_app'],
    );

    return $data;
}

function basemanufactureAPPs($category, $checkdata)
{


    $getmanufacture = getmanufacture($checkdata['category_name']);

    $data = array();

    foreach ($getmanufacture as $row) {
        $data[] = array(
            'avgvalue' => $category['avgvalue'],
            'manufacturer_name' => $row,
        );
    }

    return $data;
}

function basephysicianAPPs($category, $checkdata)
{

    $getphysician = getphysician($checkdata['category_name']);

    $data = array();

    foreach ($getphysician as $row) {

            $data[] = array(
                'maxvalue' => $category['maxvalue'],
                'minvalue' => $category['minvalue'],
                'avgvalue' => $category['avgvalue'],
                'avgvalue' => $category['avgvalue'],
                'physician_name' => $row,
            );

    }

    return $data;
}

function basephysicianAPPmanu($category, $checkdata)
{

    $getphysician = getphysician($checkdata['category_name']);

    $data = array();

    foreach ($getphysician as $row) {

        $data[$row][] = array(
            'avgvalue' => $category['avgvalue'],
            'physician_name' => $row,
            'manufacturer_name' => '',
        );

    }

    return $data;
}