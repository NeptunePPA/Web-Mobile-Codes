<?php

namespace App\Http\Controllers\Api\Device;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use Validator;
use Auth;
use Log;
use URL;
use Session;
use Cookie;
use DB;
use App\userProjects;

class DeviceController extends Controller
{

    /**
     * Device List APi
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $rules = [
            'client_id' => 'required',
            'category_id' => 'required',
            'type' => 'required',
            'level' => 'required',
            'bulk' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json(['data' => $validator->errors(), 'status' => 0], 406);
        }

        $clientId = $request->get('client_id');
        $categoryId = $request->get('category_id');
        $type = $request->get('type');
        $level = $request->get('level');
        $bulk = $request->get('bulk');
        $organization = array($clientId);

        $manufacture = deviceList($clientId,$categoryId,$type,$level,$bulk);

        $user =JWTAuth::toUser($request->token);

        $project = userProjects::where('userId',$user['id'])->value('projectId');

        if($type == 'Unit'){
            $category = categoryAppvalue($organization,$categoryId,$project,Current_Year,$level . ' Level');
        } else if($type == "System") {
            $category = systemappvalue($organization,$categoryId,$level . ' Level',Current_Year,$project);
        }


        $data = array();

        $data = array(
            'manufacture' => $manufacture,
            'categoryAPP' =>$category,
        );

        if(count($manufacture) <= 0){
            return response()->json(['status' => 0, 'msg' => 'Device is not found', 'data' => []], 400);
        }

        return response()->json(['status'=>1,'msg'=>'Device Listing Sucessfully','data'=>$data ],200);
    }

    public function deviceCompare(Request $request){

        Log::debug($request->all());
        $rules = [
            'client_id' => 'required',
            'category_id' => 'required',
            'device1' => 'required',
            'type' => 'required',
            'device2' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json(['data' => $validator->errors(), 'status' => 0], 406);
        }

        $clientId = $request->get('client_id');
        $categoryId = $request->get('category_id');
        $type = $request->get('type');
        $device1 = $request->get('device1');
        $device2 = $request->get('device2');
        $device1_cco = $request->get('device1_cco');
        $device1_repless = $request->get('device1_repless');
        $device2_cco = $request->get('device2_cco');
        $device2_repless   = $request->get('device2_repless');

        $organization = array($clientId);

        $user =JWTAuth::toUser($request->token);



        $data = deviceCompare($clientId, $categoryId,$type,$device1,$device2,$user,$device1_cco,$device1_repless,$device2_cco,$device2_repless);

        if(count($data) <= 0){
            return response()->json(['status' => 0, 'msg' => 'Device is not found', 'data' => []], 400);
        }

        return response()->json(['status'=>1,'msg'=>'Compare Device Listing Sucessfully','data'=>$data ],200);
    }
}
