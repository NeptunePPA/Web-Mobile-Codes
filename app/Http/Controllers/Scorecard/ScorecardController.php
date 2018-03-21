<?php

namespace App\Http\Controllers\Scorecard;

use App\category;
use App\clients;
use App\device;
use App\Http\Controllers\Controller;
use App\project;
use App\project_clients;
use App\ScoreCard;
use App\User;
use App\userClients;
use App\userProjects;
use Auth;
use Illuminate\Http\Request;
use Session;
use URL;

class ScorecardController extends Controller {
	public function index(Request $request, $id) {

		$client = $request->get('client');
		$newproject = $request->get('project_id');

		$score = ScoreCard::where('id', $id)->first();
		$users = User::where('id', $score['userId'])->first();

		$user_project = userProjects::where('userId', $users['id'])->first();

		$resultstr = array();
		foreach ($users->userclients as $row) {
			$resultstr[] = $row->clientname['client_name'];
		}

		if ($client == '') {
			$users['client_name'] = $resultstr[0];
		} else {
			$users['client_name'] = $client;
		}

		$clientImage = clients::where('client_name', $users['client_name'])->value('image');

		if (!empty($clientImage) && file_exists('public/' . $clientImage)) {
			$users['client_image'] = URL::to('public/' . $clientImage);
		} else {
			$users['client_image'] = URL::to('public/upload/default.jpg');
		}

		if (!empty($users['profilePic']) && file_exists('public/upload/user/' . $users['profilePic'])) {
			$users['profilePic'] = URL::to('public/upload/user/' . $users['profilePic']);
		} else {
			$users['profilePic'] = URL::to('public/upload/default.jpg');
		}

		$month = $score['monthId'];
		$year = $score['year'];
		$user = $users['email'];

		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');
		}

		if ($client != '') {
			$client_id = clients::where('client_name', $client)->value('id');
			$organization = array($client_id);
		} else {

			$client_id = clients::where('client_name', $resultstr[0])->value('id');
			$organization = array($client_id);
		}

		$project = project_clients::whereIn('client_name', $organization)->select('project_id')->orderBy('project_id', 'ASC')->get()->toArray();

		$project_name = ['' => 'All Projects'] + project::whereIn('id', $project)->pluck('project_name', 'id')->all();

		if (!empty($newproject)) {
			$project = array($newproject);
		} else {
			$project = array($user_project['projectId']);
		}

		$client_image = clients::whereIn('id', $organization)->value('image');

		$client_image = URL::to('public/' . $client_image);

		/**
		 * Device List Page start
		 */
		$data = getdata($month, $year, $user, $organization);

		$newData = array();
		foreach ($data as $key => $value) {
			foreach ($value as $tem) {
                $newData[] = $tem;
			}
		}
		$device = array();
		$qty = 1;
		$device_id = '';
		$purchasetype = '';

		$newdevice = array();

        foreach ($newData as $item) {
            $newdevice[$item['category_group_name']][] = $item;
        }

		$device = $newdevice;

		/**
		 * Device List Page End
		 */

		/**
		 * Market share Count Start
		 */
		$marketShare = manufacture($newData);

		/**
		 * Market Share Count End
		 */

		/**
		 *Bulk Consignment Count Start
		 */
		$bulkcount = bulkcount($newData);
		/**
		 *Bulk Consignment Count End
		 */

		/**
		 * Technology Count Start
		 */
		$technology = technology($newData);
		/**
		 * Technology Count End
		 */
		$totalspend = intval(array_sum(array_column($newData, 'price')));
		/**
		 * Category Count Start
		 */
		$category = category($data, $totalspend);
		/**
		 * Category Count End
		 */
		/**
		 * Vender CD Count Start
		 */
		$vender = venderCd($newData);
		/**
		 * Vender CD count End
		 */

		$costdiff = array_sum(array_column($vender, 'loss'));

		/**
		 * Client Scorecard Start
		 */
		$datas = clientData($month, $year, '', $organization, $project);

		$client_marketshares = client_marketshare($datas);

		$Final_client_marketshare = $client_marketshares['marketshare'];
		$final_client_totalspend = intval($client_marketshares['totalspend']);

//		$categoryData = category::whereIn('project_name', $project)->where('is_active', 1)->get();

        $categoryData = category::leftjoin('category_sort','category_sort.category_name','=','category.id')

            ->orderBy('category_sort.sort_number', 'ASC')
            ->whereIn('category_sort.client_name',$organization)
            ->where('category.is_active', '=', '1');
        if (!empty($project)) {
            $categoryData = $categoryData->where('category.project_name', $project);
        }
        $categoryData = $categoryData->select('category.*')->get();

