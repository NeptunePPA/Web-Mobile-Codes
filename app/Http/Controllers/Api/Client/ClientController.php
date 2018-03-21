<?php

namespace App\Http\Controllers\Api\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Dingo\Api\Routing\Helpers;
use App\User;
use App\clients;
use App\userClients;
use JWTAuth;
use Validator;
use Auth;
use Log;
use URL;
use Session;
use Cookie;
use DB;


class ClientController extends Controller
{
    /**
     * Client Data Get Api
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request){

            $user =JWTAuth::toUser($request->token);

            $clients =  userClients::leftJoin('clients','clients.id','=','user_clients.clientId')
                ->where('user_clients.userId','=',$user->id)
                ->where('clients.is_active',1)
                ->select('user_clients.clientId as id','clients.item_no','clients.client_name','clients.image')
                ->get();
            foreach ($clients as $row){
                $row->image = URL::to('public/'.$row->image);
            }

            if(count($clients) <= 0){
                return response()->json(['status' => 0, 'msg' => 'Clients is not found', 'data' => []], 400);
            }

            if(count($clients) > 0){
                return response()->json(['status'=>1,'msg'=>'Clients Data Sucessfully','data'=>$clients ],200);
            }

    }

    public function getclient(Request $request){

        $rules = [
            'client_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json(['data' => $validator->errors(), 'status' => 0], 406);
        }

        $data['clients'] = $request['client_id'];

        $client = clients::where('id',$request['client_id'])->where('is_active',1)->first();

        if(empty($client)){
            return response()->json(['status' => 0, 'msg' => 'Client is not found', 'data' => []], 400);
        }

        $user =JWTAuth::toUser($request->token);

        $details = $data;

        Session()->put('details', $details);

        $data['clientImage'] = URL::to('public/'.clients::where('id',$request['client_id'])->value('image'));
        $data['userName'] = $user->name;

        return response()->json(['status'=>1,'msg'=>'Client Selected Sucessfully','data'=>$data ],200);

    }
}
