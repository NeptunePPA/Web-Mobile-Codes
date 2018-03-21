<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;

use Auth;
use App\User;
use App\clients;
use App\device;
use App\Categorysort;
use App\userProjects;
use App\category;


class usermenu extends Controller
{
    public function index()
	{

		/*get selected clientdetails*/
		$clientdetails =  session('details');
		$clients = $clientdetails['clients'];


		/*get categories*/
		$userid =Auth::user()->id;
		$projects = Auth::user()->projectname;
        $categories = category::where('project_name',$projects)->pluck('id');


		if(Auth::user()->roll == 2)
		{
			$projects = $clientdetails['projects'];
			$categories = category::where('project_name',$projects)->pluck('id');			
		}


		$user_organization = $clients;


	    $newdevices = device::leftjoin('client_price', 'client_price.device_id', '=', 'device.id')
	             ->join('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
	             ->select('device.*', 'client_price.device_id', 'client_price.unit_cost', 'client_price.bulk_unit_cost', 'client_price.bulk_unit_cost_check', 'client_price.bulk', 'client_price.bulk_check', 'client_price.cco_discount', 'client_price.cco_discount_check', 'client_price.unit_rep_cost', 'client_price.unit_rep_cost_check', 'client_price.unit_repless_discount', 'client_price.unit_repless_discount_check', 'client_price.system_cost', 'client_price.system_cost_check', 'client_price.bulk_system_cost', 'client_price.bulk_system_cost', 'client_price.bulk_system_cost_check', 'client_price.system_repless_cost', 'client_price.system_repless_cost_check', 'client_price.system_repless_discount', 'client_price.system_repless_discount_check', 'client_price.reimbursement', 'client_price.reimbursement_check','client_price.system_bulk','client_price.system_bulk_check', 'client_price.order_email', 'manufacturers.manufacturer_logo')
	             ->where('client_price.client_name', '=', $user_organization)
	             ->whereIn('device.category_name', $categories)
	             ->where('device.is_delete', '=', 0)
	             ->where('device.status', '=', 'Enabled')
	             ->where('client_price.system_cost_check', '=', 'True')
				 ->where('client_price.is_delete', '=', 0)
				 ->get();

				
		$changeout = device::join('client_price', 'client_price.device_id', '=', 'device.id')
	            ->join('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
	            ->select('device.*', 'client_price.device_id', 'client_price.unit_cost', 'client_price.bulk_unit_cost', 'client_price.bulk_unit_cost_check', 'client_price.bulk', 'client_price.bulk_check', 'client_price.cco_discount', 'client_price.cco_discount_check', 'client_price.unit_rep_cost', 'client_price.unit_rep_cost_check', 'client_price.unit_repless_discount', 'client_price.unit_repless_discount_check', 'client_price.system_cost', 'client_price.system_cost_check', 'client_price.bulk_system_cost', 'client_price.bulk_system_cost', 'client_price.bulk_system_cost_check', 'client_price.system_repless_cost', 'client_price.system_repless_cost_check', 'client_price.system_repless_discount', 'client_price.system_repless_discount_check', 'client_price.reimbursement', 'client_price.reimbursement_check','client_price.cco','client_price.cco_check', 'client_price.order_email', 'manufacturers.manufacturer_logo')
	            ->where('client_price.client_name', '=', $user_organization)
	            ->whereIn('device.category_name', $categories)
	            ->where('device.is_delete', '=', 0)
	            ->where('device.status', '=', 'Enabled')
	            ->where('client_price.unit_cost_check', '=', 'True')
				->get();

//            if(count($changeout) == 0 && count($newdevices) == 0)
//            {
//                $nodevice = "True";
//            }
//            if(count($newdevices) == 0)
//            {
//                return Redirect::to('changeout/mainmenu');
//            }
//            else if(count($changeout) == 0)
//            {
//                return Redirect::to('newdevice/mainmenu');
//            }
		$nodevice = "False";
		return view('pages/frontend/usermenu',compact('nodevice'));
	}
	
	public function newdevice_menu()
	{

		/*get selected clientdetails*/
		$clientdetails =  session('details');
		$clients = $clientdetails['clients'];

        $categories = user::join('user_projects','user_projects.userId','=','users.id')
            ->join('category','category.project_name','=','user_projects.projectId')
		    ->join('device','device.category_name','=','category.id')
		    ->join('client_price', 'client_price.device_id', '=', 'device.id')
			->leftjoin('category_sort','category_sort.category_name','=','category.id')
			->where('category_sort.client_name','=',$clients)
			->where('client_price.client_name', '=', $clients)
			->where('device.is_delete', '=', 0)
			->where('device.status', '=', 'Enabled')
			->select('category.id','category.category_name')
            ->where('category.is_delete','=',0)
			->where('users.id','=',Auth::user()->id)
			->where('client_price.system_cost_check', '=', 'True')
			->where('client_price.is_delete', '=', 0)
			->groupBy('category.id')
			->orderBy('category_sort.sort_number','asc')
			->get();


		/*get categories by project name */
	 	if(Auth::user()->roll == 2)
	 	{
            $projects = $clientdetails['projects'];
			$categories = category::leftJoin('device','device.category_name','=','category.id')
					  ->join('client_price', 'client_price.device_id', '=', 'device.id')
			          ->leftjoin('category_sort','category_sort.category_name','=','category.id')
			          ->where('category_sort.client_name','=',$clients)
			          ->where('client_price.client_name', '=', $clients)
			          ->where('device.is_delete', '=', 0)
			          ->where('device.status', '=', 'Enabled')
			          ->select('category.id','category.category_name')
			          ->where('category.is_delete','=',0)
			          ->where('category.project_name',$projects)
			          ->where('client_price.system_cost_check', '=', 'True')
                      ->where('client_price.is_delete', '=', 0)
            		  ->groupBy('category.id')
                      ->orderBy('category_sort.sort_number','asc')
           			  ->get();
	 	}

	 	$devicetype = "New Device"; 

		return view('pages/frontend/mainmenu',compact('categories','devicetype'));
	}

	public function changeout_menu()
	{

		/*get selected clientdetails*/
		$clientdetails =  session('details');
		$clients = $clientdetails['clients'];

		$categories = user::join('user_projects','user_projects.userId','=','users.id')
            ->join('category','category.project_name','=','user_projects.projectId')
			->join('device','device.category_name','=','category.id')
			->join('client_price', 'client_price.device_id', '=', 'device.id')
			->leftjoin('category_sort','category_sort.category_name','=','category.id')
			->where('category_sort.client_name','=',$clients)
			->where('client_price.client_name', '=',$clients)
			->where('device.is_delete', '=', 0)
			->where('device.status', '=', 'Enabled')
			->select('category.id','category.category_name')
            ->where('category.is_delete','=',0)
			->where('users.id','=',Auth::user()->id)
			->where('client_price.unit_cost_check', '=', 'True')
			->where('client_price.is_delete', '=', 0)
			->groupBy('category.id')
			->orderBy('category_sort.sort_number','asc')
			->get();


		/*get categories by project name */
		if(Auth::user()->roll == 2)
		{
			$projects = $clientdetails['projects'];
			$categories = category::leftJoin('device','device.category_name','=','category.id')
					  ->join('client_price', 'client_price.device_id', '=', 'device.id')
			          ->leftjoin('category_sort','category_sort.category_name','=','category.id')
			          ->where('category_sort.client_name','=',$clients)
			          ->where('client_price.client_name', '=', $clients)
			          ->where('device.is_delete', '=', 0)
			          ->where('device.status', '=', 'Enabled')
			          ->select('category.id','category.category_name')
			          ->where('category.is_delete','=',0)
			          ->where('category.project_name',$projects)
			          ->where('client_price.unit_cost_check', '=', 'True')
                      ->where('client_price.is_delete', '=', 0)
            		  ->groupBy('category.id')
                      ->orderBy('category_sort.sort_number','asc')
           			  ->get();
        }

        $devicetype = "Changeout";

		return view('pages/frontend/mainmenu',compact('categories','devicetype'));
	}
}