		$entrylevel = array();
		$advacnedlevel = array();
		$newadvacnedlevel = array();
		$newentrylevel = array();
		$clientscorecard = array();
		$oldyear = $year - 1;
		foreach ($categoryData as $row) {

			$entrylevel[$row->id]['oldyearapp'] = Appcalculationoldyear($organization, 'Entry Level', $oldyear, $row->id, '', $project);
			$entrylevel[$row->id]['newyearapp'] = appvlaueCurrentyear($organization, 'Entry Level', $year, $month, $row->id, '', $project);
			$advacnedlevel[$row->id]['oldyearapp'] = Appcalculationoldyear($organization, 'Advanced Level', $oldyear, $row->id, '', $project);
			$advacnedlevel[$row->id]['newyearapp'] = appvlaueCurrentyear($organization, 'Advanced Level', $year, $month, $row->id, '', $project);

			$newentrylevel[$row->id][] = array_merge($entrylevel[$row->id]['oldyearapp'], $entrylevel[$row->id]['newyearapp']);
			$newadvacnedlevel[$row->id][] = array_merge($advacnedlevel[$row->id]['oldyearapp'], $advacnedlevel[$row->id]['newyearapp']);

			$clientscorecard[$row->id] = array_merge($newentrylevel[$row->id], $newadvacnedlevel[$row->id]);

		}

		$finalclients = array();
		$clientDelta = 0;

		foreach ($clientscorecard as $kwy => $vals) {

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

				$category_name = category::where('id', $kwy)->value('short_name');

				$finalclients[$category_name][] = $gd;
				$clientDelta = $clientDelta + $gd['delta'];
			}
		}

		$finalclient = array();

		foreach ($finalclients as $finalclient_key => $finalclient_value) {

			$finalclient[$finalclient_key] = $finalclient_value;

            if ($finalclient_value[0]['totaldevice'] > 0 && $finalclient_value[1]['totaldevice'] > 0) {
                $finalclient[$finalclient_key][2] = 2;
            }

			if ($finalclient_value[0]['totaldevice'] == 0 && $finalclient_value[1]['totaldevice'] > 0) {

				$finalclient[$finalclient_key][2] = 1;

			}

			if ($finalclient_value[0]['totaldevice'] > 0 && $finalclient_value[1]['totaldevice'] == 0) {

				$finalclient[$finalclient_key][2] = 0;

			}

		}

		/**
		 * Client Scorecard
		 */

		/**
		 * Vendor MarketShare
		 */

		/**
		 * Total MarkerShare
		 */
		$vendormonth = '';
//		$totalMarketsharecount = clientData($vendormonth, $year, '', $organization, $project);
//
//		$totalMarketshares = client_marketshare($totalMarketsharecount);
//		$totalMarketshare = $totalMarketshares['marketshare'];

        $totalMarketshares = '';
        $totalMarketshare = '';
		/**
		 * Client Month wise saving Start
		 */

		$oldyear_saving = array();
		$newyear_saving = array();
		$final_saving = array();

		$clientSaving = array();
