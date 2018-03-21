<?php

namespace App\Http\Controllers\CategoryGroup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\CategoryGroup;
use App\project;
use App\category;
use App\userClients;
use Auth;

class CategoryGroupController extends Controller
{
    public function index()
    {
        $category = CategoryGroup::orderby('id','DESC')->get();
        return view('pages.category_group.index', compact('category'));
    }

    public function create(Request $request)
    {
        $organization = userClients::where('userId',Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');
        }


        $project = ['' => "Select Project"] + project::leftjoin('project_clients', 'project_clients.project_id', '=', 'projects.id')
                ->where('projects.is_delete', 0)
                ->pluck('projects.project_name', 'projects.id')->all();

        if (count($organization) > 0) {
            $project = ['' => "Select Project"] + project::leftjoin('project_clients', 'project_clients.project_id', '=', 'projects.id')
                    ->where('projects.is_delete', 0)
                    ->whereIn('project_clients.client_name', $organization)
                    ->pluck('projects.project_name', 'projects.id')->all();
        }


        $category = array('' => 'Select Category');

        return view('pages.category_group.create', compact('project', 'category'));
    }

    public function store(Request $request)
    {
        $rules = array(
            'project_name' => 'required',
            'category_group_name' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }
        $data = array();
        foreach ($request->get('category') as $row) {

            $data['project_id'] = $request->get('project_name');
            $data['category_group_name'] = $request->get('category_group_name');
            $data['category_id'] = $row;

            $group = new CategoryGroup();
            $group->fill($data);
            $group->save();
        }

        return \redirect('admin/category-group');
    }

    public function getcategories(Request $request)
    {

        $project = $request->get('project');

        $project_data = array();
        $getdata = CategoryGroup::where('project_id', $project)->get();

        foreach ($getdata as $row) {
            $project_data[] = $row->category_id;
        }

        $data = category::where('project_name', $project)->where('is_active', '1');
        if (count($project_data) > 0) {
            $data = $data->whereNotIn('id', $project_data);
        }
        $data = $data->get();

        if (count($data))
            return [
                'value' => $data,
                'status' => TRUE
            ];
        else
            return [
                'value' => 'No Result Found',
                'status' => FALSE
            ];
    }

    public function delete(Request $request){

        $data = $request->all();

        $remove = CategoryGroup::whereIn('id', $data['ck_rep'])->delete();

        if ($remove)
            return [
                'value' => "Success",
                'status' => TRUE
            ];
        else
            return [
                'value' => 'No result Found',
                'status' => FALSE
            ];
    }
}
