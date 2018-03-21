<?php

namespace App\Http\Controllers\Api\Saving;

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
use App\category;
use App\userProjects;
use App\User;

class SavingController extends Controller
{
    public function index(Request $request)
    {
        $rules = [
            'client_id' => 'required',
            'month' => 'required',
            'year' => 'required'
        ];
        Log::debug($request->all());

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json(['data' => $validator->errors(), 'status' => 0], 406);
        }

        $clientId = $request->get('client_id');

        $month = $request->get('month');

        $year = $request->get('year');

        $oldyear = $year - 1;

        $organization = array($clientId);

        $users = JWTAuth::toUser($request->token);

        $project = userProjects::where('userId', $users['id'])->value('projectId');

        /**
         * Perticular user Respective Month Wise Data Start
         */


        $userSavings = '';
        $totalsaving = 0;
        $user_saving = array();
        $client_monthly_Savings = array();

        $categoryData = category::where('project_name', $project)->where('is_active', 1)->get();


        for ($i = 1; $i <= 12; $i++) {

            $entrylevel_saving = array();
            $advacnedlevel_saving = array();
            $newadvacnedlevel_saving = array();
            $newentrylevel_saving = array();
            $clientscorecard_saving = array();

            $clientDelta_spend = 0;

            foreach ($categoryData as $row) {

                $entrylevel_saving[$row->id]['oldyearapp'] = Appcalculationoldyear($organization, 'Entry Level', $oldyear, $row->id, $users->email, array($project));
                $entrylevel_saving[$row->id]['newyearapp'] = appvlaueCurrentyear($organization, 'Entry Level', $year, $i, $row->id, $users->email, array($project));
                $advacnedlevel_saving[$row->id]['oldyearapp'] = Appcalculationoldyear($organization, 'Advanced Level', $oldyear, $row->id, $users->email, array($project));
                $advacnedlevel_saving[$row->id]['newyearapp'] = appvlaueCurrentyear($organization, 'Advanced Level', $year, $i, $row->id, $users->email, array($project));

                $newentrylevel_saving[$row->id][] = array_merge($entrylevel_saving[$row->id]['oldyearapp'], $entrylevel_saving[$row->id]['newyearapp']);
                $newadvacnedlevel_saving[$row->id][] = array_merge($advacnedlevel_saving[$row->id]['oldyearapp'], $advacnedlevel_saving[$row->id]['newyearapp']);

                $clientscorecard_saving[$row->id] = array_merge($newentrylevel_saving[$row->id], $newadvacnedlevel_saving[$row->id]);

            }

            $finalclients = array();
            $clientDelta_savings = 0;
            foreach ($clientscorecard_saving as $kwy => $vals) {
                foreach ($vals as $gd) {

                    $olddevice = $gd['oldavgvlaue'];
                    $utilization = $gd['totaldevice'];
                    $newdevice = $gd['currentavgvalue'];

                    if ($olddevice != 0 && $utilization != 0) {
                        $gd['oldSpend'] = $olddevice * $utilization;
                    } else {
                        $gd['oldSpend'] = 0;
                    }

                    if ($newdevice != 0 && $utilization != 0) {
                        $gd['newSpend'] = $newdevice * $utilization;
                    } else {
                        $gd['newSpend'] = 0;
                    }

                    $gd['delta'] = 0;
                    if ($gd['newSpend'] != 0) {
                        $gd['delta'] = $gd['newSpend'] - $gd['oldSpend'];
                    }

                    $clientDelta_savings = $clientDelta_savings + $gd['delta'];
                    $clientDelta_spend = $clientDelta_spend + $gd['newSpend'];

                }

            }

            $client_monthly_Savings[] = array(
                'total_spend' => $clientDelta_spend <= 0 ? 0 : $clientDelta_spend,
                'month_name' => getMonthName($i),
                'total_saving' => $clientDelta_savings <= 0 ? 0 : $clientDelta_savings,
            );

            $totalsaving = $totalsaving + $clientDelta_savings;

            if ($i == $month) {

                $user_saving['saving'] = round($clientDelta_savings, 0);
                $user_saving['totalspend'] = round($clientDelta_spend, 0);
            }

        }

