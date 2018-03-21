<?php

namespace App\Http\Controllers;

use App\category;
use App\Clientcustomfeatures;
use App\clients;
use App\client_price;
use App\customContact;
use App\device;
use App\DeviceFeatureImage;
use App\Devicefeatures;
use App\device_custom_field;
use App\manufacturers;
use App\physciansPreference;
use App\project;
use App\project_clients;
use App\RepContact;
use App\Serialnumber;
use App\SerialnumberDetail;
use App\Survey;
use App\SurveyAnswer;
use App\User;
use App\userClients;
use Auth;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
// survey
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
// Custom Contact
use Illuminate\Support\Facades\Validator;
// rep contact info
use Response;
use View;

class devices extends Controller {

	public function index(Request $request) {
		$sort = $request->get('sortvalue');
		$pagesize = $request->get('pagesize');
		if ($pagesize == "") {
			$pagesize = 10;
		}

		$projects = ['0' => 'Select Project'] + Project::pluck('project_name', 'id')->all();
		$category = ['0' => 'Select Category'] + Category::pluck('category_name', 'id')->all();
		$manufacturer = ['0' => 'Select Manufacturer'] + Manufacturers::pluck('manufacturer_name', 'id')->all();

		$userid = Auth::user()->id;

		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');

		}

		if (count($organization) > 0) {

			$serialnumbers = SerialnumberDetail::whereIn('clientId', $organization)->pluck('serialNumber', 'serialNumber')->all();
			//$organization = user::where('id', '=', $userid)->value('organization');

			if ($sort == "") {
				$device_view = device::leftjoin('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
					->leftjoin('projects', 'projects.id', '=', 'device.project_name')
					->leftjoin('project_clients', 'project_clients.project_id', '=', 'projects.id')
					->leftjoin('category', 'category.id', '=', 'device.category_name')
					->whereIn('project_clients.client_name', $organization)
					->select('device.id', 'device.model_name', 'device.status', 'device.device_name', 'manufacturers.manufacturer_name as manu_name', 'projects.project_name', 'category.category_name')
					->where('device.is_delete', '=', '0')
					->orderBy('device.id', 'DESC')
					->groupBy('device.id')
					->paginate($pagesize);
			} else {
				$device_view = device::leftjoin('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
					->leftjoin('projects', 'projects.id', '=', 'device.project_name')
					->leftjoin('category', 'category.id', '=', 'device.category_name')
					->leftjoin('project_clients', 'project_clients.project_id', '=', 'projects.id')
					->select('device.id', 'device.model_name', 'device.status', 'device.device_name', 'manufacturers.manufacturer_name as manu_name', 'projects.project_name', 'category.category_name')
					->whereIn('project_clients.client_name', $organization)
					->where('device.is_delete', '=', '0')
					->orderBy($sort, 'asc')
					->groupBy('device.id')
					->paginate($pagesize);
			}

			$count = device::leftjoin('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
				->leftjoin('projects', 'projects.id', '=', 'device.project_name')
				->leftjoin('project_clients', 'project_clients.project_id', '=', 'projects.id')
				->leftjoin('category', 'category.id', '=', 'device.category_name')
				->whereIn('project_clients.client_name', $organization)
				->select('device.id', 'device.model_name', 'device.status', 'device.device_name', 'manufacturers.manufacturer_name as manu_name', 'projects.project_name', 'category.category_name')
				->where('device.is_delete', '=', '0')
				->groupBy('device.id')
				->get();

			$count = count($count);
			// dd($count);

		} else {

			$serialnumbers = SerialnumberDetail::pluck('serialNumber', 'serialNumber')->all();

			if ($sort == "") {
				$device_view = device::leftjoin('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
					->leftjoin('projects', 'projects.id', '=', 'device.project_name')
					->leftjoin('category', 'category.id', '=', 'device.category_name')
					->select('device.id', 'device.model_name', 'device.status', 'device.device_name', 'manufacturers.manufacturer_name as manu_name', 'projects.project_name', 'category.category_name')
					->where('device.is_delete', '=', '0')
					->orderBy('device.id', 'DESC')
					->groupBy('device.id')
					->paginate($pagesize);
			} else {
				$device_view = device::leftjoin('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
					->leftjoin('projects', 'projects.id', '=', 'device.project_name')
					->leftjoin('category', 'category.id', '=', 'device.category_name')
					->select('device.id', 'device.model_name', 'device.status', 'device.device_name', 'manufacturers.manufacturer_name as manu_name', 'projects.project_name', 'category.category_name')
					->where('device.is_delete', '=', '0')
					->orderBy($sort, 'asc')
					->groupBy('device.id')
					->paginate($pagesize);
			}

			$count = device::leftjoin('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
				->leftjoin('projects', 'projects.id', '=', 'device.project_name')
				->leftjoin('category', 'category.id', '=', 'device.category_name')
				->where('device.is_delete', '=', '0')
				->count();
			// dd($count);
		}

		return view('pages.device', compact('device_view', 'projects', 'category', 'manufacturer', 'count', 'pagesize', 'sort', 'serialnumbers'));
	}

	public function add(Request $request) {
		$userid = Auth::user()->id;

		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');

		}

		if (count($organization) > 0) {
			$projects = ['0' => 'Select Project'] + Project::leftjoin('project_clients', 'project_clients.project_id', '=', 'projects.id')
				->whereIn('project_clients.client_name', $organization)
				->where('projects.is_delete', '=', '0')->pluck('projects.project_name', 'projects.id')->all();
		} else {

			$projects = ['0' => 'Select Project'] + Project::where('is_delete', '=', '0')->pluck('project_name', 'id')->all();
		}

		$manufacturer = ['0' => 'Select Manufacturer'] + Manufacturers::where('is_delete', '=', '0')->pluck('manufacturer_name', 'id')->all();
		// $users = ['0' => 'Select Rep'] + user::where('roll', 5)->where('is_delete', '=', '0')->pluck('email', 'id')->all();
		return view('pages.adddevice', compact('projects', 'manufacturer'));
	}

	public function create(Request $request) {

//        dd($request->all());

		$rules = array(
			'level_name' => 'required|not_in:0',
			'project_name' => 'required|not_in:0',
			'category_name' => 'required|not_in:0',
			'manufacturer_name' => 'required|not_in:0',
			'device_name' => 'required',
			'model_name' => 'required|unique:device,model_name',
			'device_image' => 'required',
			// 'rep_email' => 'required|not_in:0',
			'shock' => 'regex:/^[0-9]{1,3}([\/][0-9]{1,3})?$/',
			'size' => 'regex:/^[0-9]{1,3}([\/][0-9]{1,3})?$/',
			'status' => 'required|not_in:0',
		);

		$checkdevice = device::where('device_name', '=', Input::get('devicename'))->where('is_delete', '=', 0)->count();
		if ($checkdevice >= 1) {
			return Redirect::back()->withErrors(['device_name' => 'Device name already exist in database.']);
		} else {

			$insertdata = array(
				"level_name" => Input::get('level'),
				"project_name" => Input::get('project_name'),
				"category_name" => Input::get('category_name'),
				"manufacturer_name" => Input::get('manufacturer_name'),
				"device_name" => Input::get('devicename'),
				"model_name" => Input::get('modelname'),
				"device_image" => Input::get('image_name'),
				"status" => Input::get('status'),
				"exclusive" => Input::get('exclusive'),
				"longevity" => Input::get('longevity'),
				"shock" => Input::get('shock'),
				"size" => Input::get('size'),
				"research" => Input::get('research'),
				"website_page" => Input::get('websitepage'),
				"url" => Input::get('url'),
				"overall_value" => Input::get('overall_value'),
				"is_delete" => "0",
				"exclusive_side" => Input::get('exclusive_side'),
				"longevity_side" => Input::get('longevity_side'),
				"shock_side" => Input::get('shock_side'),
				"size_side" => Input::get('size_side'),
				"research_side" => Input::get('research_side'),
				"websitepage_side" => Input::get('websitepage_side'),
				"url_side" => Input::get('url_side'),
				"overall_value_side" => Input::get('overall_value_side'),
				"performance" => Input::get('performance'),
				"research_email" => Input::get('research_email'),
			);

			$validator = Validator::make($insertdata, $rules);
			if ($validator->fails()) {
				return Redirect::back()->withErrors($validator);
			} else {

				$destinationpath = 'public/upload';
				$image = $request->file('image');
				$extenstion = $image->getClientOriginalExtension();
				$filename = 'device' . '_' . rand(11111, 99999) . '.' . $extenstion;

				$insertdata = array(
					"level_name" => Input::get('level'),
					"project_name" => Input::get('project_name'),
					"category_name" => Input::get('category_name'),
					"manufacturer_name" => Input::get('manufacturer_name'),
					"device_name" => Input::get('devicename'),
					"model_name" => Input::get('modelname'),
					"device_image" => $filename,
					"status" => Input::get('status'),
					"exclusive" => Input::get('exclusive'),
					"longevity" => Input::get('longevity'),
					"shock" => Input::get('shock'),
					"size" => Input::get('size'),
					"research" => Input::get('research'),
					"website_page" => Input::get('websitepage'),
					"url" => Input::get('url'),
					"overall_value" => Input::get('overall_value'),
					"is_delete" => "0",
					"exclusive_side" => Input::get('exclusive_side'),
					"longevity_side" => Input::get('longevity_side'),
					"shock_side" => Input::get('shock_side'),
					"size_side" => Input::get('size_side'),
					"research_side" => Input::get('research_side'),
					"websitepage_side" => Input::get('websitepage_side'),
					"url_side" => Input::get('url_side'),
					"overall_value_side" => Input::get('overall_value_side'),
					"performance" => Input::get('performance'),
					"research_email" => Input::get('research_email'),
				);

				$insert_device = 0;
				$insert_device = device::insert($insertdata);
				$device_id = device::get()->last();
				$device_id = $device_id->id;
				$insertcustomfields = Input::get('fieldname');
				$insertcustomfieldvalue = Input::get('fieldvalue');
				$insertcustomfieldcheck = Input::get('chk_fieldname');
				$insertcustomfieldside = Input::get('fieldside');
				$insertcustomfieldimage = $request['fieldimage'];

				for ($i = 0; $i < count($insertcustomfields); $i++) {
					if ($insertcustomfields[$i] != "") {

						if (!isset($insertcustomfieldcheck[$i])) {
							$insertcustomfieldcheck[$i] = "False";
						}
						$filenames = '';

						if ($insertcustomfieldimage[$i] != '') {

							$filenames = 'devicecustome-' . $device_id . 'Bg-' . rand(0, 999) . '.' . $insertcustomfieldimage[$i]->getClientOriginalExtension();
							$insertcustomfieldimage[$i]->move('public/upload/devicefeature/custom/', $filenames);
						}

						$insertrecord = array(
							"device_id" => $device_id,
							"field_name" => $insertcustomfields[$i],
							"field_value" => $insertcustomfieldvalue[$i],
							"field_check" => $insertcustomfieldcheck[$i],
							"fieldimage" => $filenames,
							"fieldside" => $insertcustomfieldside[$i],

						);
						$insert_custom_field = device_custom_field::insert($insertrecord);
					}
				}

				if ($insert_device >= 0) {
					$move = $image->move($destinationpath, $filename);

					return Redirect::to('admin/devices');
				}
			}
		}
	}

	public function view($id, Request $request) {

		$pagesize = $request->get('repPageSize');
		if ($pagesize == "") {
			$pagesize = 10;
		}

		/*clientnames*/
		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');

		}

		$device_view = device::leftjoin('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
			->leftjoin('projects', 'projects.id', '=', 'device.project_name')
			->leftjoin('category', 'category.id', '=', 'device.category_name')
		// ->leftjoin('users', 'users.id', '=', 'device.rep_email')
			->select('device.*', 'manufacturers.manufacturer_name as manu_name', 'projects.project_name', 'category.category_name')
			->where('device.id', '=', $id)
			->first();

		$device_features_image = DeviceFeatureImage::first();

		if (count($organization) > 0) {
			$userid = Auth::user()->id;
			//$organization = user::where('id', '=', $userid)->value('organization');

			$client_prices = client_price::join('clients', 'clients.id', '=', 'client_price.client_name')
				->select('client_price.*', 'clients.client_name')->where('client_price.device_id', '=', $id)->where('client_price.is_delete', '=', 0)
				->whereIn('client_price.client_name', $organization)
				->orderBy('client_price.id', 'DESC')->get();
		} else {
			$client_prices = client_price::join('clients', 'clients.id', '=', 'client_price.client_name')
				->select('client_price.*', 'clients.client_name', 'client_price.client_name as client')
				->where('client_price.device_id', '=', $id)
				->where('client_price.is_delete', '=', 0)
				->orderBy('client_price.id', 'DESC')
				->get();
		}
		foreach ($client_prices as $client_price) {

			$client_price->remain_bulk = $client_price->bulk;
			$client_price->remain_system_bulk = $client_price->system_bulk;

		}

		$custom_fields = device_custom_field::join('device', 'device.id', '=', 'device_custom_field.device_id')
			->select('device_custom_field.*')->where('device_id', '=', $id)->get();

		// device Features Tab
		$device_features = Devicefeatures::leftjoin('clients', 'clients.id', '=', 'device_features.client_name')
			->leftjoin('device', 'device.id', '=', 'device_features.device_id')
			->select('device_features.*', 'device.longevity', 'device.shock', 'device.size', 'device.research', 'device.website_page', 'device.url', 'device.overall_value', 'clients.client_name', 'device_features.client_name as client')
			->where('device_features.device_id', '=', $id)
			->orderBy('device_features.id', 'DESC')
			->get();

		// Device Survey Tab
		$device_surveys = physciansPreference::where('deviceId', '=', $id)
			->orderBy('id', 'asc')
//            ->groupby('clientId')
			->get();
		$data = array();
		foreach ($device_surveys as $device_survey) {
			$data[$device_survey->clientId]['clientName'] = $device_survey->client->client_name;
			$data[$device_survey->clientId]['clientId'] = $device_survey->clientId;
			$data[$device_survey->clientId][] = array(
				'question' => $device_survey->question,
				'check' => $device_survey->check,
			);
		}

		$device_survey = $data;
//        dd($device_survey);
		// Device Contact Tab
		$deviceCustomContact = customContact::where('deviceId', $id)
			->orderBy('id', 'DESC')
			->get();

		// Device Rep User Tab
		$organization = device::where('id', $id)->first();

		$deviceRepUser = User::repcontact()->where('users.roll', '5')
			->where('users.organization', $organization->manufacturer_name)
			->where('user_projects.projectId', $organization->project_name)
			->groupBy('users.id')
			->orderBy('users.id', 'DESC')
			->paginate($pagesize);
		// dd($id);

		foreach ($deviceRepUser as $row) {

			$row->repStatus = RepContact::where('deviceId', $id)->where('repId', $row->id)->value('repStatus');

			$row->repStatus = $row->repStatus == "Yes" ? "Yes" : "No";

			$row->userclientName = array();
			$temporaryClient = array();

			if (count($row->userclients) > 0) {
				foreach ($row->userclients as $row1) {
					array_push($temporaryClient, $row1->clientname->client_name);
				}
			}

			$row->userclientName = implode(", ", $temporaryClient);
		}
		// dd($deviceRepUser);

		$count = User::where('roll', '5')->where('organization', $organization->manufacturer_name)->where('users.projectname', $organization->project_name)->count();

		/*Serial Number Device tab Start*/
		$serial = Serialnumber::orderBy('id', 'DESC')->where('deviceId', $id)->paginate($pagesize);
		$countSerial = Serialnumber::orderBy('id', 'DESC')->where('deviceId', $id)->count();

		/*Serial Number Device tab End*/

		$serialnumbers = SerialnumberDetail::where('deviceId', $id)->pluck('serialNumber', 'serialNumber')->all();

		$organizations = userClients::where('userId', Auth::user()->id)->select('clientId')->get();

		if ($request->session()->has('adminclient')) {
			$organizations = session('adminclient');
		}
		// dump('okk');
		// dump(count($organizations));
		if (count($organizations) > 0) {

			// device Features Tab
			$device_features = Devicefeatures::leftjoin('clients', 'clients.id', '=', 'device_features.client_name')
				->leftjoin('device', 'device.id', '=', 'device_features.device_id')
				->select('device_features.*', 'device.longevity', 'device.shock', 'device.size', 'device.research', 'device.website_page', 'device.url', 'device.overall_value', 'clients.client_name', 'device_features.client_name as client')
				->where('device_features.device_id', '=', $id)
				->whereIn('device_features.client_name', $organizations)
				->orderBy('device_features.id', 'DESC')
				->get();

			// Device Survey Tab

			$device_surveys = physciansPreference::where('deviceId', '=', $id)
				->whereIn('clientId', $organizations)
				->orderBy('id', 'asc')
				->get();

			$data = array();
			foreach ($device_surveys as $device_survey) {
				$data[$device_survey->clientId]['clientName'] = $device_survey->client->client_name;
				$data[$device_survey->clientId]['clientId'] = $device_survey->clientId;
				$data[$device_survey->clientId][] = array(
					'question' => $device_survey->question,
					'check' => $device_survey->check,
				);
			}

			$device_survey = $data;
			// Device Contact Tab
			$deviceCustomContact = customContact::where('deviceId', $id)
				->whereIn('clientId', $organizations)
				->orderBy('id', 'DESC')
				->get();
			// Device Rep User Tab
			$organization = device::where('id', $id)->first();
			// dd($organization);
			$deviceRepUser = User::repcontact()->where('users.roll', '5')
				->where('users.organization', $organization->manufacturer_name)
				->whereIn('user_clients.clientId', $organizations)
				->where('user_projects.projectId', $organization->project_name)
				->groupBy('users.id')
				->orderBy('users.id', 'DESC')
				->paginate($pagesize);

			foreach ($deviceRepUser as $row) {

				$row->repStatus = RepContact::where('deviceId', $id)->where('repId', $row->id)->value('repStatus');
				$row->repStatus = $row->repStatus == "Yes" ? "Yes" : "No";
				$row->userclientName = array();
				$temporaryClient = array();
				foreach ($row->userclients as $row1) {
					array_push($temporaryClient, $row1->clientname->client_name);
				}
				$row->userclientName = implode(", ", $temporaryClient);
			}

			$count = User::repcontact()->where('roll', '5')->where('users.organization', $organization->manufacturer_name)->where('users.projectname', $organization->project_name)->whereIn('user_clients.clientId', $organizations)->count();

			/*Serial Number Device tab Start*/
			$serial = Serialnumber::orderBy('id', 'DESC')->where('deviceId', $id)->whereIn('clientId', $organizations)->paginate($pagesize);
			$countSerial = Serialnumber::orderBy('id', 'DESC')->where('deviceId', $id)->whereIn('clientId', $organizations)->count();

			/*Serial Number Device tab End*/

			$serialnumbers = SerialnumberDetail::whereIn('clientId', $organizations)->where('deviceId', $id)->pluck('serialNumber', 'serialNumber')->all();
		}

		return view('pages.viewdevice', compact('device_view', 'device_features_image', 'client_prices', 'custom_fields', 'device_features', 'device_survey', 'deviceCustomContact', 'deviceRepUser', 'count', 'pagesize', 'serial', 'countSerial', 'serialnumbers'));
	}

	public function edit(Request $request, $id) {
		$userid = Auth::user()->id;

		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');

		}
		if (count($organization) > 0) {
			$projects = ['0' => 'Select Project'] + Project::leftjoin('project_clients', 'project_clients.project_id', '=', 'projects.id')
				->whereIn('project_clients.client_name', $organization)
				->where('projects.is_delete', '=', '0')->pluck('projects.project_name', 'projects.id')->all();

			$category = Category::whereIn('project_name', $projects)->where('is_delete', '=', 0)->pluck('category_name', 'id')->all();
		} else {

			$projects = ['0' => 'Select Project'] + Project::where('is_delete', '=', '0')->pluck('project_name', 'id')->all();

			$category = Category::where('is_delete', '=', 0)->pluck('category_name', 'id')->all();
		}

		$manufacturer = Manufacturers::where('is_delete', '=', '0')->pluck('manufacturer_name', 'id')->all();
		// $users = user::where('roll', 5)->where('is_delete', '=', '0')->pluck('email', 'id')->all();
		$custom_fields = device_custom_field::join('device', 'device.id', '=', 'device_custom_field.device_id')->select('device_custom_field.*')->where('device_id', '=', $id)->get();
		$devices = device::FindOrFail($id);
		return view('pages.editdevice', compact('projects', 'manufacturer', 'devices', 'custom_fields', 'category'));
	}

	public function update(Request $request, $id) {

		$rules = array(
			'level_name' => 'required|not_in:0',
			'project_name' => 'required|not_in:0',
			'category_name' => 'required|not_in:0',
			'manufacturer_name' => 'required|not_in:0',
			'device_name' => 'required|not_in:0',
			'model_name' => 'required',
			// 'rep_email' => 'required|not_in:0',
			'shock' => 'regex:/^[0-9]{1,3}([\/][0-9]{1,3})?$/',
			'size' => 'regex:/^[0-9]{1,3}([\/][0-9]{1,3})?$/',
			'status' => 'required|not_in:0',
		);

		$updatedata = array(
			"level_name" => Input::get('level_name'),
			"project_name" => Input::get('project_name'),
			"category_name" => Input::get('category_name'),
			"manufacturer_name" => Input::get('manufacturer_name'),
			"device_name" => Input::get('device_name'),
			"model_name" => Input::get('model_name'),
			"status" => Input::get('status'),
			"exclusive" => Input::get('exclusive'),
			"longevity" => Input::get('longevity'),
			"shock" => Input::get('shock'),
			"size" => Input::get('size'),
			"research" => Input::get('research'),
			"website_page" => Input::get('website_page'),
			"url" => Input::get('url'),
			"overall_value" => Input::get('overall_value'),
			"is_delete" => "0",
            "exclusive_side" => Input::get('exclusive_side'),
            "longevity_side" => Input::get('longevity_side'),
            "shock_side" => Input::get('shock_side'),
            "size_side" => Input::get('size_side'),
            "research_side" => Input::get('research_side'),
            "websitepage_side" => Input::get('websitepage_side'),
            "url_side" => Input::get('url_side'),
            "overall_value_side" => Input::get('overall_value_side'),
            "performance" => Input::get('performance'),
            "research_email" => Input::get('research_email'),
		);

		if (Input::hasFile('image')) {
			$destinationpath = 'public/upload';
			$extenstion = Input::file('image')->getClientOriginalExtension();
			$filename = 'device' . '_' . rand(11111, 99999) . '.' . $extenstion;
			$updatedata["device_image"] = $filename;
		}

		$validator = Validator::make($updatedata, $rules);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		} else {

			$insertcustomfields = Input::get('fieldname');
			$insertcustomfieldvalue = Input::get('fieldvalue');
			$insertcustomfieldcheck = Input::get('chk_fieldname');
			$insertcustomfieldside = Input::get('fieldside');
			$insertcustomfieldimage = $request['fieldimage'];
			for ($i = 0; $i < count($insertcustomfields); $i++) {
				if (!isset($insertcustomfieldcheck[$i])) {
					$insertcustomfieldcheck[$i] = "False";
				}

				if ($insertcustomfields[$i] != "") {

					$insertrecord = array(
						"device_id" => $id,
						"field_name" => $insertcustomfields[$i],
						"field_value" => $insertcustomfieldvalue[$i],
						"field_check" => $insertcustomfieldcheck[$i],
						"fieldside" => $insertcustomfieldside[$i],
					);

					if ($insertcustomfieldimage[$i] != '') {

						$filenames = 'devicecustome-' . $id . 'Bg-' . rand(0, 999) . '.' . $insertcustomfieldimage[$i]->getClientOriginalExtension();
						$insertcustomfieldimage[$i]->move('public/upload/devicefeature/custom/', $filenames);

						$insertrecord['fieldimage'] = $filenames;
					}

					$insert_custom_field = device_custom_field::insert($insertrecord);
				}
			}

			$customfieldid = Input::get('customhidden');
			$editcustomfields = Input::get('fieldnameedit');
			$editcustomfieldvalue = Input::get('fieldvalueedit');
			$editcustomfieldcheck = Input::get('chk_fieledit');
			$editcustomfieldside = Input::get('fieldsideedit');
			$editcustomfieldimage = $request['fieldimageedit'];

			for ($i = 0; $i < count($editcustomfields); $i++) {

				if (!isset($editcustomfieldcheck[$i])) {
					$editcustomfieldcheck[$i] = "False";
				}

				$updatecustomfield = array(
					"field_name" => $editcustomfields[$i],
					"field_value" => $editcustomfieldvalue[$i],
					"field_check" => $editcustomfieldcheck[$i],
					"fieldside" => $editcustomfieldside[$i],
				);

				if (isset($editcustomfieldimage[$i])) {

					if (!empty($editcustomfieldimage[$i])) {

						$getimage = device_custom_field::where('id', $customfieldid[$i])->value('fieldimage');
						if ($getimage) {
							$getfilename = public_path() . '/upload/devicefeature/custom/' . $getimage;

							\File::delete($getfilename);
						}
						$editfilenames = 'devicecustome-' . $id . 'Bg-' . rand(0, 999) . '.' . $editcustomfieldimage[$i]->getClientOriginalExtension();
                        $editcustomfieldimage[$i]->move('public/upload/devicefeature/custom/', $editfilenames);

						$updatecustomfield['fieldimage'] = $editfilenames;
					}

				}

				$update_custom_field = DB::table('device_custom_field')->where('id', '=', $customfieldid[$i])->update($updatecustomfield);
			}

			$devicename = Input::get('device_name');
			$modelname = Input::get('model_name');
			$get_modelname = device::where('id', '=', $id)->value('model_name');
			$get_devicename = device::where('id', '=', $id)->value('device_name');
			if ($get_devicename == $devicename && $get_modelname == $modelname) {

				DB::table('device')->where('id', '=', $id)->update($updatedata);
			} else {

				if ($get_devicename != $devicename) {
					$check_devices = device::where('device_name', '=', $devicename)->count();
					if ($check_devices >= 1) {
						$errors['device_name'] = 'Device Name already exist in database.';
					}

				}
				if ($get_modelname != $modelname) {
					$check_model = device::where('model_name', '=', $modelname)->count();
					if ($check_model >= 1) {
						$errors['model_name'] = 'Model Name already exist in database.';
					}

				}

				if (isset($errors) || !empty($errors)) {
					return Redirect::back()->withErrors($errors);
				}

				DB::table('device')->where('id', '=', $id)->update($updatedata);
			}
			if (isset($filename) || !empty($filename)) {
				Input::file('image')->move($destinationpath, $filename);
			}
			return Redirect::to('admin/devices');
		}
	}

	public function remove($id) {

		$removedata = array('is_delete' => '1');
		$removeserial = Serialnumber::where('deviceId', $id)->delete();
		$removeserials = SerialnumberDetail::where('deviceId', $id)->delete();
		$remove = device::where('id', '=', $id)->delete();

		return Redirect::to('admin/devices');
	}

	public function search(Request $request) {
		$data = $request->all();

		$id = $data['search'][0];
		$manu_name = $data['search'][1];
		$device_name = $data['search'][2];
		$model_name = $data['search'][3];
		$project_name = $data['search'][4];
		$category_name = $data['search'][5];
		$status = $data['search'][6];

		$userid = Auth::user()->id;

		//$organization = user::where('id', '=', $userid)->value('organization');

		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');

		}

		if (count($organization) > 0) {

			$search_devices = device::leftjoin('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
				->leftjoin('projects', 'projects.id', '=', 'device.project_name')
				->leftjoin('category', 'category.id', '=', 'device.category_name')
				->leftjoin('project_clients', 'project_clients.project_id', '=', 'projects.id')
				->select('device.id', 'device.model_name', 'device.status', 'device.device_name', 'manufacturers.manufacturer_name as manu_name', 'projects.project_name', 'category.category_name')
				->whereIn('project_clients.client_name', $organization)
				->where('device.is_delete', '=', '0');

			if (!empty($id)) {
				$search_devices = $search_devices->where('device.id', 'LIKE', $id . '%');
			}
			if (!empty($manu_name)) {
				$search_devices = $search_devices->where('manufacturers.manufacturer_name', 'LIKE', $manu_name . '%');
			}
			if (!empty($device_name)) {
				$search_devices = $search_devices->where('device.device_name', 'LIKE', $device_name . '%');
			}
			if (!empty($model_name)) {
				$search_devices = $search_devices->where('device.model_name', 'LIKE', $model_name . '%');
			}
			if (!empty($project_name)) {
				$search_devices = $search_devices->where('projects.project_name', 'LIKE', $project_name . '%');
			}
			if (!empty($category_name)) {
				$search_devices = $search_devices->where('category.category_name', 'LIKE', $category_name . '%');
			}
			if (!empty($status)) {
				$search_devices = $search_devices->where('device.status', 'LIKE', $status . '%');
			}

			$search_devices = $search_devices->orderBy('device.id', 'DESC')->groupBy('device.id')->get();

		} else {

			$search_devices = device::leftjoin('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
				->leftjoin('projects', 'projects.id', '=', 'device.project_name')
				->leftjoin('category', 'category.id', '=', 'device.category_name')
				->select('device.id', 'device.model_name', 'device.device_name', 'manufacturers.manufacturer_name as manu_name', 'projects.project_name', 'category.category_name', 'device.status')
				->where('device.is_delete', '=', '0');

			if (!empty($id)) {
				$search_devices = $search_devices->where('device.id', 'LIKE', $id . '%');
			}
			if (!empty($manu_name)) {
				$search_devices = $search_devices->where('manufacturers.manufacturer_name', 'LIKE', $manu_name . '%');
			}
			if (!empty($device_name)) {
				$search_devices = $search_devices->where('device.device_name', 'LIKE', $device_name . '%');
			}
			if (!empty($model_name)) {
				$search_devices = $search_devices->where('device.model_name', 'LIKE', $model_name . '%');
			}
			if (!empty($project_name)) {
				$search_devices = $search_devices->where('projects.project_name', 'LIKE', $project_name . '%');
			}
			if (!empty($category_name)) {
				$search_devices = $search_devices->where('category.category_name', 'LIKE', $category_name . '%');
			}
			if (!empty($status)) {
				$search_devices = $search_devices->where('device.status', 'LIKE', $status . '%');
			}

			$search_devices = $search_devices->orderBy('device.id', 'DESC')->get();
		}

		$data = $search_devices;

		if (count($data)) {
			return [
				'value' => $data,
				'status' => TRUE,
			];
		} else {
			return [
				'value' => 'No Result Found',
				'status' => FALSE,
			];
		}

	}

	public function searchclientprice(Request $request) {
		$data = $request->all();

		$id = $data['deviceId'];
		$client_name = $data['clientsearch'][0];
		$unit_cost = $data['clientsearch'][1];
		$bulk_unit_cost = $data['clientsearch'][2];
		$unit_rep_cost = $data['clientsearch'][3];
		$unit_repless_discount = $data['clientsearch'][4];
		$system_cost = $data['clientsearch'][5];
		$bulk_system_cost = $data['clientsearch'][6];
		$cco = $data['clientsearch'][7];
		$cco_discount = $data['clientsearch'][8];
		$system_repless_cost = $data['clientsearch'][9];
		$system_repless_discount = $data['clientsearch'][10];
		$remain_bulk = $data['clientsearch'][11];
		$remain_system_bulk = $data['clientsearch'][12];
		$reimbursement = $data['clientsearch'][13];

		$userid = Auth::user()->id;
		//$organization = user::where('id', '=', $userid)->value('organization');

		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');

		}

		if (count($organization) > 0) {

			$search_client_prices = client_price::join('clients', 'clients.id', '=', 'client_price.client_name')
				->select('client_price.*', 'clients.client_name', 'client_price.client_name as client')
				->where('client_price.device_id', '=', $id)
				->where('client_price.is_delete', '=', 0)
				->whereIn('client_price.client_name', $organization);

			if (!empty($client_name)) {
				$search_client_prices = $search_client_prices->where('clients.client_name', 'LIKE', $client_name . '%');
			}
			if (!empty($unit_cost)) {
				$search_client_prices = $search_client_prices->where('unit_cost', 'LIKE', $unit_cost . '%');
			}
			if (!empty($bulk_unit_cost)) {
				$search_client_prices = $search_client_prices->where('bulk_unit_cost', 'LIKE', $bulk_unit_cost . '%');
			}
			if (!empty($unit_rep_cost)) {
				$search_client_prices = $search_client_prices->where('unit_rep_cost', 'LIKE', $unit_rep_cost . '%');
			}
			if (!empty($unit_repless_discount)) {
				$search_client_prices = $search_client_prices->where('unit_repless_discount', 'LIKE', $unit_repless_discount . '%');
			}
			if (!empty($system_cost)) {
				$search_client_prices = $search_client_prices->where('system_cost', 'LIKE', $system_cost . '%');
			}
			if (!empty($bulk_system_cost)) {
				$search_client_prices = $search_client_prices->where('bulk_system_cost', 'LIKE', $bulk_system_cost . '%');
			}
			if (!empty($cco)) {
				$search_client_prices = $search_client_prices->where('cco', 'LIKE', $cco . '%');
			}
			if (!empty($cco_discount)) {
				$search_client_prices = $search_client_prices->where('cco_discount', 'LIKE', $cco_discount . '%');
			}
			if (!empty($system_repless_cost)) {
				$search_client_prices = $search_client_prices->where('system_repless_cost', 'LIKE', $system_repless_cost . '%');
			}
			if (!empty($system_repless_discount)) {
				$search_client_prices = $search_client_prices->where('system_repless_discount', 'LIKE', $system_repless_discount . '%');
			}
			if (!empty($remain_bulk)) {
				$search_client_prices = $search_client_prices->where('bulk', 'LIKE', $remain_bulk . '%');
			}
			if (!empty($remain_system_bulk)) {
				$search_client_prices = $search_client_prices->where('system_bulk', 'LIKE', $remain_system_bulk . '%');
			}
			if (!empty($reimbursement)) {
				$search_client_prices = $search_client_prices->where('reimbursement', 'LIKE', $reimbursement . '%');
			}

			$search_client_prices = $search_client_prices->orderBy('client_price.id', 'DESC')->get();

		} else {
			$search_client_prices = client_price::join('clients', 'clients.id', '=', 'client_price.client_name')
				->select('client_price.*', 'clients.client_name', 'client_price.client_name as client')
				->where('client_price.device_id', '=', $id)
				->where('client_price.is_delete', '=', 0);

			if (!empty($client_name)) {
				$search_client_prices = $search_client_prices->where('clients.client_name', 'LIKE', $client_name . '%');
			}
			if (!empty($unit_cost)) {
				$search_client_prices = $search_client_prices->where('unit_cost', 'LIKE', $unit_cost . '%');
			}
			if (!empty($bulk_unit_cost)) {
				$search_client_prices = $search_client_prices->where('bulk_unit_cost', 'LIKE', $bulk_unit_cost . '%');
			}
			if (!empty($unit_rep_cost)) {
				$search_client_prices = $search_client_prices->where('unit_rep_cost', 'LIKE', $unit_rep_cost . '%');
			}
			if (!empty($unit_repless_discount)) {
				$search_client_prices = $search_client_prices->where('unit_repless_discount', 'LIKE', $unit_repless_discount . '%');
			}
			if (!empty($system_cost)) {
				$search_client_prices = $search_client_prices->where('system_cost', 'LIKE', $system_cost . '%');
			}
			if (!empty($bulk_system_cost)) {
				$search_client_prices = $search_client_prices->where('bulk_system_cost', 'LIKE', $bulk_system_cost . '%');
			}
			if (!empty($cco)) {
				$search_client_prices = $search_client_prices->where('cco', 'LIKE', $cco . '%');
			}
			if (!empty($cco_discount)) {
				$search_client_prices = $search_client_prices->where('cco_discount', 'LIKE', $cco_discount . '%');
			}
			if (!empty($system_repless_cost)) {
				$search_client_prices = $search_client_prices->where('system_repless_cost', 'LIKE', $system_repless_cost . '%');
			}
			if (!empty($system_repless_discount)) {
				$search_client_prices = $search_client_prices->where('system_repless_discount', 'LIKE', $system_repless_discount . '%');
			}
			if (!empty($remain_bulk)) {
				$search_client_prices = $search_client_prices->where('bulk', 'LIKE', $remain_bulk . '%');
			}
			if (!empty($remain_system_bulk)) {
				$search_client_prices = $search_client_prices->where('system_bulk', 'LIKE', $remain_system_bulk . '%');
			}
			if (!empty($reimbursement)) {
				$search_client_prices = $search_client_prices->where('reimbursement', 'LIKE', $reimbursement . '%');
			}

			$search_client_prices = $search_client_prices->orderBy('client_price.id', 'DESC')->get();

		}

		foreach ($search_client_prices as $search_client_price) {

			$deviceid = device::where('id', '=', $search_client_price->device_id)->first();

			/*Bulk Count end*/

			$search_client_price->remain_bulk = $search_client_price->bulk;
			$search_client_price->remain_system_bulk = $search_client_price->system_bulk;
		}

		$data = $search_client_prices;

		if (count($data)) {
			return [
				'value' => $data,
				'status' => TRUE,
			];
		} else {
			return [
				'value' => 'No Result Found',
				'status' => FALSE,
			];
		}

	}

	public function clientprice(Request $request, $id) {
		$deviceid = $id;
		$projectname = device::where('id', '=', $deviceid)->where('is_delete', '=', '0')->value('project_name');
		$check_clientname = client_price::where('device_id', '=', $id)->get();

		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');
		}

		if (count($organization) > 0) {

			$check_clientname = client_price::where('device_id', '=', $id)
				->whereIn('client_name', $organization)
				->get();
		}
		$clientname = [];
		foreach ($check_clientname as $clients) {
			$clientname[] = $clients->client_name;

		}

		$manufacturer = ['0' => 'Client Name']
		 + project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')
			->where('project_clients.project_id', '=', $projectname)
			->whereNotIn('project_clients.client_name', $clientname)
			->pluck('clients.client_name', 'clients.id')
			->all();

		if (count($organization) > 0) {
			$manufacturer = ['0' => 'Client Name']
			 + project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')
				->where('project_clients.project_id', '=', $projectname)
				->whereIn('project_clients.client_name', $organization)
				->whereNotIn('project_clients.client_name', $clientname)
				->pluck('clients.client_name', 'clients.id')
				->all();

		}

		return view('pages.addclientprice', compact('deviceid', 'manufacturer'));
	}

	public function clientpricecreate(Request $request) {
		$rules = array(
			'client_name' => 'required|not_in:0',
			'unit_cost' => 'required',
			'system_cost' => 'required',
			// 'order_email' => 'required|not_in:0'
		);
		$bulk_unit_cost_check = Input::get('chk_bulk_unit_cost');

		$unit_cost_check = Input::get('unit_cost_check');
		$system_cost_check = Input::get('system_cost_check');

		$bulk_check = Input::get('chk_bulk');
		$cco_discount_check = Input::get('chk_cco_discount');
		$cco_check = Input::get('chk_cco');
		$unit_rep_cost_check = Input::get('chk_unit_rep_cost');
		$unit_rep_discount_check = Input::get('chk_unit_rep_discount');
		$bulk_system_cost_check = Input::get('chk_bulk_system_cost');
		$system_rep_cost_check = Input::get('chk_system_rep_cost');
		$system_rep_discount_check = Input::get('chk_system_rep_discount');
		$reimbursement_check = Input::get('chk_reimbursement');
		$system_bulk_check = Input::get('system_bulk_check');
		$unit_cost_delta_check = Input::get('unit_cost_delta_check');
		$cco_delta_check = Input::get('cco_delta_check');
		$cco_discount_delta_check = Input::get('cco_discount_delta_check');
		$unit_repless_delta_check = Input::get('unit_repless_delta_check');
		$unit_repless_discount_delta_check = Input::get('unit_repless_discount_delta_check');
		$system_cost_delta_check = Input::get('system_cost_delta_check');
		$system_repless_delta_check = Input::get('system_repless_delta_check');
		$system_repless_discount_delta_check = Input::get('system_repless_discount_delta_check');
		$reimbursement_delta_check = Input::get('reimbursement_delta_check');

		/*Highlight*/
		$unit_cost_highlight = Input::get('unit_cost_highlight');
		$bulk_highlight = Input::get('bulk_highlight');
		$cco_highlight = Input::get('cco_highlight');
		$cco_discount_highlight = Input::get('cco_discount_highlight');
		$unit_repless_highlight = Input::get('unit_repless_highlight');
		$unit_repless_discount_highlight = Input::get('unit_repless_discount_highlight');
		$system_cost_highlight = Input::get('system_cost_highlight');
		$system_bulk_highlight = Input::get('system_bulk_highlight');
		$system_repless_highlight = Input::get('system_repless_highlight');
		$system_repless_discount_highlight = Input::get('system_repless_discount_highlight');
		$reimbursement_highlight = Input::get('reimbursement_highlight');

		/*Highlight Section Start*/
		if ($unit_cost_highlight != "True") {
			$unit_cost_highlight = "False";
		}

		if ($bulk_highlight != "True") {
			$bulk_highlight = "False";
		}

		if ($cco_highlight != "True") {
			$cco_highlight = "False";
		}

		if ($cco_discount_highlight != "True") {
			$cco_discount_highlight = "False";
		}

		if ($unit_repless_highlight != "True") {
			$unit_repless_highlight = "False";
		}

		if ($unit_repless_discount_highlight != "True") {
			$unit_repless_discount_highlight = "False";
		}

		if ($system_cost_highlight != "True") {
			$system_cost_highlight = "False";
		}

		if ($system_bulk_highlight != "True") {
			$system_bulk_highlight = "False";
		}

		if ($system_repless_highlight != "True") {
			$system_repless_highlight = "False";
		}

		if ($system_repless_discount_highlight != "True") {
			$system_repless_discount_highlight = "False";
		}

		if ($reimbursement_highlight != "True") {
			$reimbursement_highlight = "False";
		}

		/*Highlight Section End*/

		/*Delta Section start*/
		if ($unit_cost_delta_check != "True") {
			$unit_cost_delta_check = "False";
		}

		if ($cco_delta_check != "True") {
			$cco_delta_check = "False";
		}

		if ($cco_discount_delta_check != "True") {
			$cco_discount_delta_check = "False";
		}

		if ($unit_repless_delta_check != "True") {
			$unit_repless_delta_check = "False";
		}

		if ($unit_repless_discount_delta_check != "True") {
			$unit_repless_discount_delta_check = "False";
		}

		if ($system_cost_delta_check != "True") {
			$system_cost_delta_check = "False";
		}

		if ($system_repless_delta_check != "True") {
			$system_repless_delta_check = "False";
		}

		if ($system_repless_discount_delta_check != "True") {
			$system_repless_discount_delta_check = "False";
		}

		if ($reimbursement_delta_check != "True") {
			$reimbursement_delta_check = "False";
		}
		/*Delta Section End*/

		if ($bulk_unit_cost_check != "True") {
			$bulk_unit_cost_check = "False";
		}

		if ($cco_discount_check != "True") {
			$cco_discount_check = "False";
		}

		if ($cco_check != "True") {
			$cco_check = "False";
		}

		if ($bulk_check != "True") {
			$bulk_check = "False";
		}

		if ($unit_rep_cost_check != "True") {
			$unit_rep_cost_check = "False";
		}

		if ($unit_rep_discount_check != "True") {
			$unit_rep_discount_check = "False";
		}

		if ($system_bulk_check != "True") {
			$system_bulk_check = "False";
		}

		if ($bulk_system_cost_check != "True") {
			$bulk_system_cost_check = "False";
		}

		if ($system_rep_cost_check != "True") {
			$system_rep_cost_check = "False";
		}

		if ($system_rep_discount_check != "True") {
			$system_rep_discount_check = "False";
		}

		if ($reimbursement_check != "True") {
			$reimbursement_check = "False";
		}

		if ($reimbursement_check != "True") {
			$reimbursement_check = "False";
		}

		if ($unit_cost_check != "True") {
			$unit_cost_check = "False";
		}

		if ($system_cost_check != "True") {
			$system_cost_check = "False";
		}

		$clients = client_price::where('device_id', Input::get('device_id'))->where('client_name', Input::get('manufacturer_name'))->get();
		if (count($clients) > 0) {
			return redirect()->back()
				->withErrors(['device_id' => 'You Entred Duplicate Record Please Try Another once!!']);
		}

		$insertdata = array(
			"device_id" => Input::get('device_id'),
			"client_name" => Input::get('manufacturer_name'),
			"unit_cost" => Input::get('unit_cost') == "" ? '0' : Input::get('unit_cost'),
			"unit_cost_check" => $unit_cost_check,
			"system_cost_check" => $system_cost_check,
			"bulk_unit_cost" => Input::get('bulk_unit_cost') == "" ? '0' : Input::get('bulk_unit_cost'),
			"bulk_unit_cost_check" => $bulk_unit_cost_check,
			"bulk" => Input::get('bulk') == "" ? '0' : Input::get('bulk'),
			"bulk_check" => $bulk_check,
			"cco" => Input::get('cco') == "" ? '0' : Input::get('cco'),
			"cco_check" => $cco_check,
			"cco_discount" => Input::get('cco_discount') == "" ? '0' : Input::get('cco_discount'),
			"cco_discount_check" => $cco_discount_check,
			"unit_rep_cost" => Input::get('unit_rep_cost') == "" ? '0' : Input::get('unit_rep_cost'),
			"unit_rep_cost_check" => $unit_rep_cost_check,
			"unit_repless_discount" => Input::get('unit_rep_discount') == "" ? '0' : Input::get('unit_rep_discount'),
			"unit_repless_discount_check" => $unit_rep_discount_check,
			"system_cost" => Input::get('system_cost') == "" ? '0' : Input::get('system_cost'),
			"system_bulk" => Input::get('system_bulk') == "" ? '0' : Input::get('system_bulk'),
			"system_bulk_check" => $system_bulk_check,
			"bulk_system_cost" => Input::get('bulk_system_cost') == "" ? '0' : Input::get('bulk_system_cost'),
			"bulk_system_cost_check" => $bulk_system_cost_check,
			"system_repless_cost" => Input::get('system_rep_cost') == "" ? '0' : Input::get('system_rep_cost'),
			"system_repless_cost_check" => $system_rep_cost_check,
			"system_repless_discount" => Input::get('system_rep_discount') == "" ? '0' : Input::get('system_rep_discount'),
			"system_repless_discount_check" => $system_rep_discount_check,
			"reimbursement" => Input::get('reimbursement') == "" ? '0' : Input::get('reimbursement'),
			"reimbursement_check" => $reimbursement_check,
			"unit_cost_delta_check" => $unit_cost_delta_check,
			"cco_delta_check" => $cco_delta_check,
			"cco_discount_delta_check" => $cco_discount_delta_check,
			"unit_repless_delta_check" => $unit_repless_delta_check,
			"unit_repless_discount_delta_check" => $unit_repless_discount_delta_check,
			"system_cost_delta_check" => $system_cost_delta_check,
			"system_repless_delta_check" => $system_repless_delta_check,
			"system_repless_discount_delta_check" => $system_repless_discount_delta_check,
			"reimbursement_delta_check" => $reimbursement_delta_check,
			"unit_cost_highlight" => $unit_cost_highlight,
			"bulk_highlight" => $bulk_highlight,
			"cco_highlight" => $cco_highlight,
			"cco_discount_highlight" => $cco_discount_highlight,
			"unit_repless_highlight" => $unit_repless_highlight,
			"unit_repless_discount_highlight" => $unit_repless_discount_highlight,
			"system_cost_highlight" => $system_cost_highlight,
			"system_bulk_highlight" => $system_bulk_highlight,
			"system_repless_highlight" => $system_repless_highlight,
			"system_repless_discount_highlight" => $system_repless_discount_highlight,
			"reimbursement_highlight" => $reimbursement_highlight,
			"is_delete" => "0",
			"is_created" => Carbon::now(),
			"is_updated" => Carbon::now(),
			"created_at" => Carbon::now(),
			"updated_at" => Carbon::now(),

		);
		$validator = Validator::make($insertdata, $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		} else {
			if (Input::get('unit_cost') >= Input::get('system_cost')) {

				return Redirect::back()->withErrors(['unit_cost' => 'System cost should not be less than unit cost.'])->withInput();
			} else {
				$insert_clientprice = 0;
				$insert_clientprice = client_price::insert($insertdata);
				if ($insert_clientprice >= 0) {
					return Redirect::to('admin/devices/view/' . Input::get('device_id') . '#1');
				} else {
					echo "Cancle";
				}
			}
		}
	}

	public function clientpriceedit(Request $request, $id) {
		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');
		}

		$clientprice = client_price::FindOrFail($id);
		$deviceid = $clientprice->device_id;

		$device = device::where('id', $deviceid)->first();

		$clientprice->bulk = $clientprice->bulk;
		$clientprice->system_bulk = $clientprice->system_bulk;
		$clientprice->bulk = $clientprice->bulk < 0 ? '0' : $clientprice->bulk;
		$clientprice->sytem_bulk = $clientprice->bulk < 0 ? '0' : $clientprice->system_bulk;

		$projectname = device::where('id', '=', $deviceid)->where('is_delete', '=', '0')->value('project_name');
		$check_clientname = client_price::where('device_id', '=', $deviceid)
			->where('client_name', '!=', $clientprice->client_name)
			->get();

		$clientname = [];
		foreach ($check_clientname as $clients) {
			$clientname[] = $clients->client_name;

		}

		$manufacturer = ['0' => 'Client Name']
		 + project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')
			->where('project_clients.project_id', '=', $projectname)
			->whereNotIn('project_clients.client_name', $clientname)
			->pluck('clients.client_name', 'clients.id')
			->all();

		if (count($organization) > 0) {
			$manufacturer = ['0' => 'Client Name']
			 + project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')
				->where('project_clients.project_id', '=', $projectname)
				->whereIn('project_clients.client_name', $organization)
				->whereNotIn('project_clients.client_name', $clientname)
				->pluck('clients.client_name', 'clients.id')
				->all();

		}

		$orderemail = user::where('roll', '=', 4)->pluck('email', 'id')->all();
		// dd($clientprice);
		return view('pages.editclientprice', compact('manufacturer', 'clientprice', 'orderemail'));
	}

