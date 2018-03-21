<?php

namespace App\Http\Middleware;

use Closure;

use Auth;

use Session;

use Route;

class rollwise
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$user_id = Auth::user()->roll;
        $url = $request->route()->uri();
		$agreeterms = Auth::user()->value('is_agree');

		if($user_id == 1)
		{
			if($url == "admin/clients"  || $url == "admin/clients/add" || $url == "admin/clients/create" ||$url == "admin/clients/edit/{id}" || $url == "admin/clients/update/{id}" || $url == "admin/clients/remove/{id}" || $url == "admin/clients/category/sort" || $url == "admin/clients/category/sort/store" || $url == "admin/clients/category/sort/update" || $url == "admin/clients/category/sort/remove/{id}")
			{
               	return $next($request);
			}
			else if($url == "admin/projects" || $url == "admin/projects/add" || $url == "admin/projects/create" ||$url == "admin/projects/edit/{id}" || $url == "admin/projects/update/{id}" || $url == "admin/projects/remove/{id}" || $url == "admin/project_clients/remove/{id}" )
			{
				return $next($request);
			}
		    else if($url == "admin/category" || $url == "admin/category/add" || $url == "admin/category/create" ||$url == "admin/category/edit/{id}" || $url == "admin/category/update/{id}" || $url == "admin/category/remove/{id}" || $url == "admin/category/viewclient/{id}")
			{
				return $next($request);
			}
		    else if($url == "admin/users" || $url == "admin/users/add" || $url == "admin/users/create" || $url == "admin/users/edit/{id}" || $url == "admin/users/updateall"|| $url == "admin/users/update/{id}" || $url == "admin/users/remove/{id}")
			{
				return $next($request);
			}
			else if($url == "admin/manufacturer" || $url == "admin/manufacturer/add" || $url == "admin/manufacturer/create" ||$url == "admin/manufacturer/edit/{id}" || $url == "admin/manufacturer/update/{id}" || $url == "admin/manufacturer/remove/{id}")
			{
				return $next($request);
			}
			else if($url == "admin/devices" || $url == "admin/devices/add" || $url == "admin/devices/create" || $url == "admin/devices/edit/{id}" || $url == "admin/devices/update/{id}" || $url == "admin/devices/remove/{id}" || $url == "admin/devices/view/{id}" ||$url == "admin/devices/clientprice/{id}" || $url == "admin/devices/clientpricecreate" || $url == "admin/devices/clientpriceedit/{id}" || $url == "admin/devices/clientpriceremove/{id}" || $url == "admin/devices/clientpriceupdate/{id}" || $url == "admin/devices/customfield/remove/{id}" || $url == "admin/getcategory" || $url == "admin/devices/devicefeatures/{id}" || $url == "admin/devices/devicefeatures/create" || $url == "admin/devices/devicefeatures/edit/{id}" || $url == "admin/devices/devicefeatures/update/{id}" || $url == "admin/devices/devicefeatures/remove/{id}")
			{
				return $next($request);
			}
			else if($url == "admin/orders" || $url == "admin/orders/updateall" ||$url == "admin/orders/edit/{id}" || $url == "admin/orders/update/{id}" || $url == "admin/orders/remove/{id}" || $url == "admin/orders/archive" || $url == "admin/orders/viewarchive")
			{
				return $next($request);
			}
			else if($url == "admin/schedule" || $url == "admin/getclientname" || $url == "admin/getdevicename" || $url == "admin/schedule/add" || $url == "admin/schedule/create" ||$url == "admin/schedule/edit/{id}" || $url == "admin/schedule/update/{id}" || $url == "admin/schedule/remove/{id}" || $url == "admin/schedule/updateall")
			{
				return $next($request);
			}
			else if($url == "admin/marketshare")
			{
				return $next($request);
			}
            else if($url == "admin/dashboard" || $url = 'admin/dashboard/.*')
            {
                return $next($request);
            }
			else
			{
				return redirect('admin/logout');
			}
		}
		else if($user_id == 2)
		{
			if($url == "admin/projects")
			{
				return $next($request);
			}
			else if($url == "admin/projects/add" || $url == "admin/projects/create" || $url == "admin/projects/edit/{id}" || $url == "admin/projects/remove/{id}")
			{
				return redirect('admin/logout');
			}
			else if($url == "admin/category" || $url == "admin/category/add" || $url == "admin/category/edit/{id}" || $url == "admin/category/update/{id}" || $url == "admin/category/remove/{id}" || $url == "admin/category/viewclient/{id}")
			{
				return $next($request);
			}
			else if($url == "admin/manufacturer" || $url == "admin/manufacturer/add" || $url == "admin/manufacturer/create" ||$url == "admin/manufacturer/edit/{id}" || $url == "admin/manufacturer/update/{id}" || $url == "admin/manufacturer/remove/{id}")
			{
				return redirect('admin/logout');
			}
			else if($url == "admin/users" || $url == "admin/users/add" || $url == "admin/users/edit/{id}" || $url == "admin/users/updateall" || $url == "admin/users/update/{id}" || $url == "admin/users/remove/{id}")
			{
				return $next($request);
			}
			else if($url == "admin/devices" || $url == "admin/devices/add" || $url == "admin/devices/create" || $url == "admin/devices/edit/{id}" || $url == "admin/devices/update/{id}" || $url == "admin/devices/remove/{id}" || $url == "admin/devices/view/{id}" ||$url == "admin/devices/clientprice/{id}" || $url == "admin/devices/clientpricecreate" || $url == "admin/devices/clientpriceedit/{id}" || $url == "admin/devices/clientpriceremove/{id}" || $url == "admin/devices/clientpriceupdate/{id}" || $url =  "admin/devices/customfield/remove/{id}" || $url == "admin/getcategory")
			{
				return $next($request);
			}
			else if($url == "admin/orders" || $url == "admin/orders/updateall" ||$url == "admin/orders/edit/{id}" || $url == "admin/orders/update/{id}" || $url == "admin/orders/remove/{id}" || $url == "admin/orders/archive" || $url == "admin/orders/viewarchive")
			{
				return $next($request);
			}
			else if($url == "admin/schedule" || $url == "admin/getclientname" || $url == "admin/getdevicename" || $url == "admin/schedule/add" || $url == "admin/schedule/create" ||$url == "admin/schedule/edit/{id}" || $url == "admin/schedule/update/{id}" || $url == "admin/schedule/remove/{id}" || $url == "admin/schedule/updateall")
			{
				return $next($request);
			}
			else if($url == "admin/marketshare")
			{
				return $next($request);
			}
			
			else
			{
				return redirect('admin/logout');
			}
		}
		else if($user_id == 3)
		{
			Session::flash('message', 'Invalid Credentials'); 
			Auth::logout();
			return redirect('admin');
		}
		else if($user_id == 4)
		{
			if($url == "admin/orders" || $url == "admin/orders/updateall" ||$url == "admin/orders/edit/{id}" || $url == "admin/orders/update/{id}" || $url == "admin/orders/remove/{id}" || $url == "admin/orders/archive" || $url == "admin/orders/viewarchive")
			{
				return $next($request);
			}
			else
			{
				return redirect('admin/logout');
			}
		}
		else if($user_id == 5)
		{
			if($url == "admin/marketshare")
			{
				return $next($request);
			}
			else
			{
				return redirect('admin/logout');
			}
		}
		
		return $next($request);
		
    }
}
