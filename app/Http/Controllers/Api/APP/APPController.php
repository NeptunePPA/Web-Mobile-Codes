<?php

namespace App\Http\Controllers\Api\APP;

use App\Http\Controllers\Controller;
use App\Import_app;
use App\userProjects;
use Illuminate\Http\Request;
use JWTAuth;
use Validator;

class APPController extends Controller {

	public function index(Request $request) {
		$rules = [
			'client_id' => 'required',
			'category_id' => 'required',
			'type' => 'required',
			'level' => 'required',
			'year' => 'required',
		];

		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {

			return response()->json(['data' => $validator->errors(), 'status' => 0], 406);
		}

		$client_id = $request->get('client_id');
		$category_id = $request->get('category_id');
		$type = $request->get('type');
		$level = $request->get('level');
		$year = $request->get('year');
		$organization = array($client_id);

		$user = JWTAuth::toUser($request->token);

		$project = userProjects::where('userId', $user['id'])->value('projectId');

		$checkdata = Import_app::where('category_name', $category_id)
			->where('client_name', $client_id)
			->where('device_level', $level)
			->where('project_name', $project)
			->first();

		if (count($checkdata) > 0) {

			$category = basecategoryAPP($checkdata, $type);
			$manufacture = basemanufactureAPP($category, $checkdata);
			$physician = basephysicianAPP($category, $checkdata, '');

		} else {

			if ($type == 'Unit') {
				$category = categoryAppvalue($organization, $category_id, $project, $year, $level . ' Level');
				$manufacture = manufacture_App_value($organization, $category_id, $project, $year, $level . ' Level', $category);
				$physician = physician_app_value($organization, $category_id, $project, $year, $level . ' Level', $category);
			}
			if ($type == 'System') {
				$category = systemappvalue($organization, $category_id, $level . ' Level', $year, $project);
				$physician = systemphysician($organization, $category_id, $category, $level . ' Level', $year, $project);
				$manufacture = systemmanufacture($organization, $category_id, $category, $level . ' Level', $year, $project);
			}
		}

		$data = array(
			array(
				'data_type' => 'category_app',
				'data_name' => 'Category APP',
				'data' => array($category),
			),
			array(
				'data_type' => 'manufacture_app',
				'data_name' => 'Manufacture APP',
				'data' => $manufacture,
			),
			array(
				'data_type' => 'physician_app',
				'data_name' => 'Physician APP',
				'data' => $physician,
			),

		);
		return response()->json(['data' => $data, 'message' => 'App Get Sucessfully', 'status' => 1], 200);

	}

	public function userapp(Request $request) {

		$rules = [
			'client_id' => 'required',
			'category_id' => 'required',
			'type' => 'required',
			'level' => 'required',
			'year' => 'required',
		];

		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {

			return response()->json(['data' => $validator->errors(), 'status' => 0], 406);
		}

		$client_id = $request->get('client_id');
		$category_id = $request->get('category_id');
		$type = $request->get('type');
		$level = $request->get('level');
		$year = $request->get('year');
		$organization = array($client_id);

		$user = JWTAuth::toUser($request->token);

		$project = userProjects::where('userId', $user['id'])->value('projectId');

		$checkdata = Import_app::where('category_name', $category_id)
			->where('client_name', $client_id)
			->where('device_level', $level)
			->where('project_name', $project)
			->first();
        $physician = array();
        $phymanufature = array();

		if (count($checkdata) > 0) {
			$category = basecategoryAPP($checkdata, $type);
			$physician = basephysicianAPP($category, $checkdata, $user->name);
			$phymanufature = array();

		} else {
			if ($type == 'Unit') {
				$category = categoryAppvalue($organization, $category_id, $project, $year, $level . ' Level');
				if(count($category) > 0){
                    $physician = physician_user_app_value($organization, $category_id, $project, $year, $level . ' Level', $category, $user);
                    $phymanufature = physician_user_manufacture_app_value($organization, $category_id, $project, $year, $level, $category, $user);
                }

			}
			if ($type == 'System') {
				$category = systemappvalue($organization, $category_id, $level . ' Level', $year, $project);
                if(count($category) > 0){
                    $physician = system_physician_user($organization, $category_id, $category, $level . ' Level', $year, $project, $user);
                    $phymanufature = array();
                }
			}
		}

		$data = array(
			array(
				'data_type' => 'category_app',
				'data_name' => 'Category APP',
				'data' => array($category),
			),
			array(
				'data_type' => 'physician_app',
				'data_name' => 'Physician APP',
				'data' => $physician,
			),
			array(
				'data_type' => 'physician_manufacture_app',
				'data_name' => 'Physician Manufacture APP',
				'data' => $phymanufature,
			),

		);
		return response()->json(['data' => $data, 'message' => 'App Get Sucessfully', 'status' => 1], 200);

	}

}
