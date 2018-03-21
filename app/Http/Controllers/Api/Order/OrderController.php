<?php

namespace App\Http\Controllers\Api\Order;

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


class OrderController extends Controller
{
    /**
     * Get Order Details
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request){

        $rules = [
            'client_id' => 'required',
            'category_id' => 'required',
            'type' => 'required',
            'device_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json(['data' => $validator->errors(), 'status' => 0], 406);
        }

            $client_id = $request->get('client_id');
            $device_id = $request->get('device_id');
            $category_id = $request->get('category_id');
            $type = $request->get('type');

            $data = getorder($client_id,$category_id,$device_id,$type);

        if(count($data) <= 0){
            return response()->json(['status' => 0, 'msg' => 'Device is not found', 'data' => []], 400);
        }

        return response()->json(['status'=>1,'msg'=>'Device Listing Sucessfully','data'=>$data ],200);

    }

    /**
     * Confirm Order Api
     * @param Request $request
     */
    public function ConfirmOrder(Request $request){

        $rules = [
            'client_id' => 'required',
            'device_id' => 'required',
            'type' => 'required',
//            'patient' => 'required',
//            'schedule_date' => 'required',
//            'schedule_time' => 'required',
//            'survey_answer' => 'required',
            'bulk' => 'required',
            'research_email' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json(['data' => $validator->errors(), 'status' => 0], 406);
        }

        $client_id = $request->get('client_id');
        $device_id = $request->get('device_id');
        $type = $request->get('type');
//        $patient = $request->get('patient');
//        $date = $request->get('schedule_date');
//        $time = $request->get('schedule_time');

        $device_cco = $request->get('device_cco');
        $device_repless = $request->get('device_repless');
        $survey = $request->get('survey_answer');
        $bulk = $request->get('bulk');
        $researchMail = $request->get('research_email');

        $user =JWTAuth::toUser($request->token);


        $data = confirmOrder($client_id,'',$device_id,$type,'','',$survey,$bulk,$user,$researchMail,$device_cco,$device_repless);

        if(count($data) <= 0){
            return response()->json(['status' => 0, 'msg' => 'Something Went Wrong.', 'data' => []], 406);
        }

        return response()->json(['status'=>1,'msg'=>'Order Placed Sucessfully','data'=>$data ],202);

    }
}