	public function clientpriceupdate(Request $request, $id) {
		$rules = array(
			'client_name' => 'required|not_in:0',
			'unit_cost' => 'required',
			'system_cost' => 'required',
			// 'order_email' => 'required|not_in:0'
		);
		// dd($request->all());
		$bulk_unit_cost_check = Input::get('chk_bulk_unit_cost');
		$unit_cost_check = Input::get('unit_cost_check');
		$system_cost_check = Input::get('system_cost_check');
		$bulk_check = Input::get('chk_bulk');
		$cco_discount_check = Input::get('chk_cco_discount');
		$cco_check = Input::get('chk_cco');
		$unit_rep_cost_check = Input::get('chk_unit_rep_cost');
		$unit_rep_discount_check = Input::get('chk_unit_rep_discount');
		$bulk_system_cost_check = Input::get('chk_bulk_system_cost');
		$system_rep_cost_check = Input::get('chk_system_rep_cost');
		$system_rep_discount_check = Input::get('chk_system_rep_discount');
		$reimbursement_check = Input::get('chk_reimbursement');
		$system_bulk_check = Input::get('system_bulk_check');
		$unit_cost_delta_check = Input::get('unit_cost_delta_check');
		$cco_delta_check = Input::get('cco_delta_check');
		$cco_discount_delta_check = Input::get('cco_discount_delta_check');
		$unit_repless_delta_check = Input::get('unit_repless_delta_check');
		$unit_repless_discount_delta_check = Input::get('unit_repless_discount_delta_check');
		$system_cost_delta_check = Input::get('system_cost_delta_check');
		$system_repless_delta_check = Input::get('system_repless_delta_check');
		$system_repless_discount_delta_check = Input::get('system_repless_discount_delta_check');
		$reimbursement_delta_check = Input::get('reimbursement_delta_check');

		/*Highlight*/
		$unit_cost_highlight = Input::get('unit_cost_highlight');
		$bulk_highlight = Input::get('bulk_highlight');
		$cco_highlight = Input::get('cco_highlight');
		$cco_discount_highlight = Input::get('cco_discount_highlight');
		$unit_repless_highlight = Input::get('unit_repless_highlight');
		$unit_repless_discount_highlight = Input::get('unit_repless_discount_highlight');
		$system_cost_highlight = Input::get('system_cost_highlight');
		$system_bulk_highlight = Input::get('system_bulk_highlight');
		$system_repless_highlight = Input::get('system_repless_highlight');
		$system_repless_discount_highlight = Input::get('system_repless_discount_highlight');
		$reimbursement_highlight = Input::get('reimbursement_highlight');

		/*Highlight Section Start*/
		if ($unit_cost_highlight != "True") {
			$unit_cost_highlight = "False";
		}

		if ($bulk_highlight != "True") {
			$bulk_highlight = "False";
		}

		if ($cco_highlight != "True") {
			$cco_highlight = "False";
		}

		if ($cco_discount_highlight != "True") {
			$cco_discount_highlight = "False";
		}

		if ($unit_repless_highlight != "True") {
			$unit_repless_highlight = "False";
		}

		if ($unit_repless_discount_highlight != "True") {
			$unit_repless_discount_highlight = "False";
		}

		if ($system_cost_highlight != "True") {
			$system_cost_highlight = "False";
		}

		if ($system_bulk_highlight != "True") {
			$system_bulk_highlight = "False";
		}

		if ($system_repless_highlight != "True") {
			$system_repless_highlight = "False";
		}

		if ($system_repless_discount_highlight != "True") {
			$system_repless_discount_highlight = "False";
		}

		if ($reimbursement_highlight != "True") {
			$reimbursement_highlight = "False";
		}

		/*Highlight Section End*/

		$clientprice = client_price::where('id', '=', $id)->get();
		foreach ($clientprice as $client_price) {
			$device_id = $client_price->device_id;
			$clientname = $client_price->client_name;
			$bulk = $client_price->bulk;
		}

		$bulk = Input::get('bulk');
		$system_bulk = Input::get('system_bulk');

		if ($unit_cost_delta_check != "True") {
			$unit_cost_delta_check = "False";
		}

		if ($cco_delta_check != "True") {
			$cco_delta_check = "False";
		}

		if ($cco_discount_delta_check != "True") {
			$cco_discount_delta_check = "False";
		}

		if ($unit_repless_delta_check != "True") {
			$unit_repless_delta_check = "False";
		}

		if ($unit_repless_discount_delta_check != "True") {
			$unit_repless_discount_delta_check = "False";
		}

		if ($system_cost_delta_check != "True") {
			$system_cost_delta_check = "False";
		}

		if ($system_repless_delta_check != "True") {
			$system_repless_delta_check = "False";
		}

		if ($system_repless_discount_delta_check != "True") {
			$system_repless_discount_delta_check = "False";
		}

		if ($reimbursement_delta_check != "True") {
			$reimbursement_delta_check = "False";
		}

		if ($bulk_unit_cost_check != "True") {
			$bulk_unit_cost_check = "False";
		}

		if ($system_bulk_check != "True") {
			$system_bulk_check = "False";
		}

		if ($bulk_check != "True") {
			$bulk_check = "False";
		}

		if ($cco_discount_check != "True") {
			$cco_discount_check = "False";
		}

		if ($cco_check != "True") {
			$cco_check = "False";
		}

		if ($unit_rep_cost_check != "True") {
			$unit_rep_cost_check = "False";
		}

		if ($unit_rep_discount_check != "True") {
			$unit_rep_discount_check = "False";
		}

		if ($bulk_system_cost_check != "True") {
			$bulk_system_cost_check = "False";
		}

		if ($system_rep_cost_check != "True") {
			$system_rep_cost_check = "False";
		}

		if ($system_rep_discount_check != "True") {
			$system_rep_discount_check = "False";
		}

		if ($reimbursement_check != "True") {
			$reimbursement_check = "False";
		}

		if ($unit_cost_check != "True") {
			$unit_cost_check = "False";
		}

		if ($system_cost_check != "True") {
			$system_cost_check = "False";
		}

		$updatedata = array(
			"client_name" => Input::get('client_name'),
			"unit_cost" => Input::get('unit_cost') == "" ? '0' : Input::get('unit_cost'),
			"unit_cost_check" => $unit_cost_check,
			"system_cost_check" => $system_cost_check,
			"system_bulk" => $system_bulk,
			"system_bulk_check" => $system_bulk_check,
			"bulk_unit_cost" => Input::get('bulk_unit_cost') == "" ? '0' : Input::get('bulk_unit_cost'),
			"bulk_unit_cost_check" => $bulk_unit_cost_check,
			"bulk" => $bulk,
			"bulk_check" => $bulk_check,
			"cco" => Input::get('cco') == "" ? '0' : Input::get('cco'),
			"cco_check" => $cco_check,
			"cco_discount" => Input::get('cco_discount') == "" ? '0' : Input::get('cco_discount'),
			"cco_discount_check" => $cco_discount_check,
			"unit_rep_cost" => Input::get('unit_rep_cost') == "" ? '0' : Input::get('unit_rep_cost'),
			"unit_rep_cost_check" => $unit_rep_cost_check,
			"unit_repless_discount" => Input::get('unit_repless_discount') == "" ? '0' : Input::get('unit_repless_discount'),
			"unit_repless_discount_check" => $unit_rep_discount_check,
			"system_cost" => Input::get('system_cost') == "" ? '0' : Input::get('system_cost'),
			"bulk_system_cost" => Input::get('bulk_system_cost') == "" ? '0' : Input::get('bulk_system_cost'),
			"bulk_system_cost_check" => $bulk_system_cost_check,
			"system_repless_cost" => Input::get('system_repless_cost') == "" ? '0' : Input::get('system_repless_cost'),
			"system_repless_cost_check" => $system_rep_cost_check,
			"system_repless_discount" => Input::get('system_repless_discount') == "" ? '0' : Input::get('system_repless_discount'),
			"system_repless_discount_check" => $system_rep_discount_check,
			"reimbursement" => Input::get('reimbursement') == "" ? '0' : Input::get('reimbursement'),
			"reimbursement_check" => $reimbursement_check,
			"unit_cost_delta_check" => $unit_cost_delta_check,
			"cco_delta_check" => $cco_delta_check,
			"cco_discount_delta_check" => $cco_discount_delta_check,
			"unit_repless_delta_check" => $unit_repless_delta_check,
			"unit_repless_discount_delta_check" => $unit_repless_discount_delta_check,
			"system_cost_delta_check" => $system_cost_delta_check,
			"system_repless_delta_check" => $system_repless_delta_check,
			"system_repless_discount_delta_check" => $system_repless_discount_delta_check,
			"reimbursement_delta_check" => $reimbursement_delta_check,
			"unit_cost_highlight" => $unit_cost_highlight,
			"bulk_highlight" => $bulk_highlight,
			"cco_highlight" => $cco_highlight,
			"cco_discount_highlight" => $cco_discount_highlight,
			"unit_repless_highlight" => $unit_repless_highlight,
			"unit_repless_discount_highlight" => $unit_repless_discount_highlight,
			"system_cost_highlight" => $system_cost_highlight,
			"system_bulk_highlight" => $system_bulk_highlight,
			"system_repless_highlight" => $system_repless_highlight,
			"system_repless_discount_highlight" => $system_repless_discount_highlight,
			"reimbursement_highlight" => $reimbursement_highlight,
			"is_delete" => "0",
//            "is_created" => Carbon::now(),
			"is_updated" => Carbon::now(),
//            "created_at" => Carbon::now(),
			"updated_at" => Carbon::now(),
		);

		$validator = Validator::make($updatedata, $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		} else {
			if (Input::get('unit_cost') >= Input::get('system_cost')) {

				return Redirect::back()->withErrors(['unit_cost' => 'System cost should not be less than unit cost.']);
			} else {

				$update_clientprice = 0;
				$update_clientprice = DB::table('client_price')->where('id', '=', $id)->update($updatedata);
				$get_deviceid = client_price::where('id', '=', $id)->value('device_id');
				if ($update_clientprice >= 0) {
					return Redirect::to('admin/devices/view/' . $get_deviceid . '#1');
				} else {
					echo "Cancle";
				}
			}
		}
	}