//		for ($i = 1; $i <= 12; $i++) {
//
//			$categoryData = category::whereIn('project_name', $project)->where('is_active', 1)->get();
//
//			$entrylevel_saving = array();
//			$advacnedlevel_saving = array();
//			$newadvacnedlevel_saving = array();
//			$newentrylevel_saving = array();
//			$clientscorecard_saving = array();
//
//			$clientDelta_savings = 0;
//			$clientDelta_spend = 0;
//
//			foreach ($categoryData as $row) {
//
//				$entrylevel_saving[$row->id]['oldyearapp'] = Appcalculationoldyear($organization, 'Entry Level', $oldyear, $row->id, '', $project);
//				$entrylevel_saving[$row->id]['newyearapp'] = appvlaueCurrentyear($organization, 'Entry Level', $year, $i, $row->id, '', $project);
//				$advacnedlevel_saving[$row->id]['oldyearapp'] = Appcalculationoldyear($organization, 'Advanced Level', $oldyear, $row->id, '', $project);
//				$advacnedlevel_saving[$row->id]['newyearapp'] = appvlaueCurrentyear($organization, 'Advanced Level', $year, $i, $row->id, '', $project);
//
//				$newentrylevel_saving[$row->id][] = array_merge($entrylevel_saving[$row->id]['oldyearapp'], $entrylevel_saving[$row->id]['newyearapp']);
//				$newadvacnedlevel_saving[$row->id][] = array_merge($advacnedlevel_saving[$row->id]['oldyearapp'], $advacnedlevel_saving[$row->id]['newyearapp']);
//
//				$clientscorecard_saving[$row->id] = array_merge($newentrylevel_saving[$row->id], $newadvacnedlevel_saving[$row->id]);
//
//			}
//
//			$finalclients = array();
//
//			foreach ($clientscorecard_saving as $kwy => $vals) {
//				foreach ($vals as $gd) {
//
//					$olddevice = $gd['oldavgvlaue'];
//					$utilization = $gd['totaldevice'];
//					$newdevice = $gd['currentavgvalue'];
//
//					if ($olddevice != 0 && $utilization != 0) {
//						$gd['oldSpend'] = $olddevice * $utilization;
//					} else {
//						$gd['oldSpend'] = 0;
//					}
//
//					if ($newdevice != 0 && $utilization != 0) {
//						$gd['newSpend'] = $newdevice * $utilization;
//					} else {
//						$gd['newSpend'] = 0;
//					}
//					$gd['delta'] = 0;
//					if ($gd['newSpend'] != 0) {
//						$gd['delta'] = $gd['newSpend'] - $gd['oldSpend'];
//					}
//
//					$category_name = category::where('id', $kwy)->value('short_name');
//
//					$finalclients[$category_name][] = $gd;
//					$clientDelta_savings = $clientDelta_savings + $gd['delta'];
//					$clientDelta_spend = $clientDelta_spend + $gd['newSpend'];
//
//				}
//
//			}
//			$clientSaving[$i] = array(
//				'totalspend' => intval($clientDelta_spend),
//				'month' => getMonthName($i),
//				'totalsaving' => intval($clientDelta_savings),
//			);
//
//		}

		/**
		 * Client Month wise Saving End
		 */

		$color = ['#efeff0', '#dae7f3', '#d6d6d6','#efeff0', '#dae7f3', '#d6d6d6','#efeff0', '#dae7f3', '#d6d6d6','#efeff0', '#dae7f3', '#d6d6d6','#efeff0', '#dae7f3', '#d6d6d6','#efeff0', '#dae7f3', '#d6d6d6','#efeff0', '#dae7f3', '#d6d6d6','#efeff0', '#dae7f3', '#d6d6d6'];

		return view('pages.scorecard.index', compact('id', 'color','user_project', 'client_image', 'score', 'client', 'users', 'device', 'marketShare', 'bulkcount', 'technology', 'category', 'vender', 'costdiff', 'totalspend', 'finalclient', 'Final_client_marketshare', 'final_client_totalspend', 'clientDelta', 'totalMarketshare', 'clientSaving', 'project_name'));	}

	public function frontscorecard(Request $request, $id) {

		$clientdetails = session('details');
		$clients = $clientdetails['clients'];

		$dtype = session('dtype');

		$devicetype = $dtype['devicetype'];
		$updatedate = $dtype['updatedate'];

		$clientname = clients::where('id', '=', $clients)->value('client_name');

		$score = ScoreCard::where('id', $id)->first();

		$users = User::where('id', $score['userId'])->first();

		$username = $users['name'];
		$projectname = $users->prname['project_name'];

		$month = $score['monthId'];
		$year = $score['year'];
		$user = $users['email'];

		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');
		}

		/**
		 * Device List Page start
		 */
		$data = getdata($month, $year, $user, $organization);

		$newData = array();
		foreach ($data as $key => $value) {
			foreach ($value as $tem) {
				$newData[] = $tem;
			}
		}
		$device = $newData;

		/**
		 * Device List Page End
		 */

		/**
		 * Market share Count Start
		 */
		$marketShare = manufacture($newData);

		/**
		 * Market Share Count End
		 */

		/**
		 *Bulk Consignment Count Start
		 */
		$bulkcount = bulkcount($newData);
		/**
		 *Bulk Consignment Count End
		 */

		/**
		 * Technology Count Start
		 */
		$technology = technology($newData);
		/**
		 * Technology Count End
		 */
		$totalspend = intval(array_sum(array_column($device, 'price')));
		/**
		 * Category Count Start
		 */
		$category = category($data, $totalspend);
		/**
		 * Category Count End
		 */
		/**
		 * Vender CD Count Start
		 */
		$vender = venderCd($newData);
		/**
		 * Vender CD count End
		 */

		$costdiff = array_sum(array_column($vender, 'loss'));

		$totalspend = array_sum(array_column($device, 'price'));

		return view('pages.frontend.scorecardImage', compact('devicetype', 'clientname', 'projectname', 'username', 'updatedate', 'score', 'users', 'device', 'marketShare', 'bulkcount', 'technology', 'category', 'vender', 'costdiff', 'totalspend'));
	}
}
