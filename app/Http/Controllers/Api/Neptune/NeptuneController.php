<?php

namespace App\Http\Controllers\Api\Neptune;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Dingo\Api\Routing\Helpers;
use App\userClients;
use JWTAuth;
use Validator;
use Auth;
use Log;
use URL;
use Session;
use Cookie;
use DB;

class NeptuneController extends Controller
{
    /**
     * Neptune Calculation APi
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {

        $rules = [
            'client_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json(['data' => $validator->errors(), 'status' => 0], 406);
        }

        $users = JWTAuth::toUser($request->token);

        $clientId = $request->get('client_id');

        $user = GetuserLogin($users->id, $clientId);

        $userDetails = userwisedata($users->id, array($clientId),'');

        $client = GetclientLogin($users->id, array($clientId),'');

        $device = GetDeviceData($users->id, array($clientId));

        $data = array(
            'user' => $user,
            'client' => $client,
            'device' => $device,
            'client_user' => $userDetails,
        );

        return response()->json(['status' => 1, 'msg' => 'Data Get Sucessfully', 'data' => $data], 200);

    }

    /**
     * Marketshare Calculation Api
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function marketshare(Request $request)
    {
        $rules = [
            'client_id' => 'required',
            'month' => 'required',
            'year' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json(['data' => $validator->errors(), 'status' => 0], 406);
        }

        $clientId = $request->get('client_id');
        $month = $request->get('month');
        $year = $request->get('year');

        $users = JWTAuth::toUser($request->token);

        $organization = array($clientId);

        $datavalue = getdata($month, $year, $users->email, $organization);

        $newData = array();
        foreach ($datavalue as $key => $value) {
            foreach ($value as $tem) {
                $newData[] = $tem;
            }
        }

        $marketShare = manufacture($newData);

        $project = array();

        $datas = clientData($month, $year, $users->email, $organization,$project);

        $client_marketshares = client_marketshare($datas);

        $Final_client_marketshare = $client_marketshares['marketshare'];

        /**
         * Year Wise Data For User And Client Start
         */

        /**
         * User Yearly Marketshare
         */
        $datavalue_year = getdata('', $year, $users->email, $organization);

        $newData_year = array();
        foreach ($datavalue_year as $key_year => $value_year) {
            foreach ($value_year as $tem_year) {
                $newData_year[] = $tem_year;
            }
        }

        $marketShare_year = manufacture($newData_year);

        /**
         * Client Yearly MarketShare
         */

        $datas_year = clientData('', $year, $users->email, $organization,$project);

        $client_marketshares_year = client_marketshare($datas_year);

        $Final_client_marketshare_year = $client_marketshares_year['marketshare'];

        /**
         * Year Wise Data For User And Client End
         */

        $userclient = userClients::leftjoin('users', 'users.id', '=', 'user_clients.userId')
            ->where('user_clients.clientId', $clientId)
            ->where('users.roll', 3)
            ->select('users.*')
            ->get();

        $user_marketshare = array();

        foreach ($userclient as $row) {

            $datavalue = getdata($month, $year, $row->email, $organization);

            $newData = array();
            foreach ($datavalue as $key => $value) {
                foreach ($value as $tem) {
                    $newData[] = $tem;
                }
            }

            $marketShares = manufacture($newData);

            $user_marketshare[] = array(
                'marketshare' => $marketShares,
                'user' => $row->name
            );

        }

        $data = array(
            'user_marketshare' => $marketShare,
            'client_marketshare' => $Final_client_marketshare,
            'client_users_marketshare' => $user_marketshare,
            'user_yearly_marketshare' => $marketShare_year,
            'client_yearly_marketshare' => $Final_client_marketshare_year,
        );

        return response()->json(['status' => 1, 'msg' => 'Marketshare Get Sucessfully', 'data' => $data], 200);

    }

    public function saving(Request $request)
    {

    }

}