	public function getcategory() {
		$projectid = Input::get('projectid');
		$getcategory = category::where('is_delete', '=', 0)->where('project_name', '=', $projectid)->get();
		$data = $getcategory;

		if (count($data)) {
			return [
				'value' => $data,
				'status' => TRUE,
			];
		} else {
			return [
				'value' => 'No result Found',
				'status' => FALSE,
			];
		}

	}

	public function priceremove($id) {
		$data = client_price::where('id', $id)->first();
		$remove = client_price::where('id', $id)->delete();
		return redirect('admin/devices/view/' . $data['device_id'] . '#1');
		// $removedata = array('is_delete' => '1');
		// $remove = DB::table('client_price')->where('id', '=', $id)->delete();
		// return Redirect::to('admin/devices');
	}

	public function customfieldremove($id) {
		$remove = DB::table('device_custom_field')->where('id', '=', $id)->delete();
		return Redirect::back();
	}

	public function export(Request $request) {
		$deviceid = $request->all();

		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');

		}

		$device_view = device::leftjoin('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
			->leftjoin('projects', 'projects.id', '=', 'device.project_name')
			->leftjoin('category', 'category.id', '=', 'device.category_name')
			->select('device.id', 'device.model_name', 'device.status', 'device.device_name', 'manufacturers.manufacturer_name as manu_name', 'projects.project_name', 'category.category_name')
			->whereIn('device.id', $deviceid['chk_device'])
			->get();

		if (count($organization) > 0) {
			$client_prices = client_price::leftjoin('clients', 'clients.id', '=', 'client_price.client_name')
				->select('client_price.*', 'clients.client_name')
				->whereIn('client_price.device_id', $deviceid['chk_device'])
				->where('client_price.is_delete', '=', 0)
				->whereIn('client_price.client_name', $organization)
				->orderBy('client_price.id', 'DESC')
				->get();
		} else {

			$client_prices = client_price::leftjoin('clients', 'clients.id', '=', 'client_price.client_name')
				->select('client_price.*', 'clients.client_name')
				->whereIn('client_price.device_id', $deviceid['chk_device'])
				->where('client_price.is_delete', '=', 0)
				->orderBy('client_price.id', 'DESC')
				->get();
		}

		/*Serial Number Export in device export sheet 08-09-2017 11:00 AM Start*/
		if (count($organization) > 0) {
			$serialNumber = SerialnumberDetail::whereIn('deviceId', $deviceid['chk_device'])
				->whereIn('clientId', $organization)
				->orderBy('deviceId', 'clientId')
				->get();
		} else {

			$serialNumber = SerialnumberDetail::whereIn('deviceId', $deviceid['chk_device'])
				->orderBy('deviceId', 'clientId')
				->get();
		}

		/*Serial Number Export in device export sheet 08-09-2017 11:00 AM End*/

		$device_data = array();
		foreach ($device_view as $row) {

			$device_data[] = [
				$row['id'],
				$row['manu_name'],
				$row['device_name'],
				$row['model_name'],
				$row['project_name'],
				$row['category_name'],
				$row['status'],
			];
		}
		$client_price_data = array();
		foreach ($client_prices as $row) {
			$client_price_data[] = [
				$row->devices->manufacturer['manufacturer_name'],
				$row->devices->categories['category_name'],
				$row->devices->device_name,
				$row->devices->model_name,
				$row->devices->level_name,
				$row['client_name'],
				$row['unit_cost'],
				$row['bulk_unit_cost'],
				$row['unit_rep_cost'],
				$row['unit_repless_discount'],
				$row['system_cost'],
				$row['bulk_system_cost'],
				$row['cco_discount'],
				$row['system_repless_cost'],
				$row['system_repless_discount'],
				$row['bulk'],
				$row['system_bulk'],
				$row['reimbursement'],
			];
		}

		/*Serial number Export loop*/
		$serial_data = array();
		foreach ($serialNumber as $item) {
			$serial_data[] = [
				$item->client['client_name'],
				$item->devices->device_name,
				$item->devices->model_name,
				$item->devices->manufacturer['manufacturer_name'],
				$item->devices->categories['category_name'],
				$item->devices->level_name,
				$item['serialNumber'],
				$item['status'],
			];
		}

		$myFile = Excel::create('Devices', function ($excel) use ($device_data, $client_price_data, $serial_data) {

			$excel->setTitle('Devices');
			$excel->setCreator('Admin')->setCompany('Neptune-PPA');
			$excel->setDescription('Devices file');

			$excel->sheet('Devices Details', function ($sheet) use ($device_data) {
				$sheet->row(1, array('Id', 'Menu Name', 'Device Name', 'Model Name', 'Project Name', 'Category Name', 'Status'));
				$sheet->row($sheet->getHighestRow(), function ($row) {
					$row->setFontWeight('bold');
				});
				foreach ($device_data as $row) {
					$sheet->appendRow($row);
				}
			});

			$excel->sheet('Client Price Details', function ($sheet) use ($client_price_data) {
				$sheet->row(1, array('Manufacturer Name', 'Device Category', 'Device Name', 'Device Model No', 'Device Level', 'Client Name', 'Unit Cost', 'Dis. Unit Cost%', 'Repless Disc.', 'Repless Disc%', 'System Cost', 'Disc.Sys.Cost%', 'CCO Disc. %', 'Repless Disc.', 'Repless Disc.%', 'Bulk', 'System Bulk', 'Reimb.'));
				$sheet->row($sheet->getHighestRow(), function ($row) {
					$row->setFontWeight('bold');
				});
				foreach ($client_price_data as $row) {
					$sheet->appendRow($row);
				}
			});

			/*Serial Number Tab*/

			$excel->sheet('Serial Number Details', function ($sheet) use ($serial_data) {
				$sheet->row(1, array('Client Name', 'Device Name', 'Model Number', 'Manufacturer Name', 'Device Category', 'Device Level', 'Serial Number', 'Status'));
				$sheet->row($sheet->getHighestRow(), function ($row) {
					$row->setFontWeight('bold');
				});
				foreach ($serial_data as $row) {
					$sheet->appendRow($row);
				}
			});
		});

		$myFile = $myFile->string('xlsx');
		$response = array(
			'name' => "Device_list", //no extention needed
			'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($myFile), //mime type of used format
		);
		return response()->json($response);
		exit();
	}

