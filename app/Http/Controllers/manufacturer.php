<?php

namespace App\Http\Controllers;

use App\manufacturers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class manufacturer extends Controller {
	public function index(Request $request) {
		$pagesize = $request->get('pagesize');
		if ($pagesize == "") {
			$pagesize = 10;
		}
		$manufacturers = manufacturers::where('is_delete', '=', 0)->orderby('id', 'DESC')->paginate($pagesize);
		$count = manufacturers::where('is_delete', '=', 0)->count();
		return view('pages.manufacturers', compact('manufacturers', 'count', 'pagesize'));
	}

	public function add() {
		return view('pages.addmanufacturer');
	}

	public function create() {
		$rules = array(
			'manufacturer_name' => 'required|unique:manufacturers,manufacturer_name',
			'manufacturer_logo' => 'required',
		);
		$insertdata = array(
			'manufacturer_name' => Input::get('manufacturer_name'),
			'manufacturer_logo' => Input::file('image'),

		);

		$validator = Validator::make($insertdata, $rules);
		if ($validator->fails()) {
			return Redirect::to('admin/manufacturer/add')->withErrors($validator);

		} else {
			$destinationpath = 'public/upload';
			$extenstion = Input::file('image')->getClientOriginalExtension();
			$filename = 'manu_logo' . '_' . rand(11111, 99999) . '.' . $extenstion;

			$id = rand(1000, 9999);

			$insertdata = array(
				'item_no' => $id,
				'manufacturer_name' => Input::get('manufacturer_name'),
				'manufacturer_logo' => $filename,
				'short_name' => Input::get('manufacturer_short_name'),

			);
			$insert_manufacturer = 0;
			$insert_manufacturer = manufacturers::insert($insertdata);
			if ($insert_manufacturer > 0) {

				$move = Input::file('image')->move($destinationpath, $filename);

				return Redirect::to('admin/manufacturer');
			} else {
				return fail;
			}
		}

	}

	public function edit($id) {
		$manufacturers = manufacturers::FindOrFail($id);
		return view('pages.editmanufacturer', compact('manufacturers'));
	}

	public function update($id, Request $request) {

		if ($request->hasFile('image')) {
			$destinationpath = 'public/upload';
			$extenstion = $request->file('image')->getClientOriginalExtension();
			$filename = 'manu_logo' . '_' . rand(11111, 99999) . '.' . $extenstion;
			$move = $request->file('image')->move($destinationpath, $filename);

			$rules = array(
				'manufacturer_name' => 'required',
			);
			$updatedata = array(
				'manufacturer_name' => Input::get('manufacturer_name'),
				'manufacturer_logo' => $filename,

			);

			$validator = Validator::make($updatedata, $rules);
			if ($validator->fails()) {
				return Redirect::back()->withErrors($validator);

			} else {
				$updatedata['short_name'] = Input::get('manufacturer_short_name');
				$manufacturer = Input::get('manufacturer_name');
				$get_manufacturer = manufacturers::where('id', '=', $id)->value('manufacturer_name');
				if ($get_manufacturer == $manufacturer) {
					$update_manufacturer = DB::table('manufacturers')->where('id', '=', $id)->update($updatedata);
					return Redirect::to('admin/manufacturer');
				} else {
					$check_manufacturer = manufacturers::where('manufacturer_name', '=', $manufacturer)->count();
					echo $check_manufacturer;
					if ($check_manufacturer >= 1) {
						return Redirect::back()
							->withErrors(['manufacturer_name' => 'Manufacturer name already exist in database.']);
					} else {
						$update_manufacturer = DB::table('manufacturers')->where('id', '=', $id)->update($updatedata);
						return Redirect::to('admin/manufacturer');
					}
				}
			}

		} else {
			$rules = array(
				'manufacturer_name' => 'required',
			);
			$updatedata = array(
				'manufacturer_name' => Input::get('manufacturer_name'),

			);
			$validator = Validator::make($updatedata, $rules);
			if ($validator->fails()) {
				return Redirect::back()->withErrors($validator);

			} else {
				$updatedata['short_name'] = Input::get('manufacturer_short_name');
				$manufacturer = Input::get('manufacturer_name');
				$get_manufacturer = manufacturers::where('id', '=', $id)->value('manufacturer_name');
				if ($get_manufacturer == $manufacturer) {
					$update_manufacturer = DB::table('manufacturers')->where('id', '=', $id)->update($updatedata);
					return Redirect::to('admin/manufacturer');
				} else {
					$check_manufacturer = manufacturers::where('manufacturer_name', '=', $manufacturer)->count();
					if ($check_manufacturer >= 1) {
						return Redirect::back()
							->withErrors(['manufacturer_name' => 'Manufacturer name already exist in database.']);
					} else {
						$update_manufacturer = DB::table('manufacturers')->where('id', '=', $id)->update($updatedata);
						return Redirect::to('admin/manufacturer');
					}
				}
			}

		}

	}

	public function search(Request $request) {
		$data = $request->all();
		$item_no = $data['search'][0];
		$manufacturer_name = $data['search'][1];

		$search_manufacturers = manufacturers::where('is_delete', '=', 0);

		if (!empty($item_no)) {
			$search_manufacturers = $search_manufacturers->where('item_no', 'LIKE', $item_no . '%');
		}

		if (!empty($manufacturer_name)) {
			$search_manufacturers = $search_manufacturers->where('manufacturer_name', 'LIKE', $manufacturer_name . '%');
		}

		$search_manufacturers = $search_manufacturers->orderby('id', 'DESC')->get();

		$data = $search_manufacturers;

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
		$removedata = array('is_delete' => '1');
		$remove = DB::table('manufacturers')->where('id', '=', $id)->delete();
		return Redirect::to('admin/manufacturer');
	}

}