        $client_saving = round($totalsaving, 0);
        Log::debug($client_saving);


        /**
         * Get Client Total Spend And Saving Start
         */

        $userSavings_client = 0;
        $userspends_client = 0;
        $client_monthly_Savings_client = array();
        $totalsaving_client = 0;
        for ($i = 1; $i <= 12; $i++) {

            $entrylevel_saving_client = array();
            $advacnedlevel_saving_client = array();
            $newadvacnedlevel_saving_client = array();
            $newentrylevel_saving_client = array();
            $clientscorecard_saving_client = array();

            $client_spend_wise = 0;

            foreach ($categoryData as $row) {

                $entrylevel_saving_client[$row->id]['oldyearapp'] = Appcalculationoldyear($organization, 'Entry Level', $oldyear, $row->id, '', array($project));
                $entrylevel_saving_client[$row->id]['newyearapp'] = appvlaueCurrentyear($organization, 'Entry Level', $year, $i, $row->id, '', array($project));
                $advacnedlevel_saving_client[$row->id]['oldyearapp'] = Appcalculationoldyear($organization, 'Advanced Level', $oldyear, $row->id, '', array($project));
                $advacnedlevel_saving_client[$row->id]['newyearapp'] = appvlaueCurrentyear($organization, 'Advanced Level', $year, $i, $row->id, '', array($project));

                $newentrylevel_saving_client[$row->id][] = array_merge($entrylevel_saving_client[$row->id]['oldyearapp'], $entrylevel_saving_client[$row->id]['newyearapp']);
                $newadvacnedlevel_saving_client[$row->id][] = array_merge($advacnedlevel_saving_client[$row->id]['oldyearapp'], $advacnedlevel_saving_client[$row->id]['newyearapp']);

                $clientscorecard_saving_client[$row->id] = array_merge($newentrylevel_saving_client[$row->id], $newadvacnedlevel_saving_client[$row->id]);

            }

            $finalclients = array();
            $client_saving_wises = 0;
            foreach ($clientscorecard_saving_client as $kwys => $values) {
                foreach ($values as $gds) {

                    $olddevice_client = $gds['oldavgvlaue'];
                    $utilization_client = $gds['totaldevice'];
                    $newdevice_client = $gds['currentavgvalue'];

                    if ($olddevice_client != 0 && $utilization_client != 0) {
                        $gds['oldSpend'] = $olddevice_client * $utilization_client;
                    } else {
                        $gds['oldSpend'] = 0;
                    }

                    if ($newdevice_client != 0 && $utilization_client != 0) {
                        $gds['newSpend'] = $newdevice_client * $utilization_client;
                    } else {
                        $gds['newSpend'] = 0;
                    }

                    $gds['delta'] = $gds['newSpend'] - $gds['oldSpend'];

                    $client_saving_wises = $client_saving_wises + $gds['delta'];
                    $client_spend_wise = $client_spend_wise + $gds['newSpend'];

                }

            }

            $client_monthly_Savings_client[] = array(
                'total_spend' => round($client_spend_wise,0),
                'month_name' => getMonthName($i),
                'total_saving' => round($client_saving_wises,0),
            );

            $totalsaving_client = $totalsaving_client + $client_saving_wises;

            if ($i == $month) {
                $userSavings_client = round($client_saving_wises, 0);
                $userspends_client = round($client_spend_wise, 0);
            }

        }

        $client_saving_wise = round($totalsaving_client, 0);

        Log::debug($client_saving_wise);

        /**
         * Get Client Total Spend And Saving End
         */