	public function import() {
		if (Input::hasFile('device_import')) {
			$path = Input::file('device_import')->getRealPath();
			$data = Excel::load($path, function ($reader) {

			})->get();

			$wrongdata = array();

			if (!empty($data) && $data->count()) {
				foreach ($data as $key => $value) {

					$level = array("Advanced Level", "Entry Level");

					$overallvalue = array("Low", "Medium", "High");
					$statuscheck = array("Enabled", "Disabled");

					if (in_array($value->level_name, $level)) {
						$flag1 = true;
					} else {
						$value->level_name = $value->level_name . "(Wrong data)";
						$flag1 = false;
					}

					$flag8 = false;
					$flag11 = false;
					$flag12 = false;
					$flag13 = false;
					$flag14 = false;

					if (!empty($value->overall_value)) {

						if (in_array($value->overall_value, $overallvalue)) {
							$flag8 = true;
						} else {
							$value->overall_value = $value->overall_value . "(Wrong data)";
							$flag8 = false;
						}
					} else {
						$value->overall_value = "Medium";
						$flag8 = true;
					}

					if (in_array($value->status, $statuscheck)) {
						$flag10 = true;
					} else {
						$value->status = $value->status . "(Wrong data)";
						$flag10 = false;
					}

					if (!empty($value->longevity)) {

						if (preg_match("/^[1-9][0-9]*$/", $value->longevity)) {
							$flag11 = true;
						} else {
							$value->longevity = $value->longevity . "(Wrong data)";
							$flag11 = false;
						}
					} else {
						$value->longevity = 0;
						$flag11 = true;
					}

					if (!empty($value->shock)) {
						if (preg_match("/^[0-9]{1,3}([\/][0-9]{1,3})?$/", $value->shock)) {
							$flag12 = true;
						} else {
							$value->shock = $value->shock . "(Wrong data)";
							$flag12 = false;
						}
					} else {

						$value->shock = 0;
						$flag12 = true;
					}

					if (!empty($value->size)) {
						if (preg_match("/^[0-9]{1,3}([\/][0-9]{1,3})?$/", $value->size)) {
							$flag13 = true;
						} else {
							$value->size = $value->size . "(Wrong data)";
							$flag13 = false;
						}
					} else {
						$value->size = 0;
						$flag13 = true;
					}

					if (!empty($value->url)) {
						if (preg_match('/^(http|https):\\/\\/[a-z0-9]+([\\-\\.]{1}[a-z0-9]+)*\\.[a-z]{2,5}' . '((:[0-9]{1,5})?\\/.*)?$/i', $value->url)) {
							$flag14 = true;
						} else {
							$value->url = $value->url . "(Wrong data)";
							$flag14 = false;
						}
					} else {
						$value->url = "-";
						$flag14 = true;
					}

					$manufacturer = manufacturers::where('manufacturer_name', '=', $value->manufacturer_name)->value('id');
					$project = project::where('project_name', '=', $value->project_name)->value('id');
					$category = category::where('category_name', '=', $value->category_name)->value('id');
					// $repemail = user::where('email', '=', $value->rep_email)->value('id');

					$device_check = device::where('device_name', '=', $value->device_name)->count();
					$model_check = device::where('model_name', '=', $value->model_no)->count();

					if ($manufacturer != "") {
						$flag15 = true;
					} else {
						$manufacturer = $value->manufacturer_name . "(Not available)";
						$flag15 = false;
					}

					if ($project != "") {
						$flag16 = true;
					} else {
						$project = $value->project_name . "(Not available)";
						$flag16 = false;
					}

					if ($category != "") {
						$flag17 = true;
					} else {
						$category = $value->category_name . "(Not available)";
						$flag17 = false;
					}

					if (!empty($value->exclusive)) {
						$exclusive = $value->exclusive;
					} else {
						$exclusive = 0;
					}

					if (!empty($value->research)) {
						$research = $value->research;
					} else {
						$research = 0;
					}

					if (!empty($value->website_page)) {
						$website_page = $value->website_page;
					} else {
						$website_page = 0;
					}

					$insert = [
					    'level_name' => $value->level_name,
						'project_name' => $project,
						'category_name' => $category,
						'manufacturer_name' => $manufacturer,
						'device_name' => $value->device_name,
						'model_name' => $value->model_no,
						'device_image' => "default.jpg",
						'status' => $value->status,
						'exclusive' => $exclusive,
						'longevity' => $value->longevity,
						'shock' => $value->shock,
						'size' => $value->size,
						'research' => $research,
						'website_page' => $website_page,
						'url' => $value->url,
						'overall_value' => $value->overall_value,
					];

					if ($flag1 && $flag8 && $flag10 && $flag11 && $flag12 && $flag13 && $flag14 && $flag15 && $flag16 && $flag17 && $device_check == 0 && $model_check == 0) {

						device::insert($insert);

					} else {

						$wrongdata[] = array('level_name' => $value->level_name,
							'project_name' => $value->project_name,
							'category_name' => $value->category_name,
							'manufacturer_name' => $value->manufacturer_name,
							'device_name' => $value->device_name,
							'model_name' => $value->model_no,
							'device_image' => "default.jpg",
							'status' => $value->status,
							'exclusive' => $exclusive,
							'longevity' => $value->longevity,
							'shock' => $value->shock,
							'size' => $value->size,
							'research' => $research,
							'website_page' => $website_page,
							'url' => $value->url,
							'overall_value' => $value->overall_value,
						);

					}
				}
				$status = true;
				if (count($wrongdata) != 0) {
					$status = false;
					// dd($wrongdata);
					return view('pages.deviceImportError', compact('wrongdata'));
				} else {
					return Redirect::to('admin/devices');
				}

			}
		}
	}

