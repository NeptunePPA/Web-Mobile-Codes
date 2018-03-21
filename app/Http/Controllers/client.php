<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\clients;
use App\state;
use App\project_clients;
use Session;
use App\city;
use Auth;
use App\category;
use App\Categorysort;
use App\project;
use App\userClients;
use App\ItemfileDetails;
use App\Itemfiles;
use App\Clientcustomfeatures;
use App\client_price;
use App\Survey;

class client extends Controller
{
    public function index(Request $request)
	{

		$pagesize = $request->get('pagesize') == "" ? 10 : $request->get('pagesize');
		/*get user clients*/

		$organization = userClients::where('userId',Auth::user()->id)->select('clientId')->get();

        if($request->session()->has('adminclient'))
        {
            $organization = session('adminclient');
        }

        if(count($organization) > 0){
            $clients = clients::orderBy('id','DESC')->whereIn('id',$organization)->paginate($pagesize);
            $count = clients::whereIn('id',$organization)->count();
        } else {

            $clients = clients::orderBy('id','DESC')->paginate($pagesize);
            $count = clients::count();
        }

		return view('pages.clients',compact('clients','count','pagesize'));
	}
	
	public function add()
	{
		$state = ['0' => 'State Name'] + state::pluck('state_name','id')->all();
		return view('pages.addclients',compact('state'));
	}
	
	public function create(Request $request)
	{
		$rules = array(
			'client_name' => 'required|unique:clients,client_name',
			'street_address'=> 'required',
			'city' => 'required',
			'state'=> 'required|not_in:0'
		);

		$id = rand(1000,9999);

		$image = '';

		if($request->hasFile('image')){

            $icon = $request->file('image');
            $filename = $request->get('client_name') . '-' . rand(0, 999) . '.' . $icon->getClientOriginalExtension();
            $icon->move('public/upload/client/', $filename);
            $image = 'upload/client/' . $filename;
        }


		$insertdata = array(
			'item_no' => $id,
			'client_name' => $request->get('client_name'),
			'street_address' => $request->get('street_address'),
			'city' => $request->get('city'),
			'state' => $request->get('state'),
			'image' => $image,
			'is_active' => '1',
			'is_delete' => '0'
		);

		$validator = Validator::make($insertdata,$rules);
		
		if($validator->fails())
		{
			return Redirect::to('admin/clients/add')
			->withErrors($validator);
		}
		else
		{
				$ck = 0;
				$ck = clients::insert($insertdata);
				if($ck > 0)
				{
					return Redirect::to('admin/clients');
				}
				else
				{
					return fail;
				}
		
		}
		
	}
	
	public function edit($id)
	{
		$state = state::pluck('state_name','id')->all();
		$clients = Clients::FindOrFail($id);
		return view('pages.editclients',compact('clients','state'));
		
	}
	
	public function update($id, Request $request)
	{
		$rules = array(
			'client_name' => 'required',
			'street_address'=> 'required',
			'city' => 'required',
			'state'=> 'required|not_in:0'
		);

        if($request->hasFile('image')){

            $getimage = clients::where('id',$id)->value('image');

            if ($getimage) {
                $filename = public_path().'/'.$getimage;

                \File::delete($filename);
            }

            $icon = $request->file('image');
            $filename = $request->get('client_name') . '-' . rand(0, 999) . '.' . $icon->getClientOriginalExtension();
            $icon->move('public/upload/client/', $filename);
            $image = 'upload/client/' . $filename;

        }
		$updatedata = array(
			'client_name' => $request->get('client_name'),
			'street_address' => $request->get('street_address'),
			'city' => $request->get('city'),
			'state' => $request->get('state'),

		);
        if($request->hasFile('image')){
            $updatedata['image'] = $image;
        }


		$validator = Validator::make($updatedata,$rules);
		
		if($validator->fails())
		{
			return Redirect::back()->withErrors($validator);
		}
		else
		{
				$clientname = Input::get('client_name');
				$get_clientname = clients::where('id','=',$id)->value('client_name');
				if($get_clientname == $clientname)
				{
					$update_clientname = DB::table('clients')->where('id','=',$id)->update($updatedata);
					return Redirect::to('admin/clients');
				}
				else
				{
					$check_clients = clients::where('client_name','=',$clientname)->count();
					if($check_clients >= 1)
					{
						return Redirect::back()
				->withErrors(['client_name' =>'Client name already exist in database.',]);
					}
					else
					{
						$update_client = DB::table('clients')->where('id','=',$id)->update($updatedata);
						return Redirect::to('admin/clients');
					}
				}
		
		}
	}
	