        $getuser = User::leftjoin('user_clients', 'user_clients.userId', '=', 'users.id')
            ->leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
            ->whereIn('user_clients.clientId', $organization)
            ->where('user_projects.projectId', $project)
            ->where('users.roll', 3)
            ->where('users.status', 'Enabled')
            ->select('users.*', 'user_projects.projectId', 'user_clients.clientId')
            ->get();

        $user_wise_data = array();
        foreach ($getuser as $use) {

            /**
             * Perticular user Respective Month Wise Data Start
             */

            $oldyear_saving_user = array();
            $newyear_saving_user = array();
            $final_saving_user = array();

            $oldyear_saving_user['oldyearapp'] = Appcalculationoldyear($organization, '', $oldyear, '', $use->email, array($project));
            $newyear_saving_user['newyearapp'] = appvlaueCurrentyear($organization, '', $year, $month, '', $use->email, array($project));
            $final_saving_user[] = array_merge($oldyear_saving_user['oldyearapp'], $newyear_saving_user['newyearapp']);

            $user_wise_saving = array();
//dump($final_saving_user);
            foreach ($final_saving_user as $row) {

                $old_device_saving_user = $row['oldavgvlaue'];
                $saving_utiliaze_device_user = $row['totaldevice'];
                $new_device_saving_user = $row['currentavgvalue'];

                if ($old_device_saving_user != 0 && $saving_utiliaze_device_user != 0) {
                    $user_wise_saving['oldSpend'] = $old_device_saving_user * $saving_utiliaze_device_user;
                } else {
                    $user_wise_saving['oldSpend'] = 0;
                }

                if ($new_device_saving_user != 0 && $saving_utiliaze_device_user != 0) {
                    $user_wise_saving['totalspend'] = $new_device_saving_user * $saving_utiliaze_device_user;
                } else {
                    $user_wise_saving['totalspend'] = 0;
                }

                $user_wise_saving['saving'] = 0;

                if ($user_wise_saving['totalspend'] != 0) {
                    $user_wise_saving['saving'] = $user_wise_saving['totalspend'] - $user_wise_saving['oldSpend'];
                }

            }

            /**
             * Perticular user Respective Month Wise Data End
             */

            /**
             * Perticular User Respective Year Wise Data Start
             */
            $oldyear_month_saving_user = array();
            $newyear_month_saving_user = array();
            $final_month_saving_user = array();

            for ($i = 1; $i <= 12; $i++) {

                $oldyear_month_saving_user[$i]['oldyearapp'] = Appcalculationoldyear($organization, '', $oldyear, '', $use->email, array($project));
                $newyear_month_saving_user[$i]['newyearapp'] = appvlaueCurrentyear($organization, '', $year, $i, '', $use->email, array($project));
                $final_month_saving_user[$i][] = array_merge($oldyear_month_saving_user[$i]['oldyearapp'], $newyear_month_saving_user[$i]['newyearapp']);
            }

            $final_device_saving_user = array();
            $client_saving_user = 0;
            $client_spend_user = 0;

            foreach ($final_month_saving_user as $savng => $saving_value_user) {
                foreach ($saving_value_user as $values_user) {

                    $old_device_saving_user = $values_user['oldavgvlaue'];
                    $saving_utiliaze_device_user = $values_user['totaldevice'];
                    $new_device_saving_user = $values_user['currentavgvalue'];

                    if ($old_device_saving_user != 0 && $saving_utiliaze_device_user != 0) {
                        $values_user['oldSpend'] = $old_device_saving_user * $saving_utiliaze_device_user;
                    } else {
                        $values_user['oldSpend'] = 0;
                    }

                    if ($new_device_saving_user != 0 && $saving_utiliaze_device_user != 0) {
                        $values_user['newSpend'] = $new_device_saving_user * $saving_utiliaze_device_user;
                    } else {
                        $values_user['newSpend'] = 0;
                    }

                    $values_user['delta'] = 0;


                    if ($values_user['newSpend'] != 0) {
                        $values_user['delta'] = $values_user['newSpend'] - $values_user['oldSpend'];
                    }
//                    dump($values_user['delta']);

                    $category_name = category::where('id', $savng)->value('category_name');

                    $final_device_saving_user[getMonthName($savng)][] = $values_user;
                    $client_saving_user = $client_saving_user + $values_user['delta'];
                    $client_spend_user = $client_spend_user + $values_user['newSpend'];

                }
            }

            /**
             * Perticular User Respective Year Wise Data End
             */

            $user_wise_data[$use->name] = array(
                'month_saving' => $user_wise_saving['saving'] <= 0 ? 0 : $user_wise_saving['saving'],
                'month_spend' => $user_wise_saving['totalspend'] <= 0 ? 0 : $user_wise_saving['totalspend'],
                'year_saving' => $client_saving_user <= 0 ? 0 : $client_saving_user,
                'year_spend' => $client_spend_user <= 0 ? 0 : $client_spend_user,
            );
        }