	public function devicefeatures(Request $request, $id) {

		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');

		}

		$deviceid = $id;
		$projectname = device::where('id', '=', $deviceid)->where('is_delete', '=', '0')->value('project_name');
		$devices = device::findOrFail($id);
		$check_clientname = Devicefeatures::where('device_id', '=', $id)->get();

		$clientname = [];
		foreach ($check_clientname as $clients) {
			$clientname[] = $clients->client_name;

		}
		$client_name = ['' => 'Client Name']
		 + project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')
			->where('project_clients.project_id', '=', $projectname)
			->whereNotIn('project_clients.client_name', $clientname)
			->pluck('clients.client_name', 'clients.id')
			->all();

		if (count($organization) > 0) {
			$client_name = ['' => 'Client Name']
			 + project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')
				->where('project_clients.project_id', '=', $projectname)
				->whereIn('project_clients.client_name', $organization)
				->whereNotIn('project_clients.client_name', $clientname)
				->pluck('clients.client_name', 'clients.id')
				->all();

		}

		$custom_field = device_custom_field::where('device_id', '=', $id)->get();
		return view('pages.adddevicefeatures', compact('devices', 'deviceid', 'client_name', 'custom_field'));
	}

	public function devicefeaturesstore(Request $request) {

		$devicefeatures = Devicefeatures::where('device_id', $request->get('device_id'))
			->where('client_name', $request->get('client_name'))->get();

		if (count($devicefeatures) > 0) {
			return redirect()->back()
				->withErrors(['client_name' => 'You Entred Duplicate Record Please Try Another once!!'])
				->withInput();
		}

		$rules = array(
			'client_name' => 'required',
		);

		$longevity_check = $request->get('chk_longevity') == 'True' ? 'True' : 'False';
		$shock_check = $request->get('chk_shock_ct') == 'True' ? 'True' : 'False';
		$size_check = $request->get('chk_size') == 'True' ? 'True' : 'False';
		$research_check = $request->get('chk_research') == 'True' ? 'True' : 'False';
		$site_info_check = $request->get('chk_site_info') == 'True' ? 'True' : 'False';
		$chk_overall_value = $request->get('chk_overall_value') == 'True' ? 'True' : 'False';
		$longevity_delta_check = $request->get('longevity_delta_check') == 'True' ? 'True' : 'False';
		$shock_delta_check = $request->get('shock_delta_check') == 'True' ? 'True' : 'False';
		$size_delta_check = $request->get('size_delta_check') == 'True' ? 'True' : 'False';
		$research_delta_check = $request->get('research_delta_check') == 'True' ? 'True' : 'False';
		$site_info_delta_check = $request->get('site_info_delta_check') == 'True' ? 'True' : 'False';
		$overall_value_delta_check = $request->get('overall_value_delta_check') == 'True' ? 'True' : 'False';

		/*Highlight Check Value*/

		$longevity_highlight = $request->get('longevity_highlight') == 'True' ? 'True' : 'False';
		$shock_highlight = $request->get('shock_highlight') == 'True' ? 'True' : 'False';
		$size_highlight = $request->get('size_highlight') == 'True' ? 'True' : 'False';
		$research_highlight = $request->get('research_highlight') == 'True' ? 'True' : 'False';
		$siteinfo_highlight = $request->get('siteinfo_highlight') == 'True' ? 'True' : 'False';
		$overall_value_highlight = $request->get('overall_value_highlight') == 'True' ? 'True' : 'False';

		$insertdata = array(
			'device_id' => $request->get('device_id'),
			'client_name' => $request->get('client_name'),
			//    'longevity' => $request->get('longevity'),
			'longevity_check' => $longevity_check,
			//    'shock' => $request->get('shock'),
			'shock_check' => $shock_check,
			//    'size' => $request->get('size'),
			'size_check' => $size_check,
			//    'research' => $request->get('research'),
			'research_check' => $research_check,
			//    'site_info' => $request->get('site_info'),
			'siteinfo_check' => $site_info_check,
			//    'url' => $request->get('url'),
			//    'overall_value' => $request->get('overall_value'),
			'overall_value_check' => $chk_overall_value,
			'longevity_delta_check' => $longevity_delta_check,
			'shock_delta_check' => $shock_delta_check,
			'size_delta_check' => $size_delta_check,
			'research_delta_check' => $research_delta_check,
			'site_info_delta_check' => $site_info_delta_check,
			'overall_value_delta_check' => $overall_value_delta_check,
			'longevity_highlight' => $longevity_highlight,
			'shock_highlight' => $shock_highlight,
			'size_highlight' => $size_highlight,
			'research_highlight' => $research_highlight,
			'siteinfo_highlight' => $siteinfo_highlight,
			'overall_value_highlight' => $overall_value_highlight,

		);

		$validator = Validator::make($insertdata, $rules);

		if ($validator->fails()) {
			return back()
				->withErrors($validator);
		}

		$device_id = $request->get('device_id');
		$client_name = $request->get('client_name');
		$customfieldid = $request->get('customhidden');
		$insertcustomfieldcheck = $request->get('chk_field');
		$insertcustomhiddencheck = $request->get('chk_hd_field');
		$insertdeltacheck = $request->get('chk_hd_field_delta_check');
		$inserthighlightcheck = $request->get('chk_hd_field_fileld_highlight');

		for ($i = 0; $i < count($customfieldid); $i++) {
			if ($customfieldid[$i] != "") {

				$insertrecord = array(
					"device_id" => $device_id,
					"client_name" => $client_name,
					"field_check" => $insertcustomhiddencheck[$i] == 'True' ? 'True' : 'False',
					"fileld_delta_check" => $insertdeltacheck[$i] == 'True' ? 'True' : 'False',
					"fileld_highlight" => $inserthighlightcheck[$i] == 'True' ? 'True' : 'False',
					"c_id" => $customfieldid[$i],
					"created_at" => Carbon::now(),
					"updated_at" => Carbon::now(),
				);
				$insert_custom_field = Clientcustomfeatures::insert($insertrecord);

			}
		}

		$features = new Devicefeatures();
		$features->fill($insertdata);
		$features->save();

		return Redirect::to('admin/devices/view/' . $request->get('device_id') . '#2');

	}

	public function devicefeaturesedit(Request $request, $id) {
		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');

		}

		$clientanme = Devicefeatures::where('id', $id)->value('client_name');
		$devicefeatures = device::leftJoin('device_features', 'device_features.device_id', '=', 'device.id')
			->select('device_features.*', 'device.exclusive', 'device.longevity', 'device.shock', 'device.size', 'device.research', 'device.website_page', 'device.url', 'device.overall_value')
			->where('device_features.id', '=', $id)->first();

		$deviceid = Devicefeatures::where('id', $id)->value('device_id');
		$custom_fields = device_custom_field::where('device_id', '=', $deviceid)
			->get();

		foreach ($custom_fields as $row) {
			$row->field_check = Clientcustomfeatures::where('c_id', '=', $row->id)->where('client_name', '=', $clientanme)->value('field_check');
			$row->fileld_delta_check = Clientcustomfeatures::where('c_id', '=', $row->id)->where('client_name', '=', $clientanme)->value('fileld_delta_check');
			$row->fileld_highlight = Clientcustomfeatures::where('c_id', '=', $row->id)->where('client_name', '=', $clientanme)->value('fileld_highlight');

		}

		$projectname = device::where('id', '=', $deviceid)->where('is_delete', '=', '0')->value('project_name');
		$check_clientname = Devicefeatures::where('device_id', '=', $deviceid)
			->where('client_name', '!=', $devicefeatures->client_name)
			->get();
		$clientname = [];
		foreach ($check_clientname as $clients) {
			$clientname[] = $clients->client_name;

		}

		$client_name = ['' => 'Client Name']
		 + project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')
			->where('project_clients.project_id', '=', $projectname)
			->whereNotIn('project_clients.client_name', $clientname)
			->pluck('clients.client_name', 'clients.id')
			->all();

		if (count($organization) > 0) {
			$client_name = ['' => 'Client Name']
			 + project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')
				->where('project_clients.project_id', '=', $projectname)
				->whereIn('project_clients.client_name', $organization)
				->whereNotIn('project_clients.client_name', $clientname)
				->pluck('clients.client_name', 'clients.id')
				->all();

		}

		// dd($custom_fields);

		return view('pages.editdevicefeatures', compact('custom_fields', 'deviceid', 'client_name', 'devicefeatures'));
	}

	public function devicefeaturesupdate(Request $request, $id) {

		$rules = array(
			'client_name' => 'required',
		);

		$longevity_check = $request->get('chk_longevity') == 'True' ? 'True' : 'False';
		$shock_check = $request->get('shock_check') == 'True' ? 'True' : 'False';
		$size_check = $request->get('size_check') == 'True' ? 'True' : 'False';
		$research_check = $request->get('research_check') == 'True' ? 'True' : 'False';
		$site_info_check = $request->get('siteinfo_check') == 'True' ? 'True' : 'False';
		$chk_overall_value = $request->get('overall_value_check') == 'True' ? 'True' : 'False';

		$longevity_delta_check = $request->get('longevity_delta_check') == 'True' ? 'True' : 'False';
		$shock_delta_check = $request->get('shock_delta_check') == 'True' ? 'True' : 'False';
		$size_delta_check = $request->get('size_delta_check') == 'True' ? 'True' : 'False';
		$research_delta_check = $request->get('research_delta_check') == 'True' ? 'True' : 'False';
		$site_info_delta_check = $request->get('site_info_delta_check') == 'True' ? 'True' : 'False';
		$overall_value_delta_check = $request->get('overall_value_delta_check') == 'True' ? 'True' : 'False';

		/*Highlight Check Value*/

		$longevity_highlight = $request->get('longevity_highlight') == 'True' ? 'True' : 'False';
		$shock_highlight = $request->get('shock_highlight') == 'True' ? 'True' : 'False';
		$size_highlight = $request->get('size_highlight') == 'True' ? 'True' : 'False';
		$research_highlight = $request->get('research_highlight') == 'True' ? 'True' : 'False';
		$siteinfo_highlight = $request->get('siteinfo_highlight') == 'True' ? 'True' : 'False';
		$overall_value_highlight = $request->get('overall_value_highlight') == 'True' ? 'True' : 'False';

		$updatedata = array(
			'device_id' => $request->get('device_id'),
			'client_name' => $request->get('client_name'),
			//    'longevity' => $request->get('longevity'),
			'longevity_check' => $longevity_check,
			//    'shock' => $request->get('shock'),
			'shock_check' => $shock_check,
			//    'size' => $request->get('size'),
			'size_check' => $size_check,
			//    'research' => $request->get('research'),
			'research_check' => $research_check,
			//    'site_info' => $request->get('site_info'),
			'siteinfo_check' => $site_info_check,
			//    'url' => $request->get('url'),
			//    'overall_value' => $request->get('overall_value'),
			'overall_value_check' => $chk_overall_value,
			'longevity_delta_check' => $longevity_delta_check,
			'shock_delta_check' => $shock_delta_check,
			'size_delta_check' => $size_delta_check,
			'research_delta_check' => $research_delta_check,
			'site_info_delta_check' => $site_info_delta_check,
			'overall_value_delta_check' => $overall_value_delta_check,
			'longevity_highlight' => $longevity_highlight,
			'shock_highlight' => $shock_highlight,
			'size_highlight' => $size_highlight,
			'research_highlight' => $research_highlight,
			'siteinfo_highlight' => $siteinfo_highlight,
			'overall_value_highlight' => $overall_value_highlight,
		);
		// dd($request->all());

		$validator = Validator::make($updatedata, $rules);

		if ($validator->fails()) {
			return back()
				->withErrors($validator);
		}

		$removeoldfield = Clientcustomfeatures::where('device_id', '=', $request->get('device_id'))
			->where('client_name', '=', $request->get('client_name'))->delete();
		/*insert new custom field */
		$device_id = $request->get('device_id');
		$client_name = $request->get('client_name');
		$customfieldid = $request->get('customhidden');
		$insertcustomfieldcheck = $request['chk_field'];
		$insertcustomhiddencheck = $request->get('chk_hd_field');
		$insertdeltacheck = $request->get('chk_hd_field_delta_check');
		$inserthighlightcheck = $request->get('chk_hd_field_fileld_highlight');

		for ($i = 0; $i < count($customfieldid); $i++) {
			if ($customfieldid[$i] != "") {

				$insertrecord = array(
					"device_id" => $device_id,
					"client_name" => $client_name,
					"field_check" => $insertcustomhiddencheck[$i] == 'True' ? 'True' : 'False',
					"fileld_delta_check" => $insertdeltacheck[$i] == 'True' ? 'True' : 'False',
					"fileld_highlight" => $inserthighlightcheck[$i] == 'True' ? 'True' : 'False',
					"c_id" => $customfieldid[$i],
					"created_at" => Carbon::now(),
					"updated_at" => Carbon::now(),
				);
				$insert_custom_field = Clientcustomfeatures::insert($insertrecord);

			}

		}
		// dd($insertrecord);

		/*update custom field*/
		/*  $customfieldid = Input::get('customhidden');
			          $editcustomfields = Input::get('fieldnameedit');
			          $editcustomfieldvalue = Input::get('fieldvalueedit');
			          $editcustomfieldcheck = Input::get('chk_fieledit');
			          for ($i = 0; $i < count($editcustomfields); $i++) {
			              if (!isset($editcustomfieldcheck[$i])) {
			                  $editcustomfieldcheck[$i] = "False";
			              }

			              $updatecustomfield = array(
			                  "field_name" => $editcustomfields[$i],
			                  "field_value" => $editcustomfieldvalue[$i],
			                  "field_check" => $editcustomfieldcheck[$i]
			              );

			              $update_custom_field = DB::table('device_custom_field')->where('id', '=', $customfieldid[$i])->update($updatecustomfield);
		*/

		$features = Devicefeatures::where('id', '=', $id)->first();
		$features->fill($updatedata);
		$features->update();

		return Redirect::to('admin/devices/view/' . $request->get('device_id') . '#2');

	}

	public function devicefeaturesremove($id) {
		$data = devicefeatures::where('id', $id)->first();

		$remove = devicefeatures::where('id', $id)->delete();
		return redirect('admin/devices/view/' . $data['device_id'] . '#2');
	}

	public function serarchdevicefeatures(Request $request) {

		$data = $request->all();
		$deviceid = $data['deviceId'];
		$client_name = $data['dfsearch'][0];
		$longevity = $data['dfsearch'][1];
		$shock = $data['dfsearch'][2];
		$size = $data['dfsearch'][3];
		$research = $data['dfsearch'][4];
		$site_info = $data['dfsearch'][5];
		$url = $data['dfsearch'][6];
		$overall_value = $data['dfsearch'][7];

		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');
		}

		if (count($organization) > 0) {

			/*clientnames*/

			$searchfeatures = Devicefeatures::leftjoin('clients', 'clients.id', '=', 'device_features.client_name')
				->leftjoin('device', 'device.id', '=', 'device_features.device_id')
				->select('device_features.*', 'device.longevity', 'device.shock', 'device.size', 'device.research', 'device.website_page', 'device.url', 'device.overall_value', 'clients.client_name', 'device_features.client_name as client')
				->where('device_features.device_id', '=', $deviceid)
				->whereIN('device_features.client_name', $organization);

			if (!empty($client_name)) {
				$searchfeatures = $searchfeatures->where('clients.client_name', 'LIKE', $client_name . '%');
			}
			if (!empty($longevity)) {
				$searchfeatures = $searchfeatures->where('longevity', 'LIKE', $longevity . '%');
			}
			if (!empty($shock)) {
				$searchfeatures = $searchfeatures->where('shock', 'LIKE', $shock . '%');
			}
			if (!empty($size)) {
				$searchfeatures = $searchfeatures->where('size', 'LIKE', $size . '%');
			}
			if (!empty($research)) {
				$searchfeatures = $searchfeatures->where('research', 'LIKE', $research . '%');
			}
			if (!empty($site_info)) {
				$searchfeatures = $searchfeatures->where('website_page', 'LIKE', $site_info . '%');
			}
			if (!empty($url)) {
				$searchfeatures = $searchfeatures->where('url', 'LIKE', $url . '%');
			}
			if (!empty($overall_value)) {
				$searchfeatures = $searchfeatures->where('overall_value', 'LIKE', $overall_value . '%');
			}

			$searchfeatures = $searchfeatures->orderBy('device_features.id', 'DESC')
				->get();

		} else {
			$searchfeatures = Devicefeatures::leftjoin('clients', 'clients.id', '=', 'device_features.client_name')
				->leftjoin('device', 'device.id', '=', 'device_features.device_id')
				->select('device_features.*', 'device.longevity', 'device.shock', 'device.size', 'device.research', 'device.website_page', 'device.url', 'device.overall_value', 'clients.client_name', 'device_features.client_name as client')
				->where('device_features.device_id', '=', $deviceid);

			if (!empty($client_name)) {
				$searchfeatures = $searchfeatures->where('clients.client_name', 'LIKE', $client_name . '%');
			}
			if (!empty($longevity)) {
				$searchfeatures = $searchfeatures->where('longevity', 'LIKE', $longevity . '%');
			}
			if (!empty($shock)) {
				$searchfeatures = $searchfeatures->where('shock', 'LIKE', $shock . '%');
			}
			if (!empty($size)) {
				$searchfeatures = $searchfeatures->where('size', 'LIKE', $size . '%');
			}
			if (!empty($research)) {
				$searchfeatures = $searchfeatures->where('research', 'LIKE', $research . '%');
			}
			if (!empty($site_info)) {
				$searchfeatures = $searchfeatures->where('website_page', 'LIKE', $site_info . '%');
			}
			if (!empty($url)) {
				$searchfeatures = $searchfeatures->where('url', 'LIKE', $url . '%');
			}
			if (!empty($overall_value)) {
				$searchfeatures = $searchfeatures->where('overall_value', 'LIKE', $overall_value . '%');
			}

			$searchfeatures = $searchfeatures->orderBy('device_features.id', 'DESC')
				->get();
		}

		$data = $searchfeatures;

		if (count($data)) {
			return [
				'value' => $data,
				'status' => TRUE,
			];
		} else {
			return [
				'value' => 'No result Found',
				'status' => FALSE,
			];
		}

	}

