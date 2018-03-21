<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\manufacturers;

use App\order;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Input;

use Auth;
use App\user;
use App\device;
use Response;
use App\userClients;


class marketshare extends Controller
{
    public function index(Request $request)
	{
		$pagesize = $request->get('pagesize');
 		if ($pagesize == "") {
             $pagesize = 10;
         }
 		    $count_orders = order::where('status','=','Complete')->count();
 				$userid = Auth::user()->id;

 				$organization = userClients::where('userId',Auth::user()->id)->select('clientId')->get();
	            if($request->session()->has('adminclient'))
	            {
	                $organization =  session('adminclient');
	            }

        if(Auth::user()->roll == 2)
        {
				$count_orders = order::whereIn('orders.clientId',$organization)
								->where('orders.status','=','Complete')
								->count();

 				$marketshares = manufacturers::leftJoin('orders','orders.manufacturer_name','=','manufacturers.id')
								// ->leftJoin('users','users.id','=','orders.orderby')
								// ->leftJoin('user_clients','user_clients.userId','=','users.id')
								->whereIn('orders.clientId',$organization)
								->select('manufacturers.manufacturer_name',DB::raw('count(orders.manufacturer_name)*100/'.$count_orders.' as percentage'),DB::raw('count(orders.manufacturer_name) as no_of_order'))
								->groupBy('orders.manufacturer_name')
								->where('orders.status','=','Complete')
								->distinct()
								->paginate($pagesize);


 		}
 		else if(count($organization) > 0 && Auth::user()->roll == 1) {
            $count_orders = order::whereIn('orders.clientId', $organization)
                ->where('orders.status', '=', 'Complete')
                ->count();

            $marketshares = manufacturers::leftJoin('orders', 'orders.manufacturer_name', '=', 'manufacturers.id')
                // ->leftJoin('users','users.id','=','orders.orderby')
                // ->leftJoin('user_clients','user_clients.userId','=','users.id')
                ->whereIn('orders.clientId', $organization)
                ->select('manufacturers.manufacturer_name', DB::raw('count(orders.manufacturer_name)*100/' . $count_orders . ' as percentage'), DB::raw('count(orders.manufacturer_name) as no_of_order'))
                ->groupBy('orders.manufacturer_name')
                ->where('orders.status', '=', 'Complete')
                ->distinct()
                ->paginate($pagesize);
        } else if(count($organization) <= 0 && Auth::user()->roll == 1){

 				$marketshares = manufacturers::join('orders','orders.manufacturer_name','=','manufacturers.id')
								->select('manufacturers.manufacturer_name',DB::raw('count(orders.manufacturer_name)*100/'.$count_orders.' as percentage'),DB::raw('count(orders.manufacturer_name) as no_of_order'))
								->groupBy('orders.manufacturer_name')
								->where('orders.status','=','Complete')
								->paginate($pagesize);
 				
 		}
 		else if(Auth::user()->roll == 5)
 		{
 			$userid = Auth::user()->id;
 			$organization = user::where('id','=',$userid)->value('organization');
 			$count_orders = order::join('users','users.id','=','orders.orderby')
							->where('orders.manufacturer_name','=',$organization)
							->where('orders.status','=','Complete')
							->count();
							
 			$marketshares = manufacturers::leftJoin('orders','orders.manufacturer_name','=','manufacturers.id')
							->where('manufacturers.id','=',$organization)
							->select('manufacturers.manufacturer_name',DB::raw('count(orders.manufacturer_name)*100/'.$count_orders.' as percentage'),DB::raw('count(orders.manufacturer_name) as no_of_order'))
							->groupBy('orders.manufacturer_name')
							->where('orders.status','=','Complete')
							->where('orders.is_delete','=',0)
							->paginate($pagesize);
 		}
 	
 	$count = count($marketshares);
 		return view('pages.marketshare',compact('marketshares','count','pagesize'));
	
	}
	
	
	public function search(Request $request)
	{
		$fieldname = Input::get('fieldName');
		$fieldvalue = Input::get('value');
		
		$count_orders = order::where('status','=','Complete')->where('orders.is_delete','=',0)->count();

        $organization = userClients::where('userId',Auth::user()->id)->select('clientId')->get();
        if($request->session()->has('adminclient'))
        {
            $organization =  session('adminclient');

        }

				$userid = Auth::user()->id;

        if(Auth::user()->roll == 2)
        {
	            $count_orders = order::whereIn('orders.clientId',$organization)
								->where('orders.status','=','Complete')
//								->groupBy('users.id')
								->count();

								
				$search_marketshares = manufacturers::join('orders','orders.manufacturer_name','=','manufacturers.id')
//										->join('users','users.id','=','orders.orderby')
//										->leftJoin('user_clients','user_clients.userId','=','users.id')
										->whereIn('orders.clientId',$organization)
										->select('manufacturers.manufacturer_name',DB::raw('count(orders.manufacturer_name)*100/'.$count_orders.' as percentage'),DB::raw('count(orders.manufacturer_name) as no_of_order'))
										->groupBy('orders.manufacturer_name')
										->where('orders.status','=','Complete')
//										->where('orders.is_delete','=',0)
										->where($fieldname,'LIKE',$fieldvalue.'%')
                                        ->distinct()
										->get();
		}
		else if(count($organization) > 0 && Auth::user()->roll == 1)
		{
            $count_orders = order::whereIn('orders.clientId',$organization)
                ->where('orders.status','=','Complete')
//								->groupBy('users.id')
                ->count();


            $search_marketshares = manufacturers::join('orders','orders.manufacturer_name','=','manufacturers.id')
//										->join('users','users.id','=','orders.orderby')
//										->leftJoin('user_clients','user_clients.userId','=','users.id')
                ->whereIn('orders.clientId',$organization)
                ->select('manufacturers.manufacturer_name',DB::raw('count(orders.manufacturer_name)*100/'.$count_orders.' as percentage'),DB::raw('count(orders.manufacturer_name) as no_of_order'))
                ->groupBy('orders.manufacturer_name')
                ->where('orders.status','=','Complete')
//										->where('orders.is_delete','=',0)
                ->where($fieldname,'LIKE',$fieldvalue.'%')
                ->distinct()
                ->get();

        } else if(count($organization) <= 0 && Auth::user()->roll == 1)
        {
				
				$search_marketshares = manufacturers::join('orders','orders.manufacturer_name','=','manufacturers.id')
										->select('manufacturers.manufacturer_name',DB::raw('count(orders.manufacturer_name)*100/'.$count_orders.' as percentage'),DB::raw('count(orders.manufacturer_name) as no_of_order'))
										->groupBy('orders.manufacturer_name')
										->where('orders.status','=','Complete')
										->where('orders.is_delete','=',0)
										->where($fieldname,'LIKE',$fieldvalue.'%')
										->get();
		}
		else if(Auth::user()->roll == 5)
		{
			$userid = Auth::user()->id;
			$organization = user::where('id','=',$userid)->value('organization');
			$count_orders = order::join('users','users.id','=','orders.orderby')
							->where('orders.manufacturer_name','=',$organization)
							->where('orders.is_delete','=',0)
							->where('orders.status','=','Complete')
							->count();
							
			$search_marketshares = manufacturers::join('orders','orders.manufacturer_name','=','manufacturers.id')
									->where('manufacturers.id','=',$organization)
									->select('manufacturers.manufacturer_name',DB::raw('count(orders.manufacturer_name)*100/'.$count_orders.' as percentage'),DB::raw('count(orders.manufacturer_name) as no_of_order'))
									->groupBy('orders.manufacturer_name')
									->where('orders.status','=','Complete')
									->where('orders.is_delete','=',0)
									->where($fieldname,'LIKE',$fieldvalue.'%')
									->get();
		}
		
		$data = $search_marketshares;
		
		if(count($data))
			return [
						'value' => $data,
						'status' => TRUE
				   ];
		else
			return [
						'value'=>'No Result Found',
						'status' => FALSE
				   ];
	}
	
	
	public function export(Request $request)
	{
        $userid = Auth::user()->id;

        $organization = userClients::where('userId',Auth::user()->id)->select('clientId')->get();

        if($request->session()->has('adminclient'))
        {
            $organization =  session('adminclient');

        }

        if(Auth::user()->roll == 2)
        {

            $count_orders = order::join('users','users.id','=','orders.orderby')
                ->leftJoin('user_clients','user_clients.userId','=','users.id')
                ->whereIn('user_clients.clientId',$organization)
                ->where('orders.is_delete','=',0)
                ->where('orders.status','=','Complete')
                ->count();

            $marketshares = manufacturers::join('orders','orders.manufacturer_name','=','manufacturers.id')
                ->join('users','users.id','=','orders.orderby')
                ->leftJoin('user_clients','user_clients.userId','=','users.id')
                ->whereIn('user_clients.clientId',$organization)
                ->select('manufacturers.manufacturer_name',DB::raw('count(orders.manufacturer_name)*100/'.$count_orders.' as percentage'),DB::raw('count(orders.manufacturer_name) as no_of_order'))
                ->groupBy('orders.manufacturer_name')
                ->where('orders.is_delete','=',0)
                ->where('orders.status','=','Complete')->get();
        }
        else if(count($organization) > 0 && Auth::user()->roll == 1) {
            $userid = Auth::user()->id;

            $organization = userClients::where('userId',Auth::user()->id)->select('clientId')->get();

            if($request->session()->has('adminclient'))
            {
                $organization =  session('adminclient');

            }


            $count_orders = order::join('users','users.id','=','orders.orderby')
                ->leftJoin('user_clients','user_clients.userId','=','users.id')
                ->whereIn('user_clients.clientId',$organization)
                ->where('orders.is_delete','=',0)
                ->where('orders.status','=','Complete')
                ->count();

            $marketshares = manufacturers::join('orders','orders.manufacturer_name','=','manufacturers.id')
                ->join('users','users.id','=','orders.orderby')
                ->leftJoin('user_clients','user_clients.userId','=','users.id')
                ->whereIn('user_clients.clientId',$organization)
                ->select('manufacturers.manufacturer_name',DB::raw('count(orders.manufacturer_name)*100/'.$count_orders.' as percentage'),DB::raw('count(orders.manufacturer_name) as no_of_order'))
                ->groupBy('orders.manufacturer_name')
                ->where('orders.is_delete','=',0)
                ->where('orders.status','=','Complete')->get();

        } else if(count($organization) <= 0 && Auth::user()->roll == 1){

            $count_orders = order::where('status','=','Complete')->where('is_delete','=',0)->count();
            $marketshares = manufacturers::join('orders','orders.manufacturer_name','=','manufacturers.id')
                ->select('manufacturers.manufacturer_name',DB::raw('count(orders.manufacturer_name)*100/'.$count_orders.' as percentage'),DB::raw('count(orders.manufacturer_name) as no_of_order'))
                ->groupBy('orders.manufacturer_name')
                ->where('orders.is_delete','=',0)
                ->where('orders.status','=','Complete')
                ->get();

        }
        else if(Auth::user()->roll == 5)
		{
			$userid = Auth::user()->id;
			$organization = user::where('id','=',$userid)->value('organization');
			$count_orders = order::join('users','users.id','=','orders.orderby')
							->where('orders.manufacturer_name','=',$organization)
							->where('orders.is_delete','=',0)
							->where('orders.status','=','Complete')
							->count();
							
			$marketshares = manufacturers::join('orders','orders.manufacturer_name','=','manufacturers.id')
							->where('manufacturers.id','=',$organization)
							->select('manufacturers.manufacturer_name',DB::raw('count(orders.manufacturer_name)*100/'.$count_orders.' as percentage'),DB::raw('count(orders.manufacturer_name) as no_of_order'))
							->groupBy('orders.manufacturer_name')
							->where('orders.is_delete','=',0)
							->where('orders.status','=','Complete')
							->get();
		}

						
		$filename = "marketshare.csv";
			$handle = fopen($filename, 'w+');
			fputcsv($handle, array('Manufacturer Name', 'Marketshare','No. Of Orders'));
		
			foreach($marketshares as $row) {
				fputcsv($handle, array($row['manufacturer_name'], $row['percentage'], $row['no_of_order']));
			}
		
			fclose($handle);
		
			$headers = array(
				'Content-Type' => 'text/csv',
			);
		
			return Response::download($filename, 'marketshare.csv', $headers);
			return Redirect::to('admin/marketshare');
	}
}