        $user_wise = array();
        foreach ($user_wise_data as $row => $key) {

            $user_wise[] = array(
                "month_saving" => $key['month_saving'],
                "month_spend" => $key['month_spend'],
                "year_saving" => $key['year_saving'],
                "year_spend" => $key['year_spend'],
                "doctor_name" => $row,
            );
        }

        /**
         * Get Saving Form User Wise array End
         */
        $data['user_data'] = array(
            'month_saving' => $user_saving['saving'],
            'month_spend' => $user_saving['totalspend'],
            'year_saving' => $client_saving,
        );

        $data['client_data'] = array(
            'month_saving' => $userSavings_client,
            'month_spend' => $userspends_client,
            'year_saving' => $client_saving_wise,
            'monthwise_report' => $client_monthly_Savings_client
        );

        $data['user_wise_saving'] = $user_wise;


        return response()->json(['data' => $data, 'message' => 'Saving Data Get Sucessfully', 'status' => 1], 200);
    }

    public function usersaving(Request $request)
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

        $oldyear = $year - 1;

        $organization = array($clientId);

        $users = JWTAuth::toUser($request->token);

        $project = userProjects::where('userId', $users['id'])->value('projectId');

        /**
         * User Saving Data
         */


        $userSavings = '';
        $totalsaving = 0;
        $user_saving = array();
        $client_monthly_Savings = array();

        $categoryData = category::where('project_name', $project)->where('is_active', 1)->get();


        for ($i = 1; $i <= 12; $i++) {

            $entrylevel_saving = array();
            $advacnedlevel_saving = array();
            $newadvacnedlevel_saving = array();
            $newentrylevel_saving = array();
            $clientscorecard_saving = array();

            $clientDelta_spend = 0;

            foreach ($categoryData as $row) {

                $entrylevel_saving[$row->id]['oldyearapp'] = Appcalculationoldyear($organization, 'Entry Level', $oldyear, $row->id, $users->email, array($project));
                $entrylevel_saving[$row->id]['newyearapp'] = appvlaueCurrentyear($organization, 'Entry Level', $year, $i, $row->id, $users->email, array($project));
                $advacnedlevel_saving[$row->id]['oldyearapp'] = Appcalculationoldyear($organization, 'Advanced Level', $oldyear, $row->id, $users->email, array($project));
                $advacnedlevel_saving[$row->id]['newyearapp'] = appvlaueCurrentyear($organization, 'Advanced Level', $year, $i, $row->id, $users->email, array($project));

                $newentrylevel_saving[$row->id][] = array_merge($entrylevel_saving[$row->id]['oldyearapp'], $entrylevel_saving[$row->id]['newyearapp']);
                $newadvacnedlevel_saving[$row->id][] = array_merge($advacnedlevel_saving[$row->id]['oldyearapp'], $advacnedlevel_saving[$row->id]['newyearapp']);

                $clientscorecard_saving[$row->id] = array_merge($newentrylevel_saving[$row->id], $newadvacnedlevel_saving[$row->id]);

            }

            $finalclients = array();
            $clientDelta_savings = 0;
            foreach ($clientscorecard_saving as $kwy => $vals) {
                foreach ($vals as $gd) {

                    $olddevice = $gd['oldavgvlaue'];
                    $utilization = $gd['totaldevice'];
                    $newdevice = $gd['currentavgvalue'];

                    if ($olddevice != 0 && $utilization != 0) {
                        $gd['oldSpend'] = $olddevice * $utilization;
                    } else {
                        $gd['oldSpend'] = 0;
                    }

                    if ($newdevice != 0 && $utilization != 0) {
                        $gd['newSpend'] = $newdevice * $utilization;
                    } else {
                        $gd['newSpend'] = 0;
                    }

                    $gd['delta'] = 0;
                    if ($gd['newSpend'] != 0) {
                        $gd['delta'] = $gd['newSpend'] - $gd['oldSpend'];
                    }

                    $clientDelta_savings = $clientDelta_savings + $gd['delta'];
                    $clientDelta_spend = $clientDelta_spend + $gd['newSpend'];

                }

            }

            $client_monthly_Savings[] = array(
                'totalspend' => $clientDelta_spend <= 0 ? 0 : $clientDelta_spend,
                'month' => getMonthName($i),
                'totalsaving' => $clientDelta_savings <= 0 ? 0 : $clientDelta_savings,
            );

            $totalsaving = $totalsaving + $clientDelta_savings;

            if ($i == $month) {

                $user_saving['saving'] = round($clientDelta_savings, 0);
                $user_saving['totalspend'] = round($clientDelta_spend, 0);
            }

        }

        $client_saving = round($totalsaving, 0);

        $data = array(
            'month_saving' => $user_saving['saving'],
            'month_spend' => $user_saving['totalspend'],
            'year_saving' => $client_saving,
        );

        return response()->json(['data' => $data, 'message' => 'Saving Data Get Sucessfully', 'status' => 1], 200);

    }

    public function clientsaving(Request $request)
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

        $oldyear = $year - 1;

        $organization = array($clientId);

        $users = JWTAuth::toUser($request->token);

        $project = userProjects::where('userId', $users['id'])->value('projectId');

        $categoryData = category::where('project_name', $project)->where('is_active', 1)->get();

        $userSavings_client = 0;
        $userspends_client = 0;
        $client_monthly_Savings_client = array();
        $totalsaving_client = 0;
        for ($i = 1; $i <= 12; $i++) {

            $entrylevel_saving_client = array();
            $advacnedlevel_saving_client = array();
            $newadvacnedlevel_saving_client = array();
            $newentrylevel_saving_client = array();
            $clientscorecard_saving_client = array();

            $client_spend_wise = 0;

            foreach ($categoryData as $row) {

                $entrylevel_saving_client[$row->id]['oldyearapp'] = Appcalculationoldyear($organization, 'Entry Level', $oldyear, $row->id, '', array($project));
                $entrylevel_saving_client[$row->id]['newyearapp'] = appvlaueCurrentyear($organization, 'Entry Level', $year, $i, $row->id, '', array($project));
                $advacnedlevel_saving_client[$row->id]['oldyearapp'] = Appcalculationoldyear($organization, 'Advanced Level', $oldyear, $row->id, '', array($project));
                $advacnedlevel_saving_client[$row->id]['newyearapp'] = appvlaueCurrentyear($organization, 'Advanced Level', $year, $i, $row->id, '', array($project));

                $newentrylevel_saving_client[$row->id][] = array_merge($entrylevel_saving_client[$row->id]['oldyearapp'], $entrylevel_saving_client[$row->id]['newyearapp']);
                $newadvacnedlevel_saving_client[$row->id][] = array_merge($advacnedlevel_saving_client[$row->id]['oldyearapp'], $advacnedlevel_saving_client[$row->id]['newyearapp']);

                $clientscorecard_saving_client[$row->id] = array_merge($newentrylevel_saving_client[$row->id], $newadvacnedlevel_saving_client[$row->id]);

            }

            $finalclients = array();
            $client_saving_wises = 0;
            foreach ($clientscorecard_saving_client as $kwys => $values) {
                foreach ($values as $gds) {

                    $olddevice_client = $gds['oldavgvlaue'];
                    $utilization_client = $gds['totaldevice'];
                    $newdevice_client = $gds['currentavgvalue'];

                    if ($olddevice_client != 0 && $utilization_client != 0) {
                        $gds['oldSpend'] = $olddevice_client * $utilization_client;
                    } else {
                        $gds['oldSpend'] = 0;
                    }

                    if ($newdevice_client != 0 && $utilization_client != 0) {
                        $gds['newSpend'] = $newdevice_client * $utilization_client;
                    } else {
                        $gds['newSpend'] = 0;
                    }

                    $gds['delta'] = $gds['newSpend'] - $gds['oldSpend'];

                    $client_saving_wises = $client_saving_wises + $gds['delta'];
                    $client_spend_wise = $client_spend_wise + $gds['newSpend'];

                }

            }

            $client_monthly_Savings_client[] = array(
                'total_spend' => round($client_spend_wise,0),
                'month_name' => getMonthName($i),
                'total_saving' => round($client_saving_wises,0),
            );

            $totalsaving_client = $totalsaving_client + $client_saving_wises;

            if ($i == $month) {
                $userSavings_client = round($client_saving_wises, 0);
                $userspends_client = round($client_spend_wise, 0);
            }

        }

        $client_saving_wise = round($totalsaving_client, 0);

        Log::debug($client_saving_wise);


        $data = array(
            'month_saving' => $userSavings_client,
            'month_spend' => $userspends_client,
            'year_saving' => $client_saving_wise,
            'monthwise_report' => $client_monthly_Savings_client
        );

        return response()->json(['data' => $data, 'message' => 'Saving Data Get Sucessfully', 'status' => 1], 200);
    }

    public function userwise_saving(Request $request)
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

        $oldyear = $year - 1;

        $organization = array($clientId);

        $users = JWTAuth::toUser($request->token);

        $project = userProjects::where('userId', $users['id'])->value('projectId');

        $categoryData = category::where('project_name', $project)->where('is_active', 1)->get();

        $getuser = User::leftjoin('user_clients', 'user_clients.userId', '=', 'users.id')
            ->leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
            ->whereIn('user_clients.clientId', $organization)
            ->where('user_projects.projectId', $project)
            ->where('users.roll', 3)
            ->where('users.status', 'Enabled')
            ->select('users.*', 'user_projects.projectId', 'user_clients.clientId')
            ->get();

        $user_wise_data = array();
        foreach ($getuser as $use) {

            /**
             * Perticular user Respective Month Wise Data Start
             */

            $oldyear_saving_user = array();
            $newyear_saving_user = array();
            $final_saving_user = array();

            $oldyear_saving_user['oldyearapp'] = Appcalculationoldyear($organization, '', $oldyear, '', $use->email, array($project));
            $newyear_saving_user['newyearapp'] = appvlaueCurrentyear($organization, '', $year, $month, '', $use->email, array($project));
            $final_saving_user[] = array_merge($oldyear_saving_user['oldyearapp'], $newyear_saving_user['newyearapp']);

            $user_wise_saving = array();
//dump($final_saving_user);
            foreach ($final_saving_user as $row) {

                $old_device_saving_user = $row['oldavgvlaue'];
                $saving_utiliaze_device_user = $row['totaldevice'];
                $new_device_saving_user = $row['currentavgvalue'];

                if ($old_device_saving_user != 0 && $saving_utiliaze_device_user != 0) {
                    $user_wise_saving['oldSpend'] = $old_device_saving_user * $saving_utiliaze_device_user;
                } else {
                    $user_wise_saving['oldSpend'] = 0;
                }

                if ($new_device_saving_user != 0 && $saving_utiliaze_device_user != 0) {
                    $user_wise_saving['totalspend'] = $new_device_saving_user * $saving_utiliaze_device_user;
                } else {
                    $user_wise_saving['totalspend'] = 0;
                }

                $user_wise_saving['saving'] = 0;

                if ($user_wise_saving['totalspend'] != 0) {
                    $user_wise_saving['saving'] = $user_wise_saving['totalspend'] - $user_wise_saving['oldSpend'];
                }

            }

            /**
             * Perticular user Respective Month Wise Data End
             */

            /**
             * Perticular User Respective Year Wise Data Start
             */
            $oldyear_month_saving_user = array();
            $newyear_month_saving_user = array();
            $final_month_saving_user = array();

            for ($i = 1; $i <= 12; $i++) {

                $oldyear_month_saving_user[$i]['oldyearapp'] = Appcalculationoldyear($organization, '', $oldyear, '', $use->email, array($project));
                $newyear_month_saving_user[$i]['newyearapp'] = appvlaueCurrentyear($organization, '', $year, $i, '', $use->email, array($project));
                $final_month_saving_user[$i][] = array_merge($oldyear_month_saving_user[$i]['oldyearapp'], $newyear_month_saving_user[$i]['newyearapp']);
            }

            $final_device_saving_user = array();
            $client_saving_user = 0;
            $client_spend_user = 0;

            foreach ($final_month_saving_user as $savng => $saving_value_user) {
                foreach ($saving_value_user as $values_user) {

                    $old_device_saving_user = $values_user['oldavgvlaue'];
                    $saving_utiliaze_device_user = $values_user['totaldevice'];
                    $new_device_saving_user = $values_user['currentavgvalue'];

                    if ($old_device_saving_user != 0 && $saving_utiliaze_device_user != 0) {
                        $values_user['oldSpend'] = $old_device_saving_user * $saving_utiliaze_device_user;
                    } else {
                        $values_user['oldSpend'] = 0;
                    }

                    if ($new_device_saving_user != 0 && $saving_utiliaze_device_user != 0) {
                        $values_user['newSpend'] = $new_device_saving_user * $saving_utiliaze_device_user;
                    } else {
                        $values_user['newSpend'] = 0;
                    }

                    $values_user['delta'] = 0;


                    if ($values_user['newSpend'] != 0) {
                        $values_user['delta'] = $values_user['newSpend'] - $values_user['oldSpend'];
                    }
//                    dump($values_user['delta']);

                    $category_name = category::where('id', $savng)->value('category_name');

                    $final_device_saving_user[getMonthName($savng)][] = $values_user;
                    $client_saving_user = $client_saving_user + $values_user['delta'];
                    $client_spend_user = $client_spend_user + $values_user['newSpend'];

                }
            }

            /**
             * Perticular User Respective Year Wise Data End
             */

            $user_wise_data[$use->name] = array(
                'month_saving' => $user_wise_saving['saving'] <= 0 ? 0 : $user_wise_saving['saving'],
                'month_spend' => $user_wise_saving['totalspend'] <= 0 ? 0 : $user_wise_saving['totalspend'],
                'year_saving' => $client_saving_user <= 0 ? 0 : $client_saving_user,
                'year_spend' => $client_spend_user <= 0 ? 0 : $client_spend_user,
            );
        }

        $user_wise = array();
        foreach ($user_wise_data as $row => $key) {

            $user_wise[] = array(
                "month_saving" => $key['month_saving'],
                "month_spend" => $key['month_spend'],
                "year_saving" => $key['year_saving'],
                "year_spend" => $key['year_spend'],
                "doctor_name" => $row,
            );
        }

        $data = $user_wise;


        return response()->json(['data' => $data, 'message' => 'Saving Data Get Sucessfully', 'status' => 1], 200);

    }
}
