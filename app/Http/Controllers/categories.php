<?php

namespace App\Http\Controllers;

use App\category;
use App\Categorysort;
use App\clients;
use App\project;
use App\project_clients;
use App\user;
use App\userClients;
use Auth;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use URL;

class categories extends Controller {
	public function index(Request $request) {
		$pagesize = $request->get('pagesize');
		if ($pagesize == "") {
			$pagesize = 10;
		}

		$userid = Auth::user()->id;

		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');

		}

		//$organization = user::where('id','=',$userid)->value('organization');
		if (count($organization) > 0) {
			$categories = category::leftjoin('projects', 'category.project_name', '=', 'projects.id')
				->join('project_clients', 'project_clients.project_id', '=', 'category.project_name')
				->whereIn('project_clients.client_name', $organization)
				->orderBy('category.id', 'desc')
				->select('category.id', 'projects.project_name', 'category.category_name', 'category.project_name as prname', 'category.type', 'category.image')
				->where('category.is_active', '=', '1')
				->groupBy('category.id')
				->paginate($pagesize);

			$count = category::leftjoin('projects', 'category.project_name', '=', 'projects.id')
				->join('project_clients', 'project_clients.project_id', '=', 'category.project_name')
				->whereIn('project_clients.client_name', $organization)
				->orderBy('category.id', 'desc')
				->select('category.id', 'projects.project_name', 'category.category_name', 'category.project_name as prname', 'category.type', 'category.image')
				->where('category.is_active', '=', '1')
				->groupBy('category.id')
				->get();
			$count = count($count);
		} else {
			$categories = category::leftjoin('projects', 'category.project_name', '=', 'projects.id')
				->select('category.id', 'projects.project_name', 'category.category_name', 'category.project_name as prname', 'category.type', 'category.image')
				->where('category.is_active', '=', '1')
				->orderBy('category.id', 'desc')
				->paginate($pagesize);

			$count = category::leftjoin('projects', 'category.project_name', '=', 'projects.id')
				->where('category.is_active', '=', 1)
				->count();
		}

