<?php

namespace App\Http\Controllers\Api\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Dingo\Api\Routing\Helpers;
use App\User;
use App\userProjects;
use App\device;
use App\clients;
use App\userClients;
use App\category;
use App\Categorysort;
use JWTAuth;
use Validator;
use Auth;
use Log;
use URL;
use Session;
use Cookie;
use DB;

class CategoryController extends Controller
{
    /**
     * category Listing
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function index(Request $request){
        /*get selected clientdetails*/

        $rules = [
            'client_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json(['data' => $validator->errors(), 'status' => 0], 406);
        }

        $clients = $request['client_id'];

        $client = clients::where('id',$request['client_id'])->where('is_active',1)->first();

        if(empty($client)){
            return response()->json(['status' => 0, 'msg' => 'Client is not found', 'data' => []], 401);
        }
        $user =JWTAuth::toUser($request->token);

        $categories = user::join('user_projects','user_projects.userId','=','users.id')
            ->join('category','category.project_name','=','user_projects.projectId')
            ->join('device','device.category_name','=','category.id')
            ->join('client_price', 'client_price.device_id', '=', 'device.id')
            ->leftjoin('category_sort','category_sort.category_name','=','category.id')
            ->where('category_sort.client_name',$clients)
            ->where('client_price.client_name',$clients)
            ->where('device.is_delete', '=', 0)
            ->where('device.status', '=', 'Enabled')
            ->select('category.id','category.category_name','category.type','category.image')
            ->where('category.is_delete','=',0)
            ->where('users.id','=',$user->id)
            ->where(function ($query) {
                $query->where('client_price.unit_cost_check', '=', 'True')
                    ->orWhere('client_price.system_cost_check', '=', 'True');
            })
            ->where('client_price.is_delete', '=', 0)
            ->groupBy('category.id')
            ->orderBy('category_sort.sort_number','asc')
            ->get();

        foreach ($categories as $row){

            if (!empty($row->image) && file_exists('public/category/' . $row->image)) {
                $row->image = URL::to('public/category/' . $row->image);
            } else {
                $row->image = URL::to('public/upload/default.jpg');
            }
        }

        if(count($categories) <= 0){
            return response()->json(['status' => 0, 'msg' => 'Category is not found', 'data' => []], 400);
        }


        return response()->json(['status'=>1,'msg'=>'Category Listing Sucessfully','data'=>$categories ],200);
    }
}