	public function search(Request $request)
	{
		$data = $request->all();
		$itemNo = $data['search'][0];
		$client_name = $data['search'][1];
		$street_address = $data['search'][2];
		$city = $data['search'][3];
		$state_name = $data['search'][4];

		$organization = userClients::where('userId',Auth::user()->id)->select('clientId')->get();
        if($request->session()->has('adminclient'))
        {
            $organization = session('adminclient');
        }

		$search_clients = clients::join('state','state.id','=','clients.state')->orderBy('clients.id','desc')->select('clients.*','state.state_name');

		if(!empty($itemNo)){
            $search_clients = $search_clients->where('item_no', 'LIKE', $itemNo . '%');
        }
        if(!empty($client_name)){
            $search_clients = $search_clients->where('client_name', 'LIKE', $client_name . '%');
        }
        if(!empty($street_address)){
            $search_clients = $search_clients->where('street_address', 'LIKE', $street_address . '%');
        }
        if(!empty($city)){
            $search_clients = $search_clients->where('city', 'LIKE', $city . '%');
        }
        if(!empty($state_name)){
            $search_clients = $search_clients->where('state_name', 'LIKE', $state_name . '%');
        }
        if(count($organization) > 0){
			$search_clients = $search_clients->whereIn('clients.id',$organization);
		}
		$search_clients = $search_clients->get();
		foreach ($search_clients as $clients) {
			$clients->projectcount = $clients->projectclients->count();
		}
		$data = $search_clients;
		
		
		if(count($data))
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
	
	public function remove($id)
	{
		$remove = DB::table('clients')->where('id','=',$id)->delete();
		$removefile = Itemfiles::where('clientId',$id)->delete();
        $removeprojectClient = project_clients::where('client_name',$id)->delete();
		$removedata = ItemfileDetails::where('clientId',$id)->delete();
		$removeclient = userClients::where('clientId',$id)->delete();
		$removePrice = client_price::where('client_name',$id)->delete();
		$removecustom = Clientcustomfeatures::where('client_name',$id)->delete();
		$removesurvey =Survey::where('clientId',$id)->delete();
		return Redirect::to('admin/clients');
		
	}
	
	
	public function agreeuser()
	{
		return view('pages.agree');
	}
	
	
	public function agreeconditionsuser()
	{
		$agreebutton = Input::get('agreebutton');
			
		if($agreebutton == "AGREE")
		{
			
		    $id = Auth::user()->id;
			$updatedata = array('is_agree'=>'1');
			DB::table('users')->where('id','=',$id)->update($updatedata);
			if (\Auth::user()->roll == '4') {
				return Redirect::to('admin/orders');
			} else if (\Auth::user()->roll == 5) {
				return Redirect::to('admin/marketshare');
			} else if (\Auth::user()->roll == 2) {
				return Redirect::to('admin/clients');
			} else if (\Auth::user()->roll == 1) {
				return Redirect::to('admin/clients');
			} else if (\Auth::user()->roll == 3) {
				Session::flash('message', 'Invalid Credentials');
				Auth::logout();
				return Redirect::to('admin');
			}
		}
		else
		{
			Auth::logout();
			return Redirect::to('admin');
		}
	}


	public function categorysort(Request $request)
	{
        $organization = userClients::where('userId',Auth::user()->id)->select('clientId')->get();
            if($request->session()->has('adminclient'))
            {
                $organization =  session('adminclient');
                
            }

        if(count($organization) > 0)
        {
            $clients = [NULL => 'Client Name'] + clients::whereIn('id',$organization)->pluck('client_name', 'id')->all();
		} else {
            $clients = [NULL => 'Client Name'] + clients::pluck('client_name', 'id')->all();
        }

			/*$clientname = Clients::where('id',$id)->value('client_name');
		$checkclientcategory = Categorysort::where('client_name','=',$id)->first();

		$categoryname = Category::leftjoin('project_clients','project_clients.project_id','=','category.project_name')
					   ->where('project_clients.client_name','=',$id)
					   ->select('category.id as sort_number','category.category_name','category.id')
					   ->get();

		$categorysort = Categorysort::leftjoin('category','category.id','=','category_sort.category_name')
						->where('category_sort.client_name','=',$id)
						->select('category.id as categoryid','category_sort.id as categorysortid','category_sort.sort_number','category.category_name')->orderBy('category_sort.sort_number','asc')->get();
			   
		*/
		return view('pages.categorysort',compact('clients'));
		
	}

	public function getcategoryname()
	{
		$clientname = Input::get('clientid');
	    
	  //  $checksort = Categorysort::where('client_name','=',$clientname)->first();

	    $getprojects = project_clients::where('client_name','=',$clientname)->select('project_id')->get();

	    $getcategoryname = Category::whereIn('project_name',$getprojects)->select('id')->get();
	   	$flag = true;
	   	
	   	foreach ($getcategoryname as $row) {
	   		$category = $row->id;
	   		$checkcategory = Categorysort::where('category_name','=',$row->id)->where('client_name','=',$clientname)->first();
	   		if($checkcategory == "")
	   		{
	   			$flag = false;
	   		}
	   	}
	   	if($flag)
	   	{
	   			$getclientname = Categorysort::Join('category','category.id','=','category_sort.category_name')
	   				->Join('projects','projects.id','=','category.project_name')
	   				->whereIn('category_sort.category_name',$getcategoryname)
			   		->where('category_sort.client_name','=',$clientname)
			   		->select('category.id as categoryid','projects.project_name','category_sort.id as categorysortid','category_sort.sort_number','category.category_name')
			   		->orderBy('category_sort.sort_number','asc')
			   		->get();
		}
		else
		{
			$getclientname = Category::leftjoin('projects','projects.id','=','category.project_name')
				   ->leftjoin('project_clients','project_clients.project_id','=','category.project_name')
				   ->where('project_clients.client_name','=',$clientname)
				   ->select('category.id as sort_number','projects.project_name','category.category_name','category.id')
				   ->orderBy('category.id','asc')
			   	   ->get();
		}
		
    /*   $getclientname = Category::leftjoin('projects','projects.id','=','category.project_name')
				   ->leftjoin('project_clients','project_clients.project_id','=','category.project_name')
				   ->where('project_clients.client_name','=',$clientname)
				   ->select('category.id as sort_number','projects.project_name','category.category_name','category.id')
				   ->get();*/

  /*      if($checksort != "")
    	{
    		$getclientname = Categorysort::leftjoin('category','category.id','=','category_sort.category_name')
					->leftjoin('projects','projects.id','=','category.project_name')
			   		->leftJoin('project_clients','project_clients.project_id','=','category.category_name')
			   		->where('category_sort.client_name','=',$clientname)
					->select('category.id as categoryid','projects.project_name','category_sort.id as categorysortid','category_sort.sort_number','category.category_name')->orderBy('category_sort.sort_number','asc')->get();
	}*/	
		

        

        $data = $getclientname;

        if (count($data))
            return [
                'value' => $data,
                'status' => TRUE
            ];
        else
            return [
                'value' => 'No result Found',
                'status' => FALSE
            ];
	}

	public function categorysortstore(Request $request)
	{
		
		$categoryname = $request['categoryname'];
		$clientname = $request['clientid'];
		$removecategorysort = Categorysort::where('client_name','=',$clientname)->delete();
        $i = 1;
		foreach ($categoryname as $index => $value) {
			
			$categoryid = Category::where('category_name','=',$categoryname[$index])->value('id');
			
			if($categoryid != "")
			{
	        	$insert = new Categorysort();
				$insert->sort_number = $i++;
				$insert->client_name = $clientname;
				$insert->category_name = $categoryid;
				$insert->save();
			}
		}

		return['value' =>'Category Sorting Successfully..!', 'status' => True];  
       
		/*$categoryid = Category::where('category_name','=',$categoryname)->value('id');
		$clientname = $request['clientid'];
		if($sortnumber != "" && $categoryid != "")
        {
        	$removecategorysort = Categorysort::where('client_name','=',$clientname)->delete();
        	$insert = new Categorysort();
			$insert->sort_number = $sortnumber;
			$insert->client_name = $clientname;
			$insert->category_name = $categoryid;
			$insert->save();

        }*/

		/* $validator = \Validator::make($request->all(), [
            'sort_number.*' => 'required|numeric',
          ]);
		 if($validator->fails()) {
            return back()->withErrors($validator);
         }
			foreach ($request['sort_number'] as $index => $value) {
				$checkunique = Categorysort::Where('client_name','=',$request['client_name'])
							  ->where('sort_number','=',$value)->first();
				if($checkunique == "")
				{
					$insert = new Categorysort();
					$insert->sort_number = $value;
					$insert->client_name = $request['client_name'];
					$insert->category_name = $request['category_id'][$index];
					$insert->save();
				}
				else
				{
					$removeinserted = Categorysort::where('client_name',$request['client_name'])->delete();
					return back()->withErrors(['sort_number' => 'Sort Number '.$value.' already exist..!']);
					
				}
			}
		
		    return redirect::back();

		*/

	}
	

	
	
	public function categorysortupdate(Request $request)
	{
		$validator = \Validator::make($request->all(), [
            'sort_number.*' => 'required|numeric',
          ]);
		 if($validator->fails()) {
            return back()->withErrors($validator);
         }
         $removeinserted = Categorysort::where('client_name',$request['client_name'])->delete();
			
		foreach ($request['sort_number'] as $index => $value) {

				$insert = new Categorysort();
				$insert->sort_number = $value;
				$insert->client_name = $request['client_name'];
				$insert->category_name = $request['categoryid'][$index];
				$insert->save();
			
			}
		return redirect::back();


		
	}


	public function categorysortremove($id)
	{
		$remove = Categorysort::where('id',$id)->delete();
		return redirect::back();
	}
}