		foreach ($categories as $client) {
			$projectid = $client->prname;
			$client->client_count = project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')
				->where('project_id', '=', $projectid)
				->count();

			if (!empty($client->image) && file_exists('public/category/' . $client->image)) {
				$client->image = URL::to('public/category/' . $client->image);
			} else {
				$client->image = URL::to('public/upload/default.jpg');
			}

		}
		return view('pages.category', compact('categories', 'count', 'pagesize'));
	}

	public function add(Request $request) {
		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');

		}

		if (count($organization) > 0) {
			$projects = ['0' => 'Project Name'] + Project::leftjoin('project_clients', 'project_clients.project_id', '=', 'projects.id')
				->whereIn('project_clients.client_name', $organization)
				->where('projects.is_delete', '=', 0)
				->pluck('projects.project_name', 'projects.id')->all();
		} else {
			$projects = ['0' => 'Project Name'] + Project::pluck('project_name', 'id')->where('is_delete', '=', 0)->all();
		}

		return view('pages.addcategory', compact('projects'));
	}

	public function create(Request $request) {

		$rules = array(
			'project_name' => 'required|not_in:0',
			'category_name' => 'required|unique:category,category_name',
			'type' => 'required',
		);

		$insertdata = array(
			'project_name' => $request->get('project_name'),
			'category_name' => $request->get('category_name'),
			'type' => $request->get('type'),
			'is_active' => '1',
			'is_delete' => '0',
			'short_name' => $request->get('category_short_name'),
		);

		if ($request->hasFile('image')) {

			$bgimage = $request->file('image');

			$filename = $request->get('category_name') . '-icon-' . rand(0, 999) . '.' . $bgimage->getClientOriginalExtension();

			$insertdata['image'] = $filename;
		}

		$validator = Validator::make($insertdata, $rules);

		if ($validator->fails()) {
			return Redirect::to('admin/category/add')
				->withErrors($validator);
		} else {
			$ck = 0;
			$category = category::insert($insertdata);

			$bgimage->move('public/category/', $filename);

			$category = category::orderBy('id', 'desc')->value('id');
			$getclientname = project_clients::where('project_id', '=', $request->get('project_name'))->get();
			foreach ($getclientname as $row) {
				$get_last_sort_number = Categorysort::where('client_name', '=', $row->client_name)->orderBy('sort_number', 'desc')->value('sort_number');
				$get_last_sort_number = $get_last_sort_number == "" ? 0 : $get_last_sort_number;
				$get_last_sort_number = $get_last_sort_number + 1;

				$sortdata['sort_number'] = $get_last_sort_number;
				$sortdata['client_name'] = $row->client_name;
				$sortdata['category_name'] = $category;

				$categorysort = new Categorysort();
				$categorysort->fill($sortdata);
				$categorysort->save();
			}

			return Redirect::to('admin/category');
		}
	}

	public function edit(Request $request, $id) {
		$clients = ['0' => 'Client Name'] + Clients::pluck('client_name', 'id')->all();

		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');

		}

		if (count($organization) > 0) {
			$projects = ['0' => 'Project Name'] + Project::leftjoin('project_clients', 'project_clients.project_id', '=', 'projects.id')
				->whereIn('project_clients.client_name', $organization)
				->where('projects.is_delete', '=', 0)
				->pluck('projects.project_name', 'projects.id')->all();
		} else {
			$projects = Project::where('is_delete', '=', 0)->pluck('project_name', 'id')->all();
		}

		$category = category::FindOrFail($id);
		return view('pages.editcategory', compact('projects', 'clients', 'category'));
	}

	public function update($id, Request $request) {
		$rules = array(
			'project_name' => 'required|not_in:0',
			'category_name' => 'required',
			'type' => 'required',
		);
		$updatedata = array(
			'project_name' => $request->get('project_name'),
			'category_name' => $request->get('category_name'),
			'type' => $request->get('type'),
			'short_name' => $request->get('category_short_name'),
		);

		$validator = Validator::make($updatedata, $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		} else {
			$categoryname = Input::get('category_name');
			$get_categoryname = category::where('id', '=', $id)->value('category_name');
			if ($categoryname == $get_categoryname) {

				if ($request->hasFile('image')) {

					$getimage = category::where('id', $id)->value('image');

					if ($getimage) {
						$filenames = public_path() . '/category/' . $getimage;

						\File::delete($filenames);
					}

					$bgimage = $request->file('image');

					$filename = $request->get('category_name') . '-icon-' . rand(0, 999) . '.' . $bgimage->getClientOriginalExtension();

					$bgimage->move('public/category/', $filename);

					$updatedata['image'] = $filename;
				}

				$update_categoryname = DB::table('category')->where('id', '=', $id)->update($updatedata);
				return Redirect::to('admin/category');
			} else {
				$check_category = category::where('category_name', '=', $categoryname)->count();
				if ($check_category >= 1) {
					return Redirect::back()
						->withErrors(['category_name' => 'Category name already exist in database.']);
				} else {
					$update_category = DB::table('category')->where('id', '=', $id)->update($updatedata);
					return Redirect::to('admin/category');
				}
			}

		}

	}

	public function search(Request $request) {
		$data = $request->all();
		$category_name = $data['search'][0];
		$project_name = $data['search'][1];
		$type = $data['search'][2];

		$userid = Auth::user()->id;

		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');

		}
		//$organization = user::where('id','=',$userid)->value('organization');

		if (count($organization) > 0) {
			$search_category = category::leftjoin('projects', 'category.project_name', '=', 'projects.id')
				->join('project_clients', 'project_clients.project_id', '=', 'category.project_name')
				->whereIn('project_clients.client_name', $organization)
				->orderBy('category.id', 'desc')
				->groupBy('category.id')
				->select('category.id', 'projects.project_name', 'category.category_name', 'category.project_name as prname', 'category.type', 'category.image')->where('category.is_active', '=', '1');
			if (!empty($project_name)) {
				$search_category = $search_category->where('projects.project_name', 'LIKE', $project_name . '%');
			}
			if (!empty($category_name)) {
				$search_category = $search_category->where('category.category_name', 'LIKE', $category_name . '%');
			}
			if (!empty($type)) {
				$search_category = $search_category->where('category.type', 'LIKE', $type . '%');
			}

			$search_category = $search_category->get();
		} else {
			$search_category = category::leftjoin('projects', 'category.project_name', '=', 'projects.id')
				->orderBy('category.id', 'desc')
				->select('category.id', 'projects.project_name', 'category.category_name', 'category.project_name as prname', 'category.type', 'category.image')->where('category.is_active', '=', '1');
			if (!empty($project_name)) {
				$search_category = $search_category->where('projects.project_name', 'LIKE', $project_name . '%');
			}
			if (!empty($category_name)) {
				$search_category = $search_category->where('category.category_name', 'LIKE', $category_name . '%');
			}
			if (!empty($type)) {
				$search_category = $search_category->where('category.type', 'LIKE', $type . '%');
			}

			$search_category = $search_category->get();
		}

		foreach ($search_category as $client) {
			$projectid = $client->prname;
			$client->client_count = project_clients::join('clients', 'clients.id', '=', 'project_clients.client_name')
				->where('project_id', '=', $projectid)
				->count();

			if (!empty($client->image) && file_exists('public/category/' . $client->image)) {
				$client->image = URL::to('public/category/' . $client->image);
			} else {
				$client->image = URL::to('public/upload/default.jpg');
			}

		}
		$data = $search_category;

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

	public function viewclient(Request $request, $id) {
		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');

		}

		$viewclients = project_clients::where('project_id', '=', $id)
			->leftjoin('clients', 'clients.id', '=', 'project_clients.client_name')
			->join('state', 'state.id', '=', 'clients.state')
			->select('clients.*', 'state.state_name');

		if (count($organization) > 0) {
			$viewclients = $viewclients->whereIn('project_clients.client_name', $organization);
		}

		$viewclients = $viewclients->get();

		return view('pages.viewclient', compact('viewclients', 'id'));
	}

	public function viewclientsearch(Request $request) {
		$data = $request->all();
		$projectid = $data['projectId'];
		$item_no = $data['search'][0];
		$client_name = $data['search'][1];
		$street_address = $data['search'][2];
		$city = $data['search'][3];
		$state_name = $data['search'][4];

		$organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
		if ($request->session()->has('adminclient')) {
			$organization = session('adminclient');

		}

		$viewclients = project_clients::leftjoin('clients', 'clients.id', '=', 'project_clients.client_name')
			->join('state', 'state.id', '=', 'clients.state')
			->select('clients.*', 'state.state_name')
			->where('project_id', '=', $projectid);

		if (!empty($item_no)) {
			$viewclients = $viewclients->where('clients.item_no', 'LIKE', $item_no . '%');
		}

		if (!empty($client_name)) {
			$viewclients = $viewclients->where('clients.client_name', 'LIKE', $client_name . '%');
		}

		if (!empty($street_address)) {
			$viewclients = $viewclients->where('clients.street_address', 'LIKE', $street_address . '%');
		}

		if (!empty($city)) {
			$viewclients = $viewclients->where('clients.city', 'LIKE', $city . '%');
		}

		if (!empty($state_name)) {
			$viewclients = $viewclients->where('state.state_name', 'LIKE', $state_name . '%');
		}

		if (count($organization) > 0) {
			$viewclients = $viewclients->whereIn('project_clients.client_name', $organization);
		}

		$viewclients = $viewclients->get();

		$data = $viewclients;

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

	public function remove($id) {
		$removedata = array('is_delete' => '1', 'is_active' => '0');
		$remove = DB::table('category')->where('id', '=', $id)->delete();
		return Redirect::to('admin/category');

	}
}