// Device survey Module Start
	public function deviceSurvey($id, Request $request) {
		$deviceid = $id;
		$projectname = device::where('id', '=', $deviceid)->where('is_delete', '=', '0')->value('project_name');
		$devices = device::findOrFail($id);
		$check_clientname = physciansPreference::where('deviceId', '=', $id)->get();

		$clientname = [];
		foreach ($check_clientname as $clients) {
			$clientname[] = $clients->clientId;

		}

		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');

		}

		if (count($organization) > 0) {

			$client_name = ['' => 'Client Name']
			 + project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')
				->where('project_clients.project_id', '=', $projectname)
				->whereNotIn('project_clients.client_name', $clientname)
				->whereIn('clients.id', $organization)
				->pluck('clients.client_name', 'clients.id')
				->all();
		} else {
			$client_name = ['' => 'Client Name']
			 + project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')
				->where('project_clients.project_id', '=', $projectname)
				->whereNotIn('project_clients.client_name', $clientname)
				->pluck('clients.client_name', 'clients.id')
				->all();
		}

		return view('pages.devicesurvey.addDeviceSurvey', compact('devices', 'deviceid', 'client_name'));

	}

	public function deviceSurveyStore(Request $request) {
//        dd($request->all());
		$rules = array(
			'clientId' => 'required',
			'status' => 'required',
		);

		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			return redirect()->back()
				->withErrors($validator);

		}

		$quecount = count($request->get('que'));

		if ($quecount = '0') {
			return redirect()->back()
				->withErrors(['que_1' => 'add at least one question']);

		}

		$data['deviceId'] = $request['device_id'];
		$que = $request->get('que');
		$check = $request->get('check');

		for ($i = 0; $i < count($que); $i++) {
			$data['question'] = $que[$i];
			$data['check'] = $check[$i];
			$data['deviceId'] = $request['device_id'];
			$data['clientId'] = $request['clientId'];
			$data['flag'] = $request['status'];
			$data['created_at'] = \Carbon\Carbon::now();
			$data['updated_at'] = \Carbon\Carbon::now();
			$survey = new physciansPreference;
			$survey->fill($data);
			$survey->save();
		}

		Session::flash('message', '<div class="alert alert-success"><strong>Success!</strong> Your Survey Added Sucessfully.!! </div>');

		return redirect('admin/devices/view/' . $data['deviceId'] . '#4');

	}

	public function deviceSurveyView(Request $request, $id, $deviceId) {
		$survey = physciansPreference::where('clientId', $id)->where('deviceId', $deviceId)->get();
//        dd($survey);
		$client = clients::where('id', $id)->value('client_name');
		$device = device::where('id', $deviceId)->value('device_name');
		return view('pages.devicesurvey.viewDeviceSurvey', compact('survey', 'deviceId', 'client', 'id', 'device'));
	}

	public function deviceSurveyEdit(Request $request, $id, $deviceId) {

		$projectname = device::where('id', '=', $deviceId)->where('is_delete', '=', '0')->value('project_name');

		$devices = device::findOrFail($deviceId);

		$checkdatas = physciansPreference::where('deviceId', $deviceId)->where('clientId', '!=', $id)->groupBy('clientId')->get();

		$clientname = [];

		foreach ($checkdatas as $clients) {
			$clientname[] = $clients->clientId;

		}

		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');

		}

		if (count($organization) > 0) {

			$client_name = ['' => 'Client Name']
			 + project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')
				->where('project_clients.project_id', '=', $projectname)
				->whereNotIn('project_clients.client_name', $clientname)
				->whereIn('clients.id', $organization)
				->pluck('clients.client_name', 'clients.id')
				->all();
		} else {
			$client_name = ['' => 'Client Name']
			 + project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')
				->where('project_clients.project_id', '=', $projectname)
				->whereNotIn('project_clients.client_name', $clientname)
				->pluck('clients.client_name', 'clients.id')
				->all();
		}

		$device_survey = physciansPreference::where('clientId', '=', $id)->where('deviceId', $deviceId)->orderby('id', 'ASC')->get();

		$status = physciansPreference::where('clientId', '=', $id)->where('deviceId', $deviceId)->groupBy('clientId')->value('flag');

		$client = clients::where('id', $id)->value('client_name');

		$device = device::where('id', $deviceId)->value('device_name');

		return view('pages.devicesurvey.editDeviceSurvey', compact('device', 'client', 'status', 'device_survey', 'client_name', 'deviceId', 'id'));
	}

	public function deviceSurveyUpdate(Request $request, $id, $deviceId) {
//        dd($request->all());
		$question = $request->get('que');
		$check = $request->get('check');
		$id = $request->get('id');
		$status = $request->get('status');

		for ($i = 0; $i < count($question); $i++) {

			$getrecord = array(
				"question" => $question[$i],
				"check" => $check[$i],
				"flag" => $status,
			);

			$update_survey = physciansPreference::where('id', '=', $id[$i])->update($getrecord);
		}

		return redirect('admin/devices/view/' . $deviceId . '#4');
	}

	public function deviceSurveyRemove($id, $deviceId) {
		$data = physciansPreference::where('clientId', $id)->where('deviceId', $deviceId)->delete();

//        $remove = physciansPreference::where('id', $id)->delete();
		return redirect('admin/devices/view/' . $deviceId . '#4');
	}

	public function deviceSurveyCopy($id, Request $request, $deviceId) {

		$data = physciansPreference::where('clientId', '=', $id)->where('deviceId', $deviceId)->orderby('id', 'ASC')->get();

		$projectname = device::where('id', '=', $deviceId)->where('is_delete', '=', '0')->value('project_name');

		$devices = device::findOrFail($deviceId);

		$checkdatas = physciansPreference::where('deviceId', $deviceId)->groupBy('clientId')->get();

		$clientname = [];

		foreach ($checkdatas as $clients) {
			$clientname[] = $clients->clientId;

		}

		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');

		}

		if (count($organization) > 0) {

			$client_name = ['' => 'Client Name']
			 + project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')
				->where('project_clients.project_id', '=', $projectname)
				->whereNotIn('project_clients.client_name', $clientname)
				->whereIn('clients.id', $organization)
				->pluck('clients.client_name', 'clients.id')
				->all();
		} else {
			$client_name = ['' => 'Client Name']
			 + project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')
				->where('project_clients.project_id', '=', $projectname)
				->whereNotIn('project_clients.client_name', $clientname)
				->pluck('clients.client_name', 'clients.id')
				->all();
		}

		return view('pages.devicesurvey.copyDeviceSurvey', compact('devices', 'client_name', 'data', 'deviceId', 'id'));
	}

	public function deviceSurveySearch(Request $request) {
		$data = $request->all();
		$deviceId = $data['device_id'];
		$client = $data['search'][0];
		$que1 = $data['search'][1];

		$searchfeatures = physciansPreference::clientname()->where('physciansPreference.deviceId', '=', $deviceId);

		if (!empty($client)) {
			$searchfeatures = $searchfeatures->where('clients.client_name', 'LIKE', $client . '%');

		}
		if (!empty($que1)) {
			$searchfeatures = $searchfeatures->where('physciansPreference.question', 'LIKE', $que1 . '%');

		}

		$searchfeatures = $searchfeatures->orderBy('physciansPreference.id', 'ASC')->groupBy('clientId')->get();

		$organizations = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organizations = session('adminclient');
		}

		if (count($organizations) > 0) {

			$searchfeatures = physciansPreference::clientname()->where('physciansPreference.deviceId', '=', $deviceId)
				->whereIn('physciansPreference.clientId', $organizations);

			if (!empty($client)) {
				$searchfeatures = $searchfeatures->where('clients.client_name', 'LIKE', $client . '%');

			}
			if (!empty($que1)) {
				$searchfeatures = $searchfeatures->where('physciansPreference.question', 'LIKE', $que1 . '%');

			}

			$searchfeatures = $searchfeatures->orderBy('physciansPreference.id', 'DESC')->groupBy('clientId')
				->get();
			// dd($searchfeatures);

		}
		$data = array();
		foreach ($searchfeatures as $row) {
			$device_survey = physciansPreference::where('deviceId', $deviceId)->where('clientId', $row->clientId)->orderBy('id', 'asc')->get();

			foreach ($device_survey as $key) {
				$data[$key->clientId]['clientName'] = $key->client->client_name;
				$data[$key->clientId]['clientId'] = $key->clientId;
				$data[$key->clientId][] = array(
					'question' => $key->question,
					'check' => $key->check,
				);
			}
		}

		if (count($data)) {
			return [
				'value' => $data,
				'status' => TRUE,
			];
		} else {
			return [
				'value' => 'No result Found',
				'status' => FALSE,
			];
		}

	}

	public function deviceSurveyAnswer($id, Request $request) {
		$pagesize = $request->get('repPageSize');

		if ($pagesize == "") {
			$pagesize = 10;
		}

		$survey = Survey::where('id', '=', $id)->first();
		$device_survey = SurveyAnswer::where('surveyId', $id)
			->paginate($pagesize);
		$count = SurveyAnswer::where('surveyId', $id)->count();
		return view('pages.devicesurvey.answerDeviceSurvey', compact('device_survey', 'survey', 'pagesize', 'count'));
	}

	public function deviceSurveyAnswerRemove($id) {
		$data = SurveyAnswer::where('id', $id)->first();

		$remove = SurveyAnswer::where('id', $id)->delete();
		return redirect('admin/devices/view/' . $data['deviceId']);

	}

	public function deviceSurveyAnswerSearch(Request $request) {
		$data = $request->all();
		$surveyId = $data['surveyId'];
		$deviceId = $data['device_id'];
		$client = $data['search'][0];
		$que1 = $data['search'][1];
		$que2 = $data['search'][2];
		$que3 = $data['search'][3];
		$que4 = $data['search'][4];
		$que5 = $data['search'][5];
		$que6 = $data['search'][6];
		$que7 = $data['search'][7];
		$que8 = $data['search'][8];

		$searchfeatures = SurveyAnswer::username()->where('survey_answer.deviceId', '=', $deviceId)
			->where('survey_answer.surveyId', $surveyId);

		if (!empty($client)) {
			$searchfeatures = $searchfeatures->where('users.name', 'LIKE', $client . '%');

		}
		if (!empty($que1)) {
			$searchfeatures = $searchfeatures->where('que_1', 'LIKE', $que1 . '%');

		}
		if (!empty($que2)) {
			$searchfeatures = $searchfeatures->where('que_2', 'LIKE', $que2 . '%');

		}
		if (!empty($que3)) {
			$searchfeatures = $searchfeatures->where('que_3', 'LIKE', $que3 . '%');

		}
		if (!empty($que4)) {
			$searchfeatures = $searchfeatures->where('que_4', 'LIKE', $que4 . '%');

		}
		if (!empty($que5)) {
			$searchfeatures = $searchfeatures->where('que_5', 'LIKE', $que5 . '%');

		}
		if (!empty($que6)) {
			$searchfeatures = $searchfeatures->where('que_6', 'LIKE', $que6 . '%');

		}
		if (!empty($que7)) {
			$searchfeatures = $searchfeatures->where('que_7', 'LIKE', $que7 . '%');

		}
		if (!empty($que8)) {
			$searchfeatures = $searchfeatures->where('que_8', 'LIKE', $que8 . '%');

		}

		$searchfeatures = $searchfeatures->orderBy('survey_answer.id', 'DESC')
			->get();

		if (Auth::user()->roll == 2) {

			$searchfeatures = SurveyAnswer::username()->where('survey_answer.deviceId', '=', $deviceid);
			// ->where('survey.client_name', '=', Auth::user()->organization);

			if (!empty($client)) {
				$searchfeatures = $searchfeatures->where('users.name', 'LIKE', $client . '%');

			}
			if (!empty($que1)) {
				$searchfeatures = $searchfeatures->where('que_1', 'LIKE', $que1 . '%');

			}
			if (!empty($que2)) {
				$searchfeatures = $searchfeatures->where('que_2', 'LIKE', $que2 . '%');

			}
			if (!empty($que3)) {
				$searchfeatures = $searchfeatures->where('que_3', 'LIKE', $que3 . '%');

			}
			if (!empty($que4)) {
				$searchfeatures = $searchfeatures->where('que_4', 'LIKE', $que4 . '%');

			}
			if (!empty($que5)) {
				$searchfeatures = $searchfeatures->where('que_5', 'LIKE', $que5 . '%');

			}
			if (!empty($que6)) {
				$searchfeatures = $searchfeatures->where('que_6', 'LIKE', $que6 . '%');

			}
			if (!empty($que7)) {
				$searchfeatures = $searchfeatures->where('que_7', 'LIKE', $que7 . '%');

			}
			if (!empty($que8)) {
				$searchfeatures = $searchfeatures->where('que_8', 'LIKE', $que8 . '%');

			}
			$searchfeatures = $searchfeatures->orderBy('survey_answer.id', 'DESC')
				->get();

		}

		$data = $searchfeatures;

		if (count($data)) {
			return [
				'value' => $data,
				'status' => TRUE,
			];
		} else {
			return [
				'value' => 'No result Found',
				'status' => FALSE,
			];
		}

	}
// Device Survey Module End

// Custom Contact information module start

	public function customContact($id, Request $request) {
		$deviceid = $id;
		$projectname = device::where('id', '=', $deviceid)->where('is_delete', '=', '0')->value('project_name');
		$devices = device::findOrFail($id);
		$check_clientname = customContact::where('deviceId', '=', $id)->get();

		$clientname = [];
		foreach ($check_clientname as $clients) {
			$clientname[] = $clients->clientId;

		}

		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');

		}

		if (count($organization) > 0) {

			$client_name = ['' => 'Client Name']
			 + project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')
				->where('project_clients.project_id', '=', $projectname)
				->whereNotIn('project_clients.client_name', $clientname)
				->whereIn('clients.id', $organization)
				->pluck('clients.client_name', 'clients.id')
				->all();
		} else {
			$client_name = ['' => 'Client Name']
			 + project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')
				->where('project_clients.project_id', '=', $projectname)
				->whereNotIn('project_clients.client_name', $clientname)
				->pluck('clients.client_name', 'clients.id')
				->all();
		}

		return view('pages.customcontact.addCustomContact', compact('devices', 'deviceid', 'client_name'));
	}

	public function contactStore(Request $request) {
		$rules = array(
			'clientId' => 'required',
			'cc1' => 'email',
			'cc1Number' => 'numeric',
			'cc2' => 'email',
			'cc2Number' => 'numeric',
			'cc3' => 'email',
			'cc3Number' => 'numeric',
			'cc4' => 'email',
			'cc4Number' => 'numeric',
			'cc5' => 'email',
			'cc5Number' => 'numeric',
			'cc6' => 'email',
			'cc6Number' => 'numeric',
		);

		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			return redirect()->back()
				->withErrors($validator)
				->withInput();

		}
		$data = $request->all();

		if (empty($data['order_email']) && empty($data['cc1']) && empty($data['cc2']) && empty($data['cc3']) && empty($data['cc4']) && empty($data['cc5']) && empty($data['cc6'])) {
			return redirect()->back()
				->withErrors(['clientId' => 'At least add any one email']);

		}
		// Validation multiple entry
		$clients = customContact::where('clientId', $data['clientId'])->where('deviceId', $data['deviceId'])->where('order_email', $data['order_email'])->get();
		if (count($clients) > 0) {
			return redirect()->back()
				->withErrors(['clientId' => 'You Entred Duplicate Record Please Try Another once!!']);
		}
		$custom = new customContact;
		$custom->fill($data);
		if ($custom->save()) {
			Session::flash('message', '<div class="alert alert-success"><strong>Success!</strong> Your Survey Added Sucessfully.!! </div>');

			return redirect('admin/devices/view/' . $data['deviceId'] . '#3');
		}

	}

	public function getOrderMail(Request $request) {
		$userId = $request->get('userId');

		$orderuser = User::physician()->where('user_clients.clientId', $userId)->where('users.roll', '4')
			->where('users.status', 'Enabled')
			->where('users.is_delete', '0')->get();

		$data = $orderuser;

		if (count($data)) {
			return [
				'value' => $data,
				'status' => TRUE,
			];
		} else {
			return [
				'value' => 'No result Found',
				'status' => FALSE,
			];
		}

	}

	public function contactNumber(Request $request) {

		$userId = $request->get('userId');

		$data = User::where('id', $userId)->where('status', 'Enabled')->where('is_delete', '0')->value('mobile');

		if (count($data)) {
			return [
				'value' => $data,
				'status' => TRUE,
			];
		} else {
			return [
				'value' => 'No result Found',
				'status' => FALSE,
			];
		}

	}

	public function customContactEdit(Request $request, $id) {
		$customContact = customContact::where('id', '=', $id)->first();

		$projectname = device::where('id', '=', $customContact->deviceId)->where('is_delete', '=', '0')->value('project_name');
		$devices = device::findOrFail($customContact->deviceId);

		$check_clientname = customContact::where('deviceId', '=', $customContact->deviceId)
			->where('clientId', '!=', $customContact->clientId)->get();

		$clientname = [];

		foreach ($check_clientname as $clients) {
			$clientname[] = $clients->clientId;

		}

		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');

		}

		if (count($organization) > 0) {

			$client_name = ['' => 'Client Name']
			 + project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')
				->where('project_clients.project_id', '=', $projectname)
				->whereNotIn('project_clients.client_name', $clientname)
				->whereIn('clients.id', $organization)
				->pluck('clients.client_name', 'clients.id')
				->all();

			$orderuser = ['' => 'Select Order Email'] + User::physician()->whereIn('user_clients.clientId', $organization)->where('users.roll', '4')
				->where('users.status', 'Enabled')
				->where('users.is_delete', '0')
				->pluck('users.email', 'clients.id')
				->all();

		} else {
			$client_name = ['' => 'Client Name']
			 + project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')
				->where('project_clients.project_id', '=', $projectname)
				->whereNotIn('project_clients.client_name', $clientname)
				->pluck('clients.client_name', 'clients.id')
				->all();

			$orderuser = ['' => 'Select Order Email'] + User::physician()->where('user_clients.clientId', $customContact['clientId'])
				->where('users.roll', '4')
				->where('users.status', 'Enabled')
				->where('users.is_delete', '0')
				->pluck('users.email', 'clients.id')
				->all();

		}
		return view('pages.customcontact.editCustomContact', compact('devices', 'client_name', 'customContact', 'orderuser'));
	}

	public function customContactUpdate(Request $request, $id) {
		$rules = array(
			'clientId' => 'required',
			'cc1' => 'email',
			'cc1Number' => 'numeric',
			'cc2' => 'email',
			'cc2Number' => 'numeric',
			'cc3' => 'email',
			'cc3Number' => 'numeric',
			'cc4' => 'email',
			'cc4Number' => 'numeric',
			'cc5' => 'email',
			'cc5Number' => 'numeric',
			'cc6' => 'email',
			'cc6Number' => 'numeric',
		);

		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			return redirect()->back()
				->withErrors($validator)
				->withInput();

		}

		$data = $request->except('_token', '_method');
		if (empty($data['order_email']) && empty($data['cc1']) && empty($data['cc2']) && empty($data['cc3']) && empty($data['cc4']) && empty($data['cc5']) && empty($data['cc6'])) {
			return redirect()->back()
				->withErrors(['clientId' => 'At least add any one email'])
				->withInput();
		}

		$custom = customContact::where('id', '=', $id)->update($data);

		return redirect('admin/devices/view/' . $data['deviceId'] . '#3');

	}

	public function customContactRemove($id) {
		$data = customContact::where('id', $id)->first();
		$remove = customContact::where('id', $id)->delete();

		return redirect('admin/devices/view/' . $data['deviceId'] . '#3');
	}

	public function contactSearch(Request $request) {

		$data = $request->all();

		$organizations = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organizations = session('adminclient');
		}

//         dd($data);
		$deviceId = $data['device_id'];
		$client = $data['search'][0];
		$ordermail = $data['search'][1];
		$cc1 = $data['search'][2];
		$cc2 = $data['search'][3];
		$cc3 = $data['search'][4];
		$cc4 = $data['search'][5];
		$cc5 = $data['search'][6];
		$cc6 = $data['search'][7];
		$subject = $data['search'][8];

		$searchfeatures = customContact::clientname()->where('custom_contact_info.deviceId', '=', $deviceId);

		if (!empty($client)) {

			$searchfeatures = $searchfeatures->where('clients.client_name', 'LIKE', $client . '%');

		}
		if (!empty($ordermail)) {
			$searchfeatures = $searchfeatures->where('users.email', 'LIKE', $ordermail . '%');

		}
		if (!empty($cc1)) {
			$searchfeatures = $searchfeatures->where('cc1', 'LIKE', $cc1 . '%');

		}
		if (!empty($cc2)) {
			$searchfeatures = $searchfeatures->where('cc2', 'LIKE', $cc2 . '%');

		}
		if (!empty($cc3)) {
			$searchfeatures = $searchfeatures->where('cc3', 'LIKE', $cc3 . '%');

		}
		if (!empty($cc4)) {
			$searchfeatures = $searchfeatures->where('cc4', 'LIKE', $cc4 . '%');

		}
		if (!empty($cc5)) {
			$searchfeatures = $searchfeatures->where('cc5', 'LIKE', $cc5 . '%');

		}
		if (!empty($cc6)) {
			$searchfeatures = $searchfeatures->where('cc6', 'LIKE', $cc6 . '%');

		}
		if (!empty($subject)) {
			$searchfeatures = $searchfeatures->where('subject', 'LIKE', $subject . '%');

		}

		$searchfeatures = $searchfeatures->orderBy('custom_contact_info.id', 'DESC')
			->get();

		if (count($organizations) > 0) {

			$searchfeatures = customContact::clientname()->where('custom_contact_info.deviceId', '=', $deviceId)
				->whereIn('custom_contact_info.clientId', $organizations);

			if (!empty($client)) {

				$searchfeatures = $searchfeatures->where('clients.client_name', 'LIKE', $client . '%');

			}
			if (!empty($ordermail)) {
				$searchfeatures = $searchfeatures->where('users.email', 'LIKE', $ordermail . '%');

			}
			if (!empty($cc1)) {
				$searchfeatures = $searchfeatures->where('cc1', 'LIKE', $cc1 . '%');

			}
			if (!empty($cc2)) {
				$searchfeatures = $searchfeatures->where('cc2', 'LIKE', $cc2 . '%');

			}
			if (!empty($cc3)) {
				$searchfeatures = $searchfeatures->where('cc3', 'LIKE', $cc3 . '%');

			}
			if (!empty($cc4)) {
				$searchfeatures = $searchfeatures->where('cc4', 'LIKE', $cc4 . '%');

			}
			if (!empty($cc5)) {
				$searchfeatures = $searchfeatures->where('cc5', 'LIKE', $cc5 . '%');

			}
			if (!empty($cc6)) {
				$searchfeatures = $searchfeatures->where('cc6', 'LIKE', $cc6 . '%');

			}
			if (!empty($subject)) {
				$searchfeatures = $searchfeatures->where('subject', 'LIKE', $subject . '%');

			}

			$searchfeatures = $searchfeatures->orderBy('custom_contact_info.id', 'DESC')
				->get();

		}

		$data = $searchfeatures;

		if (count($data)) {
			return [
				'value' => $data,
				'status' => TRUE,
			];
		} else {
			return [
				'value' => 'No result Found',
				'status' => FALSE,
			];
		}

	}

	// Custom Contact information module start
	// Device Rep User Details Start

	public function repstatus(Request $request) {
		$deviceId = Input::get('deviceId');
		$repId = Input::get('repId');
		$status = Input::get('repStatus');

		if ($status == 'Yes') {

			$data['deviceId'] = $deviceId;
			$data['repId'] = $repId;
			$data['repStatus'] = $status;
			// dd($data['status']);
			$rep = new RepContact;
			$rep->fill($data);
			if ($rep->save()) {
				if (count($rep)) {
					return [
						'value' => $rep,
						'status' => TRUE,
					];
				} else {
					return [
						'value' => 'No result Found',
						'status' => FALSE,
					];
				}

			}
		} else {
			$remove = RepContact::where('repId', $repId)->where('deviceId', $deviceId)->delete();

			if (count($remove)) {
				return [
					'value' => $remove,
					'status' => TRUE,
				];
			} else {
				return [
					'value' => 'No result Found',
					'status' => FALSE,
				];
			}

		}

	}

	public function repStatusEdit($id, $deviceId) {
		// Device Rep User Tab
		$organization = device::where('id', $deviceId)->first();

		$deviceRepUser = User::where('roll', '5')->where('organization', $organization->manufacturer_name)->where('id', $id)->first();

		$repSta = RepContact::where('repId', $deviceRepUser->id)->where('deviceId', $deviceId)->value('repStatus');
		// dd($repSta);
		$repStatus = $repSta == "" ? "No" : "Yes";

		return view('pages.repcontact.editRepContact', compact('deviceRepUser', 'deviceId', 'repStatus'));
	}

	public function repStatusUpdate(Request $request, $id) {

		$check = RepContact::where('repId', $id)->first();
		if (!empty($check)) {

			if ($request['status'] != 'Yes') {

				$remove = RepContact::where('repId', $id)->where('deviceId', $request['deviceId'])->delete();
				return redirect('admin/devices/view/' . $request['deviceId']);
			}
			return redirect('admin/devices/view/' . $request['deviceId']);

		} else {

			$add['repId'] = $id;
			$add['deviceId'] = $request['deviceId'];
			$add['repStatus'] = $request['status'];
			$rep = new RepContact;
			$rep->fill($add);
			if ($rep->save()) {
				return redirect('admin/devices/view/' . $request['deviceId'] . '#5');
			}
		}

	}

	public function repinfoexport(Request $request) {
		$data = $request->all();
		$id = $request['deviceId'];
		$chkRep = $request['ck_rep'];

		$organization = device::where('id', $id)->first();
		$deviceRepUser = User::repcontact()->where('users.roll', '5')->where('users.organization', $organization->manufacturer_name)->whereIn('users.id', $chkRep)->groupBy('users.id')->get();

		foreach ($deviceRepUser as $row) {

			$row->repStatus = RepContact::where('deviceId', $id)->where('repId', $row->id)->value('repStatus');

			$row->repStatus = $row->repStatus == "Yes" ? "Yes" : "No";

			$row->userclientName = array();
			$temporaryClient = array();
			foreach ($row->userclients as $row1) {
				array_push($temporaryClient, $row1->clientname->client_name);
			}
			$row->userclientName = implode(", ", $temporaryClient);
		}

		foreach ($deviceRepUser as $row) {

			$rep_data[] = [
				$row['id'],
				$row['name'],
				$row['email'],
				$row['mobile'],
				$row['title'],
				$row['manufacturer_name'],
				$row['userclientName'],
				$row['repStatus'],
			];
		}

		$myFile = Excel::create('Rep_contact_info', function ($excel) use ($rep_data) {

			$excel->setTitle('Rep Contact Info');
			$excel->setCreator('Admin')->setCompany('Neptune-PPA');
			$excel->setDescription('Rep Contact Information');

			$excel->sheet('Rep Contact Info', function ($sheet) use ($rep_data) {
				$sheet->row(1, array('Id', 'Name', 'Email', 'Mobile', 'Title', 'Company', 'Clients', 'Status'));
				$sheet->row($sheet->getHighestRow(), function ($row) {
					$row->setFontWeight('bold');
				});
				foreach ($rep_data as $row) {
					$sheet->appendRow($row);
				}
			});
		});

		$myFile = $myFile->string('xlsx');
		$response = array(
			'name' => "Rep_contact_info", //no extention needed
			'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($myFile), //mime type of used format
		);
		return response()->json($response);
		exit();
	}

	public function repcontactsearch(Request $request) {
		$data = $request->all();
		// dd($data);
		$deviceId = $data['deviceId'];
		$name = $data['search'][0];
		$email = $data['search'][1];
		$mobile = $data['search'][2];
		$title = $data['search'][3];
		$company = $data['search'][4];
		$client = $data['search'][5];

		$organization = device::where('id', $deviceId)->first();

		$searchrep = User::repcontact()->where('users.roll', '5')->where('users.organization', $organization->manufacturer_name)
			->where('user_projects.projectId', $organization->project_name)->groupBy('users.id');

		if (!empty($name)) {

			$searchrep = $searchrep->where('users.name', 'LIKE', $name . '%');

		}
		if (!empty($email)) {
			$searchrep = $searchrep->where('users.email', 'LIKE', $email . '%');

		}
		if (!empty($mobile)) {
			$searchrep = $searchrep->where('users.mobile', 'LIKE', $mobile . '%');

		}
		if (!empty($title)) {
			$searchrep = $searchrep->where('users.title', 'LIKE', $title . '%');

		}
		if (!empty($company)) {
			$searchrep = $searchrep->where('manufacturers.manufacturer_name', 'LIKE', $company . '%');

		}
		if (!empty($client)) {
			$searchrep = $searchrep->where('clients.client_name', 'LIKE', $client . '%');

		}

		$searchrep = $searchrep->orderBy('users.id', 'DESC')
			->get();

		foreach ($searchrep as $row) {

			$row->repStatus = RepContact::where('deviceId', $deviceId)->where('repId', $row->id)->value('repStatus');

			$row->repStatus = $row->repStatus == "Yes" ? "Yes" : "No";

			$row->device = $deviceId;
			$row->userclientName = array();
			$temporaryClient = array();
			foreach ($row->userclients as $row1) {
				array_push($temporaryClient, $row1->clientname->client_name);
			}
			$row->userclientName = implode(", ", $temporaryClient);

		}

		$data = $searchrep;

		if (count($data)) {
			return [
				'value' => $data,
				'status' => TRUE,
			];
		} else {
			return [
				'value' => 'No result Found',
				'status' => FALSE,
			];
		}

	}

	public function sampledownload() {
dd("ok");
		$file = "public/upload/csv/devices.csv";
		return Response::download($file);
		return redirect()->back();
	}

	// Device Rep User Details End

	/***/
	/*Search Device Using Serial Number Start 06/11/2017 09:00 A.M*/
	public function serialdevice(Request $request) {
		$serial = $request['serial'];

		$device = SerialnumberDetail::where('serialNumber', $serial)->value('deviceId');

		$data = device::leftjoin('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
			->leftjoin('projects', 'projects.id', '=', 'device.project_name')
			->leftjoin('category', 'category.id', '=', 'device.category_name')
			->select('device.id', 'device.model_name', 'device.status', 'device.device_name', 'manufacturers.manufacturer_name as manu_name', 'projects.project_name', 'category.category_name')
			->where('device.is_delete', '=', '0')
			->orderBy('device.id', 'DESC')
			->where('device.id', $device)
			->groupBy('device.id')
			->get();

		if (count($data)) {
			return [
				'value' => $data,
				'status' => TRUE,
			];
		} else {
			return [
				'value' => 'No result Found',
				'status' => FALSE,
			];
		}

	}

	public function deviceserial(Request $request) {

		$serial = $request['serial'];

		$serialId = SerialnumberDetail::where('serialNumber', $serial)->first();

		$data = Serialnumber::leftJoin('clients', 'clients.id', '=', 'serialnumber.clientId')
			->select('serialnumber.*', 'clients.client_name')
			->orderBy('serialnumber.id', 'DESC')
			->where('serialnumber.clientId', $serialId['clientId'])
			->where('serialnumber.deviceId', $serialId['deviceId'])
			->get();

		foreach ($data as $row) {

			$row->createat = Carbon::parse($row->created_at)->format('Y-m-d');
			$row->updateat = Carbon::parse($row->updated_at)->format('Y-m-d');

		}

		if (count($data)) {
			return [
				'value' => $data,
				'status' => TRUE,
			];
		} else {
			return [
				'value' => 'No result Found',
				'status' => FALSE,
			];
		}

	}
	/*Search Device Using Serial Number End*/
	/***/

}