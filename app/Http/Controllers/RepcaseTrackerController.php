<?php

namespace App\Http\Controllers;

use App\category;
use App\clients;
use App\client_price;
use App\device;
use App\DeviceRequest;
use App\ItemfileDetails;
use App\ItemFileEntry;
use App\ItemFileMain;
use App\Itemfiles;
use App\project;
use App\roll;
use App\SerialnumberDetail;
use App\Serialnumber;
use App\User;
use App\userClients;
use Auth;
use Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Mail;

class RepcaseTrackerController extends Controller {

    public function index(Request $request) {
        $pagesize = $request->get('pagesize');

        if ($pagesize == "") {
            $pagesize = 10;
        }

        $sortby = $request->get('sortvalue');

        $getmanufacture = $request->get('manufacture');

        $getcategory = $request->get('category');

        $getpurchase = $request->get('purchase');

        $userid = Auth::user()->id;
        //$organization = user::where('id', '=', $userid)->value('organization');

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');

        }

        if (count($organization) > 0) {
            $manufacture = ['' => "All Manufactures"] + ItemfileDetails::whereIn('clientId', $organization)->distinct()->pluck('company', 'company')->all();

            $category = ['' => "All Category"] + ItemfileDetails::whereIn('clientId', $organization)->distinct()->pluck('category', 'category')->all();
            if ($getmanufacture != '') {
                $category = ['' => "All Category"] + ItemfileDetails::whereIn('clientId', $organization)->where('company', $getmanufacture)->distinct()->pluck('category', 'category')->all();
            }

        } else {

            $manufacture = ['' => "All Manufactures"] + ItemfileDetails::distinct()->pluck('company', 'company')->all();

            $category = ['' => "All Category"] + ItemfileDetails::distinct()->pluck('category', 'category')->all();
            if ($getmanufacture != '') {
                $category = ['' => "All Category"] + ItemfileDetails::where('company', $getmanufacture)->distinct()->pluck('category', 'category')->all();
            }

        }

        if (Auth::user()->roll == 2 || Auth::user()->roll == 1 && count($organization) > 0) {

            if ($sortby == '1') {
                $itemdetails = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
                    ->whereIn('item_file_main.clientId', $organization);
                if ($getmanufacture != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.manufacturer', $getmanufacture);
                }
                if ($getcategory != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.category', $getcategory);
                }
                if ($getpurchase != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.purchaseType', $getpurchase);
                }
                $itemdetails = $itemdetails->distinct('item_file_entry.itemMainId')
                    ->orderBy('item_file_main.produceDate', 'desc')
                    ->orderBy('item_file_entry.itemMainId', 'desc')
//                    ->orderBy('item_file_entry.supplyItem', 'desc')
                    ->orderBy('item_file_entry.swapDate', 'ASC')
                    ->orderBy('item_file_entry.id', 'desc')
                    ->paginate($pagesize);

                $count = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
                    ->whereIn('item_file_main.clientId', $organization);
                if ($getmanufacture != '') {
                    $count = $count->where('item_file_entry.manufacturer', $getmanufacture);
                }
                if ($getcategory != '') {
                    $count = $count->where('item_file_entry.category', $getcategory);
                }
                if ($getpurchase != '') {
                    $count = $count->where('item_file_entry.purchaseType', $getpurchase);
                }
                $count->distinct('item_file_entry.itemMainId')
                    ->count();

            } else if ($sortby == '2') {
                $itemdetails = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
                    ->whereIn('item_file_main.clientId', $organization);
                if ($getmanufacture != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.manufacturer', $getmanufacture);
                }
                if ($getcategory != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.category', $getcategory);
                }
                if ($getpurchase != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.purchaseType', $getpurchase);
                }
                $itemdetails = $itemdetails->distinct('item_file_entry.itemMainId')
                    ->orderBy('item_file_main.physician', 'desc')
                    ->orderBy('item_file_entry.itemMainId', 'desc')
//                    ->orderBy('item_file_entry.supplyItem', 'desc')
                    ->orderBy('item_file_entry.swapDate', 'ASC')
                    ->orderBy('item_file_entry.id', 'desc')
                    ->paginate($pagesize);

                $count = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
                    ->whereIn('item_file_main.clientId', $organization);
                if ($getmanufacture != '') {
                    $count = $count->where('item_file_entry.manufacturer', $getmanufacture);
                }
                if ($getcategory != '') {
                    $count = $count->where('item_file_entry.category', $getcategory);
                }
                if ($getpurchase != '') {
                    $count = $count->where('item_file_entry.purchaseType', $getpurchase);
                }
                $count = $count->distinct('item_file_entry.itemMainId')
                    ->count();
            } else if ($sortby == '3') {
                $itemdetails = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
                    ->whereIn('item_file_main.clientId', $organization);
                if ($getmanufacture != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.manufacturer', $getmanufacture);
                }
                if ($getcategory != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.category', $getcategory);
                }
                if ($getpurchase != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.purchaseType', $getpurchase);
                }
                $itemdetails = $itemdetails->distinct('item_file_entry.itemMainId')
                    ->orderBy('item_file_main.clientId', 'desc')
                    ->orderBy('item_file_entry.itemMainId', 'desc')
//                    ->orderBy('item_file_entry.supplyItem', 'desc')
                    ->orderBy('item_file_entry.swapDate', 'ASC')
                    ->orderBy('item_file_entry.id', 'desc')
                    ->paginate($pagesize);

                $count = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
                    ->whereIn('item_file_main.clientId', $organization);
                if ($getmanufacture != '') {
                    $count = $count->where('item_file_entry.manufacturer', $getmanufacture);
                }
                if ($getcategory != '') {
                    $count = $count->where('item_file_entry.category', $getcategory);
                }
                if ($getpurchase != '') {
                    $count = $count->where('item_file_entry.purchaseType', $getpurchase);
                }
                $count = $count->distinct('item_file_entry.itemMainId')
                    ->count();
            } else {

                $itemdetails = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
                    ->whereIn('item_file_main.clientId', $organization);
                if ($getmanufacture != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.manufacturer', $getmanufacture);
                }
                if ($getcategory != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.category', $getcategory);
                }
                if ($getpurchase != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.purchaseType', $getpurchase);
                }
                $itemdetails = $itemdetails->distinct('item_file_entry.itemMainId')
                    ->orderBy('item_file_entry.itemMainId', 'desc')
//                    ->orderBy('item_file_entry.supplyItem', 'desc')
                    ->orderBy('item_file_entry.swapDate', 'ASC')
                    ->orderBy('item_file_entry.id', 'desc')
                    ->paginate($pagesize);

                $count = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
                    ->whereIn('item_file_main.clientId', $organization);
                if ($getmanufacture != '') {
                    $count = $count->where('item_file_entry.manufacturer', $getmanufacture);
                }
                if ($getcategory != '') {
                    $count = $count->where('item_file_entry.category', $getcategory);
                }
                if ($getpurchase != '') {
                    $count = $count->where('item_file_entry.purchaseType', $getpurchase);
                }
                $count = $count->distinct('item_file_entry.itemMainId')
                    ->count();

            }

        } else if (Auth::user()->roll == 5) {

            if ($sortby == '1') {

                $itemdetails = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
                    ->leftjoin('user_clients', 'user_clients.clientId', '=', 'item_file_main.clientId')
                    ->where('user_clients.userId', Auth::user()->id)
                    ->where('item_file_main.repUser', Auth::user()->id);
                if ($getmanufacture != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.manufacturer', $getmanufacture);
                }
                if ($getcategory != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.category', $getcategory);
                }
                if ($getpurchase != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.purchaseType', $getpurchase);
                }
                $itemdetails = $itemdetails->distinct('item_file_entry.itemMainId')
                    ->orderBy('item_file_main.produceDate', 'desc')
                    ->orderBy('item_file_entry.itemMainId', 'desc')
//                    ->orderBy('item_file_entry.supplyItem', 'desc')
                    ->orderBy('item_file_entry.swapDate', 'ASC')
                    ->orderBy('item_file_entry.id', 'desc')
                    ->paginate($pagesize);

                $count = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
                    ->leftjoin('user_clients', 'user_clients.clientId', '=', 'item_file_main.clientId')
                    ->where('user_clients.userId', Auth::user()->id)
                    ->where('item_file_main.repUser', Auth::user()->id);
                if ($getmanufacture != '') {
                    $count = $count->where('item_file_entry.manufacturer', $getmanufacture);
                }
                if ($getcategory != '') {
                    $count = $count->where('item_file_entry.category', $getcategory);
                }
                if ($getpurchase != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.purchaseType', $getpurchase);
                }
                if ($getpurchase != '') {
                    $count = $count->where('item_file_entry.purchaseType', $getpurchase);
                }
                $count = $count->distinct('item_file_entry.itemMainId', 'desc')
                    ->orderBy('item_file_main.produceDate', 'desc')
                    ->orderBy('item_file_entry.id', 'desc')
                    ->count();
            } else if ($sortby == '2') {
                $itemdetails = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
                    ->leftjoin('user_clients', 'user_clients.clientId', '=', 'item_file_main.clientId')
                    ->where('user_clients.userId', Auth::user()->id)
                    ->where('item_file_main.repUser', Auth::user()->id);
                if ($getmanufacture != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.manufacturer', $getmanufacture);
                }
                if ($getcategory != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.category', $getcategory);
                }
                if ($getpurchase != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.purchaseType', $getpurchase);
                }
                $itemdetails = $itemdetails->distinct('item_file_entry.itemMainId')
                    ->orderBy('item_file_main.physician', 'desc')
                    ->orderBy('item_file_entry.itemMainId', 'desc')
//                    ->orderBy('item_file_entry.supplyItem', 'desc')
                    ->orderBy('item_file_entry.swapDate', 'ASC')
                    ->orderBy('item_file_entry.id', 'desc')
                    ->paginate($pagesize);

                $count = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
                    ->leftjoin('user_clients', 'user_clients.clientId', '=', 'item_file_main.clientId')
                    ->where('user_clients.userId', Auth::user()->id)
                    ->where('item_file_main.repUser', Auth::user()->id);
                if ($getmanufacture != '') {
                    $count = $count->where('item_file_entry.manufacturer', $getmanufacture);
                }
                if ($getcategory != '') {
                    $count = $count->where('item_file_entry.category', $getcategory);
                }
                if ($getpurchase != '') {
                    $count = $count->where('item_file_entry.purchaseType', $getpurchase);
                }
                $count = $count->distinct('item_file_entry.itemMainId', 'desc')
                    ->orderBy('item_file_main.physician')
                    ->count();
            } elseif ($sortby == '3') {
                $itemdetails = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
                    ->leftjoin('user_clients', 'user_clients.clientId', '=', 'item_file_main.clientId')
                    ->where('user_clients.userId', Auth::user()->id)
                    ->where('item_file_main.repUser', Auth::user()->id);
                if ($getmanufacture != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.manufacturer', $getmanufacture);
                }
                if ($getcategory != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.category', $getcategory);
                }
                if ($getpurchase != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.purchaseType', $getpurchase);
                }
                $itemdetails = $itemdetails->distinct('item_file_entry.itemMainId')
                    ->orderBy('item_file_main.clientId', 'desc')
//                    ->orderBy('item_file_entry.supplyItem', 'desc')
                    ->orderBy('item_file_entry.itemMainId', 'desc')
                    ->orderBy('item_file_entry.swapDate', 'ASC')
                    ->orderBy('item_file_entry.id', 'desc')
                    ->paginate($pagesize);

                $count = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
                    ->leftjoin('user_clients', 'user_clients.clientId', '=', 'item_file_main.clientId')
                    ->where('user_clients.userId', Auth::user()->id)
                    ->where('item_file_main.repUser', Auth::user()->id);
                if ($getmanufacture != '') {
                    $count = $count->where('item_file_entry.manufacturer', $getmanufacture);
                }
                if ($getcategory != '') {
                    $count = $count->where('item_file_entry.category', $getcategory);
                }
                if ($getpurchase != '') {
                    $count = $count->where('item_file_entry.purchaseType', $getpurchase);
                }
                $count = $count->distinct('item_file_entry.itemMainId', 'desc')
                    ->orderBy('item_file_main.clientId')
                    ->orderBy('item_file_entry.id', 'desc')
                    ->count();
            } else {
                $itemdetails = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
                    ->leftjoin('user_clients', 'user_clients.clientId', '=', 'item_file_main.clientId')
                    ->where('user_clients.userId', Auth::user()->id)
                    ->where('item_file_main.repUser', Auth::user()->id);
                if ($getmanufacture != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.manufacturer', $getmanufacture);
                }
                if ($getcategory != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.category', $getcategory);
                }
                if ($getpurchase != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.purchaseType', $getpurchase);
                }
                $itemdetails = $itemdetails->distinct('item_file_entry.itemMainId')
                    ->orderBy('item_file_entry.itemMainId', 'desc')
//                    ->orderBy('item_file_entry.supplyItem', 'desc')
                    ->orderBy('item_file_entry.swapDate', 'ASC')
                    ->orderBy('item_file_entry.id', 'desc')
                    ->paginate($pagesize);

                $count = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
                    ->leftjoin('user_clients', 'user_clients.clientId', '=', 'item_file_main.clientId')
                    ->where('user_clients.userId', Auth::user()->id)
                    ->where('item_file_main.repUser', Auth::user()->id);
                if ($getmanufacture != '') {
                    $count = $count->where('item_file_entry.manufacturer', $getmanufacture);
                }
                if ($getcategory != '') {
                    $count = $count->where('item_file_entry.category', $getcategory);
                }
                if ($getpurchase != '') {
                    $count = $count->where('item_file_entry.purchaseType', $getpurchase);
                }
                $count = $count->distinct('item_file_entry.itemMainId', 'desc')
                    ->orderBy('item_file_entry.itemMainId')->count();
            }

        } else if (Auth::user()->roll == 1 && count($organization) <= 0) {
            if ($sortby == "1") {
                $itemdetails = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId');
                if ($getmanufacture != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.manufacturer', $getmanufacture);
                }
                if ($getcategory != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.category', $getcategory);
                }
                if ($getpurchase != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.purchaseType', $getpurchase);
                }
                $itemdetails = $itemdetails->distinct('item_file_entry.itemMainId')
                    ->orderBy('item_file_main.produceDate', 'desc')
                    ->orderBy('item_file_entry.itemMainId', 'desc')
//                    ->orderBy('item_file_entry.supplyItem', 'desc')
                    ->orderBy('item_file_entry.swapDate', 'ASC')
                    ->orderBy('item_file_entry.id', 'desc')
                    ->paginate($pagesize);

                $count = ItemFileEntry::distinct('itemMainId');

                if ($getmanufacture != '') {
                    $count = $count->where('manufacturer', $getmanufacture);
                }
                if ($getcategory != '') {
                    $count = $count->where('category', $getcategory);
                }
                if ($getpurchase != '') {
                    $count = $count->where('purchaseType', $getpurchase);
                }
                $count = $count->count();

            } else if ($sortby == "2") {
                $itemdetails = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId');
                if ($getmanufacture != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.manufacturer', $getmanufacture);
                }
                if ($getcategory != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.category', $getcategory);
                }
                if ($getpurchase != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.purchaseType', $getpurchase);
                }
                $itemdetails = $itemdetails->distinct('item_file_entry.itemMainId')->orderBy('item_file_main.physician', 'desc')
                    ->orderBy('item_file_entry.itemMainId', 'desc')
                    ->orderBy('item_file_entry.swapDate', 'ASC')
//                    ->orderBy('item_file_entry.supplyItem', 'desc')
                    ->orderBy('item_file_entry.id', 'desc')
                    ->paginate($pagesize);

                $count = ItemFileEntry::distinct('itemMainId');

                if ($getmanufacture != '') {
                    $count = $count->where('manufacturer', $getmanufacture);
                }
                if ($getcategory != '') {
                    $count = $count->where('category', $getcategory);
                }
                if ($getpurchase != '') {
                    $count = $count->where('purchaseType', $getpurchase);
                }
                $count = $count->count();

            } else if ($sortby == "3") {
                $itemdetails = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId');
                if ($getmanufacture != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.manufacturer', $getmanufacture);
                }
                if ($getcategory != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.category', $getcategory);
                }
                if ($getpurchase != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.purchaseType', $getpurchase);
                }
                $itemdetails = $itemdetails->distinct('item_file_entry.itemMainId')
                    ->orderBy('item_file_main.clientId', 'desc')
                    ->orderBy('item_file_entry.itemMainId', 'desc')
//                    ->orderBy('item_file_entry.supplyItem', 'desc')
                    ->orderBy('item_file_entry.swapDate', 'ASC')
                    ->orderBy('item_file_entry.id', 'desc')
                    ->paginate($pagesize);

                $count = ItemFileEntry::distinct('itemMainId');

                if ($getmanufacture != '') {
                    $count = $count->where('manufacturer', $getmanufacture);
                }
                if ($getcategory != '') {
                    $count = $count->where('category', $getcategory);
                }
                if ($getpurchase != '') {
                    $count = $count->where('purchaseType', $getpurchase);
                }
                $count = $count->count();

            } else {

                $itemdetails = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId');

                if ($getmanufacture != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.manufacturer', $getmanufacture);
                }

                if ($getcategory != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.category', $getcategory);
                }
                if ($getpurchase != '') {
                    $itemdetails = $itemdetails->where('item_file_entry.purchaseType', $getpurchase);
                }
                $itemdetails = $itemdetails->distinct('item_file_entry.itemMainId')
                    ->orderBy('item_file_entry.itemMainId', 'desc')
//                    ->orderBy('item_file_entry.supplyItem', 'ASC')
                    ->orderBy('item_file_entry.swapDate', 'ASC')
                    ->orderBy('item_file_entry.id', 'desc')
                    ->paginate($pagesize);

                $count = ItemFileEntry::distinct('itemMainId');

                if ($getmanufacture != '') {
                    $count = $count->where('manufacturer', $getmanufacture);
                }
                if ($getcategory != '') {
                    $count = $count->where('category', $getcategory);
                }
                if ($getpurchase != '') {
                    $count = $count->where('purchaseType', $getpurchase);
                }
                $count = $count->count();

            }
        }

        return view('pages.repcasetracker.repcase', compact('itemdetails', 'count', 'pagesize', 'sortby', 'category', 'manufacture', 'getmanufacture', 'getcategory', 'getpurchase'));

    }

    public function create(Request $request) {

        $clientId = Itemfiles::get();

        $cid = array();
        foreach ($clientId as $row) {
            $cid[] = $row->clientId;
        }

        $userid = Auth::user()->id;
        //$organization = user::where('id', '=', $userid)->value('organization');

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');

        }

        if (Auth::user()->roll == 2 || Auth::user()->roll == 1 && count($organization) > 0) {

            $clients = [NULL => 'Select Hospital'] + clients::orderBy('id', 'asc')
                    ->whereIn('id', $organization)
                    ->whereIn('id', $cid)
                    ->where('is_active', '1')
                    ->pluck('client_name', 'id')
                    ->all();

        } else if (Auth::user()->roll == 5) {

            $clients = [NULL => 'Select Hospital'] + clients::leftjoin('user_clients', 'user_clients.clientId', '=', 'clients.id')
                    ->where('user_clients.userId', Auth::user()->id)
                    ->whereIn('clients.id', $cid)
                    ->orderBy('clients.id', 'asc')
                    ->where('clients.is_active', '1')
                    ->pluck('clients.client_name', 'clients.id')
                    ->all();
        } else if (Auth::user()->roll == 1 && count($organization) <= 0) {

            $clients = [NULL => 'Select Hospital'] + clients::orderBy('id', 'asc')
                    ->whereIn('id', $cid)
                    ->where('is_active', '1')
                    ->pluck('client_name', 'id')
                    ->all();
        }

        // dd($clients);
        $physician = [NULL => 'Select Physician'];

        $project = [NULL => 'Select Project'];

        $category = [NULL => 'Select Category'];

        $company = [NULL => 'Select Company'];

        $repuser = [NULL => 'Select Rep User'];

        $phyEmail = [NULL => 'Select Physician Email'];

        return view('pages.repcasetracker.add', compact('clients', 'physician', 'category', 'company', 'project', 'repuser', 'phyEmail'));
    }

    /*Get Rep User Name Start*/
    public function getrepuser(Request $request) {
        $clientId = $request->get('hospital');

        if (Auth::user()->roll == 1) {
            $username = userClients::leftjoin('users', 'users.id', '=', 'user_clients.userId')->where('users.roll', 5)->where('user_clients.clientId', $clientId)->select('users.id', 'users.name')->get();

        } else if (Auth::user()->roll == 5) {
            $username = userClients::leftjoin('users', 'users.id', '=', 'user_clients.userId')->where('users.id', Auth::user()->id)->where('users.roll', 5)->where('user_clients.clientId', $clientId)->select('users.id', 'users.name')->get();
        }
        $data = $username;

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
    /*Get Rep User Name End*/
    /*Get Project Name Start*/
    public function getproject(Request $request) {
//        dd(Auth::user()->id);
        $clientId = $request->get('hospital');

        if (Auth::user()->roll == 1 || Auth::user()->roll == 2) {

            $data = project::leftjoin('item_files', 'item_files.projectId', '=', 'projects.id')
                ->leftjoin('user_projects', 'user_projects.projectId', '=', 'projects.id')
                ->select('projects.*', 'item_files.projectId', 'item_files.clientId')
                ->where('item_files.clientId', $clientId)
//                ->where('user_projects.userId', $user)
                ->groupBy('project_name')
                ->get();

        } else if (Auth::user()->roll == 5) {

            $data = project::leftjoin('item_files', 'item_files.projectId', '=', 'projects.id')
                ->leftjoin('user_projects', 'user_projects.projectId', '=', 'projects.id')
                ->select('projects.*', 'item_files.projectId', 'item_files.clientId')
                ->where('item_files.clientId', $clientId)
                ->where('user_projects.userId', Auth::user()->id)
                ->get();
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

    public function getprojects(Request $request) {

        $clientId = $request->get('hospital');

        if (Auth::user()->roll == 1 || Auth::user()->roll == 2) {

            $data = project::leftjoin('item_files', 'item_files.projectId', '=', 'projects.id')
                ->leftjoin('user_projects', 'user_projects.projectId', '=', 'projects.id')
                ->select('projects.*', 'item_files.projectId', 'item_files.clientId')
                ->where('item_files.clientId', $clientId)
//                ->where('user_projects.userId', $user)
                ->groupBy('project_name')
                ->get();

        } else if (Auth::user()->roll == 5) {

            $data = project::leftjoin('item_files', 'item_files.projectId', '=', 'projects.id')
                ->leftjoin('user_projects', 'user_projects.projectId', '=', 'projects.id')
                ->select('projects.*', 'item_files.projectId', 'item_files.clientId')
                ->where('item_files.clientId', $clientId)
                ->where('user_projects.userId', Auth::user()->id)
                ->get();
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
    /*Get Project Name End*/

    /*Get Physician name Start*/
    public function getphysician(Request $request) {

        $clientId = $request->get('hospital');
        $projectId = $request->get('project');

        $data = ItemfileDetails::orderBy('id', 'asc')->where('clientId', $clientId)->where('projectId', $projectId)->where('doctors', '!=', NULL)
            // ->groupBy('doctors')
            ->select('doctors', 'doctors')->get();

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

    /*Get Physician name End*/
    /*Get Category name Start*/
    public function getcategory(Request $request) {
        $clientId = $request->get('hospital');
        $projectId = $request->get('project');

        // dd($request->all());
        $data = ItemfileDetails::orderBy('id', 'asc')->where('clientId', $clientId)
            ->where('projectId', $projectId)
            ->groupBy('category')->select('category', 'category')->get();

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

    /*Get Category name End*/
    /*Get Comapny name Start*/
    public function getcompany(Request $request) {
        $clientId = $request->get('hospital');
        $projectId = $request->get('project');
        $category = $request->get('category');

        // $company = ItemfileDetails =

        $data = ItemfileDetails::orderBy('id', 'asc')->where('clientId', $clientId)
            ->where('projectId', $projectId)
            ->where('category', $category)->groupBy('company')->select('company', 'company')->get();

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

    public function getcompanies(Request $request) {

        $clientId = $request->get('hospital');
        $projectId = $request->get('project');
        $category = $request->get('category');
        $manufacturer = $request->get('manufacturer');
        $dataid = $request->get('dataid');
        $data1 = array();

        for ($i = 0; $i < count($category); $i++) {

            $data = ItemfileDetails::orderBy('id', 'asc')->where('clientId', $clientId)
                ->where('projectId', $projectId)
                ->where('category', $category[$i])->groupBy('company')->select('company', 'company')->get();
            $data1[] = array('data' => $data, 'manufacturer' => $manufacturer[$i], 'dataid' => $dataid[$i]);
        }

        if (count($data)) {
            return [
                'value' => $data1,
                'status' => TRUE,
            ];
        } else {
            return [
                'value' => 'No result Found',
                'status' => FALSE,
            ];
        }

    }

    /*Get Company name End*/

    /*Get Supply Item Start*/

    public function getsupplyitem(Request $request) {

        $clientId = $request->get('hospital');
        $projectId = $request->get('project');
        $category = $request->get('category');
        $manufacturer = $request->get('manufacturer');
//        $selectsupplyitem = $request->get('selectsupplyitem');
        // dd($selectsupplyitem);
        // $selectsupplyitem = $selectsupplyitem == NULL ? array() : $selectsupplyitem;

        $data = ItemfileDetails::orderBy('id', 'asc')->where('clientId', $clientId)
            ->where('projectId', $projectId)
            ->where('category', $category)->where('company', $manufacturer)->select('supplyItem', 'id')
            // ->whereNotIn('supplyItem',$selectsupplyitem)
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

    /*Get Supply Item End*/
    public function getsupplyitems(Request $request) {

        $clientId = $request->get('hospital');
        $projectId = $request->get('project');
        $category = $request->get('category');
        $manufacturer = $request->get('manufacturer');
        $supply = $request->get('supplyitem');
        $dataid = $request->get('dataid');
        $data1 = array();

        for ($i = 0; $i < count($category); $i++) {
            $data = ItemfileDetails::orderBy('id', 'asc')->where('clientId', $clientId)
                ->where('projectId', $projectId)
                ->where('category', $category[$i])->where('company', $manufacturer[$i])->select('supplyItem', 'id')
                // ->whereNotIn('supplyItem',$selectsupplyitem)
                ->get();

            $data1[] = array('data' => $data, 'supply' => $supply[$i], 'dataid' => $dataid[$i]);
        }

        if (count($data)) {
            return [
                'value' => $data1,
                'status' => TRUE,
            ];
        } else {
            return [
                'value' => 'No result Found',
                'status' => FALSE,
            ];
        }

    }

    /*Get Item File Start*/
    public function getitemfile(Request $request) {

        $supplyItem = $request->get('supplyItem');
        $client = $request->get('hospital');
        $project = $request->get('project');
        $data = ItemfileDetails::where('supplyItem', $supplyItem)->where('clientId', $client)->where('projectId', $project)->first();

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
    /*Get Item File End*/

    /*Check Device Validation start*/
    public function getdevicedata(Request $request) {

        $supplyItem = $request->get('supplyItem');
        $client = $request->get('client');
        $mfgPartNumber = $request->get('mfgPartNumber');

        $device = device::where('model_name', $mfgPartNumber)
//            ->where('device_name', $supplyItem)
            ->first();

        $checktrue = 'False';
        $checkSerialdevice = array();
        if (!empty($device)) {

            $checkdata = client_price::where('device_id', $device['id'])->where('client_name', $client)
                ->where('unit_cost_check', 'True')->first();

            $checkdatas = client_price::where('device_id', $device['id'])->where('client_name', $client)
                ->where('system_cost_check', 'True')->first();

            $checkSerialdevice = SerialnumberDetail::where('deviceId', $device['id'])->where('clientId', $client)->get();

            $serialNumber = array();
            
            if (count($checkSerialdevice) > 0) {
                $check = array();
                $checkserial = ItemFileEntry::get();

                foreach ($checkserial as $row) {
                    $check[] = $row->serialNumber;
                }

                $serialNumber = SerialnumberDetail::where('clientId', $client)
                    ->where('deviceId', $device['id'])
                    ->whereNotIn('serialNumber', $check)
                    ->get();
            }

            if (count($serialNumber) > 0) {
                if (!empty($checkdata) || !empty($checkdatas)) {
                    $checktrue = 'True';
                }
            }

        }

        $data = $checktrue;

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

    public function getdevicedatas(Request $request) {

        $purchase = $request->get('purchase');
        $clientId = $request->get('hospital');
        $mfgPartNumber = $request->get('manufacturepart');
        $supplyItem = $request->get('supplyitem');
        $dataid = $request->get('dataid');
        $data1 = array();

        for ($i = 0; $i < count($supplyItem); $i++) {

            $device = device::where('model_name', $mfgPartNumber[$i])
//                ->where('device_name', $supplyItem[$i])
                ->first();

            $checktrue = 'False';
            if (!empty($device)) {
                $checkdata = client_price::where('device_id', $device['id'])->where('client_name', $clientId)
                    ->where('unit_cost_check', 'True')->first();

                $checkdatas = client_price::where('device_id', $device['id'])->where('client_name', $clientId)
                    ->where('system_cost_check', 'True')->first();

                $checkSerialdevice = SerialnumberDetail::where('deviceId', $device['id'])->where('clientId', $clientId)->get();

                $serialNumber = array();

                if (count($checkSerialdevice) > 0) {
                    $check = array();
                    $checkserial = ItemFileEntry::get();

                    foreach ($checkserial as $row) {
                        $check[] = $row->serialNumber;
                    }

                    $serialNumber = SerialnumberDetail::where('clientId', $clientId)
                        ->where('deviceId', $device['id'])
                        ->whereNotIn('serialNumber', $check)
                        ->get();
                }
                if (count($serialNumber) > 0) {
                    if (!empty($checkdata) || !empty($checkdatas)) {
                        $checktrue = 'True';
                    }
                }

            }

            $data1[] = array('data' => $checktrue, 'purchase' => $purchase[$i], 'dataid' => $dataid[$i]);
        }

        if (count($data1)) {
            return [
                'value' => $data1,
                'status' => TRUE,
            ];
        } else {
            return [
                'value' => 'No result Found',
                'status' => FALSE,
            ];
        }

    }
    /*Check Device Validation end*/

    /*Store Item file Data in item file main start*/
    public function store(Request $request) {
//     dd(request()->all());
        $rules = array(
            'procedure_date' => 'required',
            'hospital' => 'required',
//            'repUser' => 'required',
            'physician' => 'required',
            'phyEmail' => 'required',
            'category' => 'required',
            'manufacturer' => 'required',
            'supplyItem' => 'required',
            'hospitalPart' => 'required',
            'mfgPartNumber' => 'required',
            'purchaseType' => 'required',
            'serialNumber' => 'required',
            'poNumber' => 'required',
            'isImplanted' => 'required',
//            'type' => 'required',

        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $checkserialNumber = $request->get('serialNumber');
        $checksupplyItem = $request->get('supplyItem');

        for ($i = 0; $i < count($checksupplyItem); $i++) {

            $getdevice = ItemFileEntry::where('serialNumber', $checkserialNumber[$i])->where('swapType', 'Swap In')->value('serialNumber');

            if (!empty($getdevice)) {

                return redirect()->back()
                    ->withErrors(['serialNumber' => 'please Enter Valid serial Number..!!']);
            }
        }
        $date = date_create_from_format('m-d-Y', $request->get('procedure_date'));
        $pdate = $date->format('Y-m-d');

        $last = ItemFileMain::orderBy('id', 'DESC')->value('repcaseID');

        $data['repcaseID'] = $last + 1;
        $data['produceDate'] = $pdate;
        $data['physician'] = $request->get('physician');
        $data['projectId'] = $request->get('project');
        $data['clientId'] = $request->get('hospital');
        $data['repUser'] = Auth::user()->id;
        $data['phyEmail'] = $request->get('phyEmail');

//        $orderstatus = array();
        //
        //        $order = $request->get('order');
        //
        //        for ($i = 0; $i < count($order); $i++) {
        //            $orderstatus[] = order::where('id', $order[$i])->value('status');
        //        }

        $item_file = new ItemFileMain;
        $item_file->fill($data);
        if ($item_file->save()) {
            $itemMainId = $item_file->id;
            $supplyItem = $request->get('supplyItem');
            $hospitalPart = $request->get('hospitalPart');
            $mfgPartNumber = $request->get('mfgPartNumber');
            $quantity = '1';
            $purchaseType = $request->get('purchaseType');
            $serialNumber = $request->get('serialNumber');
            $poNumber = $request->get('poNumber');
            $status = $request->get('status');
//            $order = $request->get('order');
            $isImplanted = $request->get('isImplanted');
//            $type = $request->get('type');
            $unusedReason = $request->get('unusedReason');
//            $orderstatus = $orderstatus;
            $category = $request->get('category');
            $manufacturer = $request->get('manufacturer');
            $swap = $request->get('swap');
            $dataid = $request->get('dataid');
            $cco_check = $request->get('cco_check');
            $repless_check = $request->get('repless_check');
            $datasId = '';
            $serialNumbers = '';
            $bulks = '';
            $swaps = '';

            for ($i = 0; $i < count($supplyItem); $i++) {
                if ($supplyItem[$i] != "") {

                    $insertrecord = array(
                        "repcaseID" => $item_file->repcaseID,
                        "supplyItem" => $supplyItem[$i],
                        "hospitalPart" => $hospitalPart[$i],
                        "mfgPartNumber" => $mfgPartNumber[$i],
                        "quantity" => $quantity,
                        "purchaseType" => $purchaseType[$i],
                        "serialNumber" => $serialNumber[$i],
                        "poNumber" => $poNumber[$i],
                        "status" => $status[$i],
                        "itemMainId" => $itemMainId,
//                        "orderId" => $order[$i],
                        //                        "oldOrderStatus" => $orderstatus[$i],
                        "category" => $category[$i],
                        "manufacturer" => $manufacturer[$i],
                        "projectId" => $item_file->projectId,
                        "created_at" => Carbon\Carbon::now(),
                        "updated_at" => Carbon\Carbon::now(),
                        "swapType" => $swap[$i],
                        "dataId" => $dataid[$i],
                        "isImplanted" => $isImplanted[$i],
//                        "type" => $type[$i],
                        "unusedReason" => $unusedReason[$i],
                        "cco_check" => $cco_check[$i],
                        "repless_check" => $repless_check[$i],

                    );

                    if ($purchaseType[$i] == "Consignment") {

                        $getdeviceId = device::where('model_name', $mfgPartNumber[$i])->value('id');

                        if (!empty($getdeviceId)) {

                            $checkserial = Serialnumber::where('clientId',$request->get('hospital'))
                                ->where('deviceId',$getdeviceId)->first();

                            if(empty($checkserial)){
                                $addnewdata['serialFile'] = 'serial_number.xlsx';
                                $addnewdata['clientId'] =$request->get('hospital');
                                $addnewdata['deviceId'] = $getdeviceId;

                                $serial_details = new Serialnumber();
                                $serial_details->fill($addnewdata);
                                $serial_details->save();

                            }
                            $addserial['serialNumber'] = $serialNumber[$i];
                            $addserial['clientId'] = $request->get('hospital');
                            $addserial['deviceId'] = $getdeviceId;
                            $addserial['purchaseType'] = "Consignment";

                            $serialdevice = new SerialnumberDetail();
                            $serialdevice->fill($addserial);
                            $serialdevice->save();
                        }

                    }

                    $upstatus['swapType'] = $swap[$i];
                    if ($purchaseType[$i] == "Bulk") {
                        $upstatus['status'] = "Used In Bulk";
                    } else {
                        $upstatus['status'] = "Used In Consignment";
                    }

                    $serial = SerialnumberDetail::where('serialNumber', $serialNumber[$i])->first();
                    if ($serial) {
                        $serialupdate = SerialnumberDetail::where('serialNumber', $serialNumber[$i])->update($upstatus);
                    }

                    $getswapedid = ItemFileEntry::where('serialNumber', $serialNumbers)->where('itemMainId', $itemMainId)->first();

                    if ($datasId == $dataid[$i] && $swaps == 'Swap Out') {

                        $sd['swapDate'] = Carbon\Carbon::now()->format('Y-m-d');
                        $sd['swappedId'] = $getswapedid['id'] + 1;
                        $insertrecord['newSwapDate'] = Carbon\Carbon::now()->format('Y-m-d');
                        $upswapedid = ItemFileEntry::where('serialNumber', $serialNumbers)->where('itemMainId', $itemMainId)->update($sd);

                    }

                    if ($datasId == $dataid[$i] && $swaps == 'Swap In') {

                        $insertrecord['swapDate'] = Carbon\Carbon::now()->format('Y-m-d');
                        $insertrecord['swappedId'] = $getswapedid['id'];

                        $sd['newSwapDate'] = Carbon\Carbon::now()->format('Y-m-d');

                        $upswapedid = ItemFileEntry::where('serialNumber', $serialNumbers)->where('itemMainId', $itemMainId)->update($sd);

                    }

                    if ($datasId == $dataid[$i] && $bulks == 'Bulk' && $swaps == 'Swap Out') {

                        $getserialdiscont = SerialnumberDetail::where('serialNumber', $serialNumbers)->first();

                        if (!empty($getserialdiscont)) {

                            $updatediscount = SerialnumberDetail::where('serialNumber', $serialNumber[$i])->update(['discount' => $getserialdiscont['discount'], 'purchaseType' => 'Bulk', 'status' => 'Used In Bulk', 'ischanged' => 'Yes', 'serialId' => $getserialdiscont['serialId']]);

                            $updatestatus = ItemFileEntry::where('serialNumber', $serialNumbers)->where('itemMainId', $itemMainId)->update(['purchaseType' => 'Consignment']);

                            $insertrecord['purchaseType'] = "Bulk";

                            $upserialold = SerialnumberDetail::where('serialNumber', $serialNumbers)->update(['purchaseType' => 'Consignment', 'discount' => '', 'status' => 'Used In Consignment']);

                        }

                    }

                    if ($datasId == $dataid[$i] && $bulks == 'Consignment' && $swaps == 'Swap In') {

                        $getserialdiscont = SerialnumberDetail::where('serialNumber', $serialNumber[$i])->first();

                        if (!empty($getserialdiscont)) {

                            $updatediscount = SerialnumberDetail::where('serialNumber', $serialNumbers)->update(['discount' => $getserialdiscont['discount'], 'purchaseType' => 'Bulk', 'status' => 'Used In Bulk', 'ischanged' => 'Yes', 'serialId' => $getserialdiscont['serialId'], 'purchaseDate' => $getserialdiscont['purchaseDate'], 'expiryDate' => $getserialdiscont['expiryDate']]);

                            $updatestatus = ItemFileEntry::where('serialNumber', $serialNumber[$i])->where('itemMainId', $itemMainId)->update(['purchaseType' => 'Consignment']);

                            $insertrecord['purchaseType'] = "Bulk";

                            $upserialold = SerialnumberDetail::where('serialNumber', $serialNumber[$i])->update(['purchaseType' => 'Consignment', 'discount' => '', 'status' => 'Used In Consignment']);

                        }

                    }

                    if ($purchaseType[$i] == 'Bulk' && $swap[$i] == 'Swap In') {
                        $insertrecord['scenario'] = "2";
                    }

                    /*Bulk Count Start*/

                    $device = device::where('model_name', $mfgPartNumber[$i])
//                        ->where('device_name', $supplyItem[$i])
                        ->first();
                    if (!empty($device)) {
                        $count = SerialnumberDetail::where('clientId', $item_file->clientId)->where('deviceId', $device->id)->where('status', '=', '')->count();

                        $flag1 = false;
                        $flag2 = false;
                        $unitbluk = client_price::where('client_name', $item_file->clientId)->where('device_id', $device->id)->where('bulk_check', 'True')->value('bulk');
                        $systembluk = client_price::where('client_name', $item_file->clientId)->where('device_id', $device->id)->where('system_bulk_check', 'True')->value('system_bulk');

                        if (!empty($unitbluk)) {
                            $flag1 = true;
                        }

                        if (!empty($systembluk)) {
                            $flag2 = true;
                        }
                        if ($flag1 == true) {
                            $bulk['bulk'] = $count;
                            $bulkupdate = client_price::where('client_name', $item_file->clientId)->where('device_id', $device->id)->update($bulk);
                        }

                        if ($flag2 == true) {
                            $systembulk['system_bulk'] = $count;
                            $bulkupdate = client_price::where('client_name', $item_file->clientId)->where('device_id', $device->id)->update($systembulk);
                        }
                    }

                    /*Bulk Count end*/

                    $insert_custom_field = ItemFileEntry::insert($insertrecord);

                    $datasId = $dataid[$i];
                    $serialNumbers = $serialNumber[$i];
                    $bulks = $purchaseType[$i];
                    $swaps = $swap[$i];

                }
            }

//            $update['status'] = 'Complete';
            //
            //            $update_custom_field = order::whereIN('id', $order)->update($update);

            return Redirect::to('admin/repcasetracker');
        }

    }

    /*Store Item file Data in item file main end*/

    /*Edit Item File Data in item file main start*/
    public function edit(Request $request, $id) {
        $itemdetails = ItemFileEntry::where('itemMainId', $id)->orderBy('id', 'ASC')->get();
        $dataid = array();
        foreach ($itemdetails as $item) {
            if (empty($item->swapDate)) {

                $dataid[] = $item->id;
            }
        }
//dd($itemdetails);
        $itemMain = ItemFileMain::where('id', $id)->first();

        $clientId = Itemfiles::get();

        $cid = array();
        foreach ($clientId as $row) {
            $cid[] = $row->clientId;
        }

        $userid = Auth::user()->id;
        //$organization = user::where('id', '=', $userid)->value('organization');

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');

        }

        if (Auth::user()->roll == 2 || Auth::user()->roll == 1 && count($organization) > 0) {

            $clients = [NULL => 'Hospital'] + clients::orderBy('id', 'asc')
                    ->whereIn('id', $organization)
                    ->whereIn('id', $cid)
                    ->where('is_active', '1')
                    ->pluck('client_name', 'id')
                    ->all();

            $project = [NULL => 'Select Project'] + project::leftjoin('item_files', 'item_files.projectId', '=', 'projects.id')
                    ->leftjoin('user_projects', 'user_projects.projectId', '=', 'projects.id')
                    ->select('projects.*', 'item_files.projectId', 'item_files.clientId')
                    ->where('item_files.clientId', $itemMain['clientId'])
//                    ->where('user_projects.userId', $itemMain['repUser'])
                    ->pluck('project_name', 'id')
                    ->all();

        } else if (Auth::user()->roll == 5) {

            $clients = [NULL => 'Hospital'] + clients::leftjoin('user_clients', 'user_clients.clientId', '=', 'clients.id')
                    ->where('user_clients.userId', Auth::user()->id)
                    ->whereIn('clients.id', $cid)
                    ->orderBy('clients.id', 'asc')
                    ->where('clients.is_active', '1')
                    ->pluck('clients.client_name', 'clients.id')
                    ->all();

            $project = [NULL => 'Select Project'] + project::leftjoin('item_files', 'item_files.projectId', '=', 'projects.id')
                    ->leftjoin('user_projects', 'user_projects.projectId', '=', 'projects.id')
                    ->select('projects.*', 'item_files.projectId', 'item_files.clientId')
                    ->where('item_files.clientId', $itemMain['clientId'])
                    ->where('user_projects.userId', Auth::user()->id)
                    ->pluck('project_name', 'id')
                    ->all();

        } else if (Auth::user()->roll == 1 && count($organization) <= 0) {

            $clients = [NULL => 'Hospital'] + clients::orderBy('id', 'asc')
                    ->whereIn('id', $cid)
                    ->where('is_active', '1')
                    ->pluck('client_name', 'id')
                    ->all();

            $project = [NULL => 'Select Project'] + project::leftjoin('item_files', 'item_files.projectId', '=', 'projects.id')
                    ->leftjoin('user_projects', 'user_projects.projectId', '=', 'projects.id')
                    ->select('projects.*', 'item_files.projectId', 'item_files.clientId')
                    ->where('item_files.clientId', $itemMain['clientId'])
//                    ->where('user_projects.userId', $itemMain['repUser'])
                    ->pluck('project_name', 'id')
                    ->all();

        }

        $physician = [NULL => 'Select Physician'] + ItemfileDetails::orderBy('id', 'asc')->where('clientId', $itemMain['clientId'])
                ->where('doctors', '!=', '')
                ->pluck('doctors', 'doctors')
                ->all();

        $category = [NULL => 'Select Category'] + ItemfileDetails::orderBy('id', 'asc')->where('clientId', $itemMain['clientId'])
                ->where('projectId', $itemMain['projectId'])->groupBy('category')
                ->pluck('category', 'category')
                ->all();

        $company = [NULL => 'Select Company'];

        $supplyItem = [NULL => 'Select Supply Item'] + ItemfileDetails::orderBy('id', 'asc')
                ->where('clientId', $itemMain['clientId'])
                ->where('category', $itemMain['category'])
                ->where('company', $itemMain['manufacturer'])
                ->pluck('supplyItem', 'supplyItem')->all();

        $phyEmail = [NULL => 'Select Physician Email'] + ItemfileDetails::orderBy('id', 'asc')->where('clientId', $itemMain['clientId'])
                ->where('doctors', $itemMain['physician'])
                ->pluck('email', 'email')
                ->all();
//dd($itemMain);
        return view('pages.repcasetracker.edit', compact('clients', 'physician', 'project', 'category', 'itemdetails', 'itemMain', 'supplyItem', 'company', 'dataid', 'phyEmail'));
    }
    /*Edit Item File Data in item file main end*/

    /*Update Item File Data in Item File Main Start*/
    public function update(Request $request, $id) {

        $rules = array(
            'procedure_date' => 'required',
            'hospital' => 'required',
//            'repUser' => 'required',
            'physician' => 'required',
            'phyEmail' => 'required',
            'category' => 'required',
            'manufacturer' => 'required',
            'supplyItem' => 'required',
            'hospitalPart' => 'required',
            'mfgPartNumber' => 'required',
//			'quantity' => 'required',
            'purchaseType' => 'required',
            'serialNumber' => 'required',
            'poNumber' => 'required',
            'isImplanted' => 'required',
//            'type' => 'required',

        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $date = date_create_from_format('m-d-Y', $request->get('procedure_date'));
        $pdate = $date->format('Y-m-d');

        $data['repcaseID'] = $request->get('repcaseID');
        $data['produceDate'] = $pdate;
        $data['physician'] = $request->get('physician');
        $data['projectId'] = $request->get('project');
        $data['clientId'] = $request->get('hospital');
//        $data['repUser'] = Auth::user()->id;
        $data['phyEmail'] = $request->get('phyEmail');

//        $orderstatus = array();
        //
        //        $order = $request->get('order');
        //
        //        for ($i = 0; $i < count($order); $i++) {
        //            $orderstatus[] = order::where('id', $order[$i])->value('status');
        //        }

        $item_file = ItemFileMain::where('id', '=', $id)->update($data);

        if ($item_file) {

            $checkserialNumber = $request->get('serialNumber');
            $checksupplyItem = $request->get('supplyItem');

            for ($i = 0; $i < count($checksupplyItem); $i++) {
                $flag1 = "FALSE";
                $checkdevice = ItemFileEntry::where('supplyItem', $checksupplyItem[$i])->where('serialNumber', $checkserialNumber[$i])->where('itemMainId', $id)->value('serialNumber');

                if ($checkdevice == $checkserialNumber[$i]) {
                    $flag1 = "TRUE";
                } else {
                    if ($checkdevice != $checkserialNumber[$i]) {
                        $getdevice = ItemFileEntry::where('supplyItem', $checksupplyItem[$i])->where('serialNumber', $checkserialNumber[$i])->where('swapType', 'Swap In')->get();
                        if (count($getdevice) > 0) {
                            $flag1 = "FALSE";
                        } else {
                            $flag1 = "TRUE";
                        }
//                        $flag1 = $getdevice == $count = 0 ? "TRUE" : "FALSE";
                    }
                }

                if ($flag1 == "FALSE") {
                    // dd(count($getdevice));
                    return redirect()->back()
                        ->withErrors(['serialNumber' => 'please Enter Valid serial Number..!!']);
                }

            }

            $removedata = array();

            $ItemFileEntry = ItemFileEntry::where('itemMainId', $id)->where('swapDate', '=', NULL)->get();
            foreach ($ItemFileEntry as $re) {

                $removedata[] = $re->id;
                $status = $re->serialNumber;
                $upstatuss['status'] = '';
                $serials = SerialnumberDetail::where('serialNumber', $status)->first();

                if ($serials) {
                    $serialupdate = SerialnumberDetail::where('serialNumber', $status)->update($upstatuss);
                }

            }
            if ($ItemFileEntry) {

                $supplyItem = $request->get('supplyItem');
                $hospitalPart = $request->get('hospitalPart');
                $mfgPartNumber = $request->get('mfgPartNumber');
                $quantity = '1';
                $purchaseType = $request->get('purchaseType');
                $serialNumber = $request->get('serialNumber');
                $poNumber = $request->get('poNumber');
                $status = $request->get('status');
//                $order = $request->get('order');
                //$orderstatus = $orderstatus;
                $category = $request->get('category');
                $manufacturer = $request->get('manufacturer');
                $oldId = $request->get('oldId');
                $oldPurchaseType = $request->get('oldPurchaseType');
                $oldSwapDate = $request->get('oldswapDate');
                $swapId = $request->get('swapId');
                $completeNew = $request->get('completeNew');
                $isImplanted = $request->get('isImplanted');
//                $type = $request->get('type');
                $unusedReason = $request->get('unusedReason');
                $swap = $request->get('swap');
                $dataid = $request->get('dataid');
                $cco_check = $request->get('cco_check');
                $repless_check = $request->get('repless_check');
                $datasId = '';
                $serialNumbers = '';
                $bulks = '';
                $swaps = '';

                for ($i = 0; $i < count($supplyItem); $i++) {
                    if ($supplyItem[$i] != "") {

                        $insertrecord = array(
                            "repcaseID" => $data['repcaseID'],
                            "supplyItem" => $supplyItem[$i],
                            "hospitalPart" => $hospitalPart[$i],
                            "mfgPartNumber" => $mfgPartNumber[$i],
                            "quantity" => $quantity,
                            "purchaseType" => $purchaseType[$i],
                            "serialNumber" => $serialNumber[$i],
                            "poNumber" => $poNumber[$i],
                            "status" => $status[$i],
                            "itemMainId" => $id,
//                            "orderId" => $order[$i],
                            //                            "oldOrderStatus" => $orderstatus[$i],
                            "category" => $category[$i],
                            "manufacturer" => $manufacturer[$i],
                            "projectId" => $data['projectId'],
                            "oldId" => $oldId[$i],
                            "swapId" => $swapId[$i],
                            "newSwapDate" => $oldSwapDate[$i],
                            "completeNew" => $completeNew[$i],
                            "created_at" => Carbon\Carbon::now(),
                            "updated_at" => Carbon\Carbon::now(),
                            "swapType" => $swap[$i],
                            "dataId" => $dataid[$i],
                            "isImplanted" => $isImplanted[$i],
//                            "type" => $type[$i],
                            "unusedReason" => $unusedReason[$i],
                            "cco_check" => $cco_check[$i],
                            "repless_check" => $repless_check[$i],
                        );
//dd($request->all());

                        if ($purchaseType[$i] == "Consignment") {

                            $getdeviceId = device::where('model_name', $mfgPartNumber[$i])->value('id');

                            $checkserial = Serialnumber::where('clientId',$request->get('hospital'))
                                ->where('deviceId',$getdeviceId)->first();

                            if(empty($checkserial)){
                                $addnewdata['serialFile'] = 'serial_number.xlsx';
                                $addnewdata['clientId'] =$request->get('hospital');
                                $addnewdata['deviceId'] = $getdeviceId;

                                $serial_details = new Serialnumber();
                                $serial_details->fill($addnewdata);
                                $serial_details->save();

                            }

                            if (!empty($getdeviceId)) {
                                $addserial['serialNumber'] = $serialNumber[$i];
                                $addserial['clientId'] = $request->get('hospital');
                                $addserial['deviceId'] = $getdeviceId;
                                $addserial['purchaseType'] = "Consignment";

                                $serialdevice = new SerialnumberDetail();
                                $serialdevice->fill($addserial);
                                $serialdevice->save();
                            }

                        }

                        $upstatus['swapType'] = $swap[$i];
                        if ($purchaseType[$i] == "Bulk") {
                            $upstatus['status'] = "Used In Bulk";
                        } else {
                            $upstatus['status'] = "Used In Consignment";
                        }

                        $serial = SerialnumberDetail::where('serialNumber', $serialNumber[$i])->first();

                        if ($serial) {
                            $serialupdate = SerialnumberDetail::where('serialNumber', $serialNumber[$i])->update($upstatus);
                        }

                        $getswapedid = ItemFileEntry::where('serialNumber', $serialNumbers)->where('itemMainId', $id)->first();

                        if ($datasId == $dataid[$i] && $swaps == 'Swap Out') {

                            $sd['swapDate'] = Carbon\Carbon::now()->format('Y-m-d');
                            $sd['swappedId'] = $getswapedid['id'] + 1;
                            $insertrecord['newSwapDate'] = Carbon\Carbon::now()->format('Y-m-d');
                            $upswapedid = ItemFileEntry::where('serialNumber', $serialNumbers)->where('itemMainId', $id)->update($sd);

                        }

                        if ($dataid[$i] != '' && $swaps == 'Swap Out') {

                            $insertrecord['swapDate'] = Carbon\Carbon::now()->format('Y-m-d');
                            $insertrecord['swappedId'] = $getswapedid['id'];

                            $sd['newSwapDate'] = Carbon\Carbon::now()->format('Y-m-d');

                            $upswapedid = ItemFileEntry::where('serialNumber', $serialNumbers)->where('itemMainId', $id)->update($sd);

                        }

                        if ($dataid[$i] != '' && $oldPurchaseType[$i] == 'Bulk' && $swap[$i] == 'Swap In') {

                            $oldserial = ItemFileEntry::where('id', $oldId[$i])->value('serialNumber');

                            $olddata = ItemFileEntry::where('id', $oldId[$i])->first();

                            $checkserialdiscont = SerialnumberDetail::where('serialNumber', $oldserial)->first();
                            $getserialdiscont = SerialnumberDetail::where('serialNumber', $serialNumber[$i])->first();

                            if ($purchaseType[$i] == 'Consignment' && $olddata['scenario'] != '2') {

                                if (!empty($getserialdiscont)) {

                                    $updatediscount = SerialnumberDetail::where('serialNumber', $serialNumber[$i])
                                        ->update(['discount' => $checkserialdiscont['discount'], 'purchaseType' => 'Bulk', 'status' => 'Used In Bulk', 'ischanged' => 'Yes', 'serialId' => $checkserialdiscont['serialId']]);

                                    $updatestatus = SerialnumberDetail::where('serialNumber', $oldserial)
                                        ->delete();

                                    $insertrecord['purchaseType'] = "Bulk";
                                }
                            } elseif ($purchaseType[$i] == 'Bulk' && $oldserial != $serialNumber[$i] && $olddata['scenario'] != '2') {

                                if (!empty($getserialdiscont)) {

                                    $updatediscount = SerialnumberDetail::where('serialNumber', $serialNumber[$i])
                                        ->update(['discount' => $checkserialdiscont['discount'], 'purchaseType' => 'Bulk', 'status' => 'Used In Bulk', 'serialId' => $checkserialdiscont['serialId']]);

                                    if ($checkserialdiscont['ischanged'] == 'Yes') {

                                        $updatestatus = SerialnumberDetail::where('serialNumber', $oldserial)
                                            ->delete();
                                    } else {

                                        $updatestatus = SerialnumberDetail::where('serialNumber', $oldserial)
                                            ->update(['discount' => '', 'status' => '', 'ischanged' => '', 'swapType' => '']);
                                    }

                                    $insertrecord['purchaseType'] = "Bulk";
                                }
                            } elseif ($purchaseType[$i] == 'Consignment' && $olddata['scenario'] == '2') {
                                $updatestatus = SerialnumberDetail::where('serialNumber', $oldserial)
                                    ->update(['status' => '', 'ischanged' => '', 'swapType' => '']);

                                $insertrecord['purchaseType'] = "Consignment";
                            }

                        }

                        $insert_custom_field = new ItemFileEntry;
                        $insert_custom_field->fill($insertrecord);
                        $insert_custom_field->save();

                        /*Bulk Count Start*/

                        $device = device::where('model_name', $mfgPartNumber[$i])
//                            ->where('device_name', $supplyItem[$i])
                            ->first();

                        if (!empty($device)) {
                            $count = SerialnumberDetail::where('clientId', $request->get('hospital'))->where('deviceId', $device->id)->where('status', '=', '')->count();

                            $flag1 = false;
                            $flag2 = false;
                            $unitbluk = client_price::where('client_name', $request->get('hospital'))->where('device_id', $device->id)->where('bulk_check', 'True')->value('bulk');
                            $systembluk = client_price::where('client_name', $request->get('hospital'))->where('device_id', $device->id)->where('system_bulk_check', 'True')->value('system_bulk');

                            if (!empty($unitbluk)) {
                                $flag1 = true;
                            }

                            if (!empty($systembluk)) {
                                $flag2 = true;
                            }
                            if ($flag1 == true) {
                                $bulk['bulk'] = $count;
                                $bulkupdate = client_price::where('client_name', $request->get('hospital'))->where('device_id', $device->id)->update($bulk);
                            }

                            if ($flag2 == true) {
                                $systembulk['system_bulk'] = $count;
                                $bulkupdate = client_price::where('client_name', $request->get('hospital'))->where('device_id', $device->id)->update($systembulk);
                            }
                            /*Bulk Count end*/

                        }

                        $sep['swapId'] = $insert_custom_field->id;
                        $updata = ItemFileEntry::where('swapId', $oldId[$i])->update($sep);

                        $datasId = $dataid[$i];
                        $serialNumbers = $serialNumber[$i];
                        $bulks = $purchaseType[$i];
                        $swaps = $swap[$i];
                    }

                }

                $removeitementry = ItemFileEntry::whereIn('id', $removedata)->delete();

//                $update['status'] = 'Complete';
                //
                //                $update_custom_field = order::whereIn('id', $order)->update($update);

            }

            return Redirect::to('admin/repcasetracker');
        }
    }
    /*Update Item File Data in Item File Main End*/

    /*Remove Item File Data Start*/
    public function remove($id) {
        $ItemFilemain = ItemFileMain::where('id', $id)->delete();

        $ItemFileEntry = ItemFileEntry::where('itemMainId', $id)->delete();

        return Redirect::to('admin/repcasetracker');
    }
    /*Remove Item FIle Data End*/

    /*Itemfile export start*/
    public function export(Request $request) {
        $chkRep = $request['ck_rep'];
        $sortby = $request['sortby'];

        $getmanufacture = $request->get('manufacture');

        $getcategory = $request->get('category');

        $getpurchase = $request->get('purchase');

        $itemdetails = ItemFileEntry::itemdata()->whereIn('item_file_entry.itemMainId', $chkRep)->distinct();

        if ($getmanufacture != '') {
            $itemdetails = $itemdetails->where('item_file_entry.manufacturer', $getmanufacture);
        }
        if ($getcategory != '') {
            $itemdetails = $itemdetails->where('item_file_entry.category', $getcategory);
        }
        if ($getpurchase != '') {
            $itemdetails = $itemdetails->where('item_file_entry.purchaseType', $getpurchase);
        }

        if ($sortby == '1') {
            $itemdetails = $itemdetails->orderBy('item_file_main.produceDate', 'desc')->orderBy('item_file_entry.itemMainId', 'desc')->get();
        } elseif ($sortby == '2') {
            $itemdetails = $itemdetails->orderBy('item_file_main.physician', 'desc')->orderBy('item_file_entry.itemMainId', 'desc')->get();
        } elseif ($sortby == '3') {
            $itemdetails = $itemdetails->orderBy('item_file_main.clientId', 'desc')->orderBy('item_file_entry.itemMainId', 'desc')->get();
        } else {
            $itemdetails = $itemdetails->orderBy('item_file_entry.itemMainId', 'desc')->get();
        }

        // $itemdetails = ItemFileEntry::distinct('itemMainId')->whereIn('itemMainId',$chkRep)->orderBy('itemMainId')->get();

        foreach ($itemdetails as $row) {
            $row->produceDate = $row->produceDate;
            $row->repcaseID = $row->repcaseID;
            $row->user = $row->itemfilename->users['name'];
            $row->manufacturer = $row->manufacturer;
            $row->category = $row->category;
            $row->supplyItem = $row->supplyItem;
            $row->hospitalPart = $row->hospitalPart;
            $row->mfgPartNumber = $row->mfgPartNumber;
            $row->quantity = $row->quantity;
            $row->physician = $row->physician;
            $row->client_name = $row->client_name;
            $row->purchaseType = $row->purchaseType;
            $row->serialNumber = $row->serialNumber;
            $row->poNumber = $row->poNumber;
            $row->swapdate = $row->swapDate;
            $row->isImplanted = $row->isImplanted;
            $row->unusedReason = $row->unusedReason;

        }

        foreach ($itemdetails as $row) {

            $itemfile_data[] = [
                $row['produceDate'],
                $row['repcaseID'],
                $row['repUser'],
                $row['manufacturer'],
                $row['category'],
                $row['supplyItem'],
                $row['hospitalPart'],
                $row['mfgPartNumber'],
                $row['quantity'],
                $row['physician'],
                $row['client_name'],
                $row['purchaseType'],
                $row['serialNumber'],
                $row['poNumber'],
                $row['swapdate'],
                $row['isImplanted'],
                $row['unusedReason'],

            ];
        }

        $myFile = Excel::create('Repcase_Tracker', function ($excel) use ($itemfile_data) {

            $excel->setTitle('Repcase Tracker');
            $excel->setCreator('Admin')->setCompany('Neptune-PPA');
            $excel->setDescription('Order Analytics');

            $excel->sheet('Repcase Tracker', function ($sheet) use ($itemfile_data) {
                $sheet->row(1, array('Produce Date', 'Case Id', 'Rep User', 'Manufacturers', 'Category', 'Supply Item Description', 'Hospital Part#', 'Manuf Part#', 'Quantity', 'Physician Name', 'Hospital', 'Purchase Type', 'Serial Number', 'P.O. Number', 'Swap Date', 'Device Status', 'Reason'));
                $sheet->row($sheet->getHighestRow(), function ($row) {
                    $row->setFontWeight('bold');
                });
                foreach ($itemfile_data as $row) {
                    $sheet->appendRow($row);
                }
            });
        });

        $myFile = $myFile->string('xlsx');
        $response = array(
            'name' => "Repcase_Tracker", //no extention needed
            'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($myFile), //mime type of used format
        );
        return response()->json($response);
        exit();
    }
    /*Itemfile export end*/
    /*Repcase tracker search start*/
    public function search(Request $request) {

        $search = $request->get('search');
        $sortby = $request->get('sortby');

        $getmanufacture = $request->get('manufacture');

        $getcategory = $request->get('category');

        $getpurchase = $request->get('purchase');

        $userid = Auth::user()->id;

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();

        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');

        }

        if (Auth::user()->roll == 2 || Auth::user()->roll == 1 && count($organization) > 0) {

            $itemdetails = ItemFileEntry::itemdata()->distinct('item_file_entry.itemMainId')
                ->whereIn('item_file_main.clientId', $organization);

        } else if (Auth::user()->roll == 5) {
            $itemdetails = ItemFileEntry::itemdata()->distinct('item_file_entry.itemMainId')
                ->where('user_clients.userId', Auth::user()->id)
                ->where('item_file_main.repUser', Auth::user()->id);

        } else if (Auth::user()->roll == 1 && count($organization) <= 0) {

            $itemdetails = ItemFileEntry::itemdata()->distinct('item_file_entry.itemMainId');
        }

        if (!empty($search[0])) {
            $itemdetails = $itemdetails->whereDate('item_file_main.produceDate', 'LIKE', $search[0] . '%');
        }

        if (!empty($search[1])) {
            $itemdetails = $itemdetails->where('item_file_entry.repcaseID', 'LIKE', $search[1] . '%');
        }

        if (!empty($search[2])) {
            $itemdetails = $itemdetails->where('users.name', 'LIKE', $search[2] . '%');
        }

        if (!empty($search[3])) {
            $itemdetails = $itemdetails->where('item_file_entry.manufacturer', 'LIKE', $search[3] . '%');
        }

        if (!empty($search[4])) {
            $itemdetails = $itemdetails->where('item_file_entry.category', 'LIKE', $search[4] . '%');
        }

        if (!empty($search[5])) {
            $itemdetails = $itemdetails->where('item_file_entry.supplyItem', 'LIKE', $search[5] . '%');
        }

        if (!empty($search[6])) {
            $itemdetails = $itemdetails->where('item_file_entry.hospitalPart', 'LIKE', $search[6] . '%');
        }

        if (!empty($search[7])) {
            $itemdetails = $itemdetails->where('item_file_entry.mfgPartNumber', 'LIKE', $search[7] . '%');
        }

        if (!empty($search[8])) {
            $itemdetails = $itemdetails->where('item_file_main.physician', 'LIKE', $search[8] . '%');
        }

        if (!empty($search[9])) {
            $itemdetails = $itemdetails->where('clients.client_name', 'LIKE', $search[9] . '%');
        }

        if (!empty($search[10])) {
            $itemdetails = $itemdetails->where('item_file_entry.purchaseType', 'LIKE', $search[10] . '%');
        }

//        if (!empty($search[10])) {
        //            $itemdetails = $itemdetails->where('item_file_entry.orderId', 'LIKE', $search[10] . '%');
        //        }

        if (!empty($search[11])) {
            $itemdetails = $itemdetails->where('item_file_entry.serialNumber', 'LIKE', $search[11] . '%');
        }

        if (!empty($search[12])) {
            $itemdetails = $itemdetails->where('item_file_entry.poNumber', 'LIKE', $search[12] . '%');
        }

        if (!empty($search[13])) {
            $itemdetails = $itemdetails->whereDate('item_file_entry.swapDate', 'LIKE', $search[13] . '%');
        }

        if (!empty($search[14])) {
            $itemdetails = $itemdetails->where('item_file_entry.isImplanted', 'LIKE', $search[14] . '%');
        }

        if (!empty($search[15])) {
            $itemdetails = $itemdetails->where('item_file_entry.unusedReason', 'LIKE', $search[15] . '%');
        }

        if (!empty($search[16])) {
            $itemdetails = $itemdetails->where('item_file_entry.swapType', 'LIKE', $search[16] . '%');
        }

        if ($getmanufacture != '') {
            $itemdetails = $itemdetails->where('item_file_entry.manufacturer', $getmanufacture);
        }
        if ($getcategory != '') {
            $itemdetails = $itemdetails->where('item_file_entry.category', $getcategory);
        }
        if ($getpurchase != '') {
            $itemdetails = $itemdetails->where('item_file_entry.purchaseType', $getpurchase);
        }

        if ($sortby == '1') {
            $itemdetails = $itemdetails->orderBy('item_file_main.produceDate', 'desc')
                ->orderBy('item_file_entry.itemMainId')
//                ->orderBy('item_file_entry.supplyItem', 'desc')
                ->orderBy('item_file_entry.swapDate', 'ASC')
                ->orderBy('item_file_entry.id', 'desc')
                ->get();
            // dd($itemdetails);
        } elseif ($sortby == '2') {
            $itemdetails = $itemdetails->orderBy('item_file_main.physician', 'desc')
                ->orderBy('item_file_entry.itemMainId')
//                ->orderBy('item_file_entry.supplyItem', 'desc')
                ->orderBy('item_file_entry.swapDate', 'ASC')
                ->orderBy('item_file_entry.id', 'desc')
                ->get();
        } elseif ($sortby == '3') {
            $itemdetails = $itemdetails->orderBy('item_file_main.clientId', 'desc')
                ->orderBy('item_file_entry.itemMainId', 'desc')
//                ->orderBy('item_file_entry.supplyItem', 'desc')
                ->orderBy('item_file_entry.swapDate', 'ASC')
                ->orderBy('item_file_entry.id', 'desc')
                ->get();
        } else {
            $itemdetails = $itemdetails->orderBy('item_file_entry.itemMainId', 'desc')
//                ->orderBy('item_file_entry.supplyItem', 'desc')
                ->orderBy('item_file_entry.swapDate', 'ASC')
                ->orderBy('item_file_entry.id', 'desc')
                ->get();
        }

        // $itemdetails = $itemdetails->orderBy('item_file_entry.itemMainId','desc')->get();

        $data = array();
        foreach ($itemdetails as $row => $value) {
            $data[] = array(

                'produceDate' => Carbon\Carbon::parse($value->produceDate)->format('m-d-Y'),
                'repcaseID' => $value->repcaseID,
                'manufacturer' => $value->manufacturer,
                'repUser' => $value->repUser,
                'category' => $value->category,
                'supplyItem' => $value->supplyItem,
                'hospitalPart' => $value->hospitalPart,
                'mfgPartNumber' => $value->mfgPartNumber,
//				'quantity' => $value->quantity,
                'physician' => $value->physician,
                'client_name' => $value->client_name,
                'purchaseType' => $value->purchaseType,
//                'orderId' => $value->orderId,
                'serialNumber' => $value->serialNumber,
                'poNumber' => $value->poNumber,
                'swapDate' => $value->swapDate = $value->swapDate == null ? null : Carbon\Carbon::parse($value->swapDate)->format('m-d-Y'),
                'itemMainId' => $value->itemMainId,
                'swapType' => $value->swapType,
                'isImplanted' => $value->isImplanted,
                'unusedReason' => $value->unusedReason,

            );
        }

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

    /*Swap device Start*/
    public function swapdevice($id) {
        return view('pages.repcasetracker.swapdevice', compact('id'));
    }

    public function swapserialnumber($id) {

        $itemdetails = ItemFileEntry::where('itemMainId', $id)->get();

        $itemMain = ItemFileMain::where('id', $id)->first();

        return view('pages.repcasetracker.swapserialnumber', compact('id', 'itemdetails', 'itemMain'));
    }

    public function swapnewdevice($id) {
        $itemdetails = ItemFileEntry::where('itemMainId', $id)->get();

        $itemMain = ItemFileMain::where('id', $id)->first();

        $category = [NULL => 'Select Category'] + ItemfileDetails::orderBy('id', 'asc')->where('clientId', $itemMain['clientId'])
                ->where('projectId', $itemMain['projectId'])->groupBy('category')
                ->pluck('category', 'category')
                ->all();

        return view('pages.repcasetracker.swapnewdevice ', compact('id', 'itemdetails', 'itemMain', 'category'));
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function swapupdate(Request $request, $id) {

        $rules = array(
            'procedure_date' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $checkserialNumber = $request->get('serialNumber');
        $checksupplyItem = $request->get('supplyItem');

        $flag1 = "FALSE";
        for ($i = 0; $i < count($checksupplyItem); $i++) {

            $checkdevice = ItemFileEntry::where('supplyItem', $checksupplyItem[$i])->where('serialNumber', $checkserialNumber[$i])->where('itemMainId', $id)->value('serialNumber');
//            print_r($checkserialNumber[$i]);
            //            print_r($checkdevice);
            if ($checkdevice == $checkserialNumber[$i]) {
                $flag1 = "TRUE";
            } else {
                if ($checkdevice != $checkserialNumber[$i]) {
                    $getdevice = ItemFileEntry::where('serialNumber', $checkserialNumber[$i])->where('swapType', 'Swap In')->get();

                    $flag1 = count($getdevice) == 0 ? "TRUE" : "FALSE";
                }
            }
//            print_r($flag1);
            if ($flag1 == "FALSE") {
                // dd(count($getdevice));
                return redirect()->back()
                    ->withErrors(['serialNumber' => 'please Enter Valid serial Number..!!']);
            }

        }

//        $orderstatus = array();

//        $order = $request->get('order');
        //
        //        for ($i = 0; $i < count($order); $i++) {
        //            $orderstatus[] = order::where('id', $order[$i])->value('status');
        //        }

        $serialnumbers = ItemFileEntry::where('itemMainId', $id)->get();
        $serialno = array();
        foreach ($serialnumbers as $item) {
            $serialno[] = $item->serialNumber;
        }

        $supplyItem = $request->get('supplyItem');
        $hospitalPart = $request->get('hospitalPart');
        $mfgPartNumber = $request->get('mfgPartNumber');
        $quantity = '1';
        $purchaseType = $request->get('purchaseType');
        $serialNumber = $request->get('serialNumber');
        $poNumber = $request->get('poNumber');
        $status = $request->get('status');
//		$order = $request->get('order');
        //        $orderstatus = $orderstatus;
        $category = $request->get('category');
        $manufacturer = $request->get('manufacturer');
        $swapId = $request->get('serialId');

        for ($i = 0; $i < count($supplyItem); $i++) {
            if (!in_array($serialNumber[$i], $serialno)) {
                if ($supplyItem[$i] != "") {

                    $insertrecord = array(
                        "repcaseID" => $request->get('repcaseID'),
                        "supplyItem" => $supplyItem[$i],
                        "hospitalPart" => $hospitalPart[$i],
                        "mfgPartNumber" => $mfgPartNumber[$i],
                        "quantity" => $quantity,
                        "purchaseType" => $purchaseType[$i],
                        "serialNumber" => $serialNumber[$i],
                        "poNumber" => $poNumber[$i],
                        "status" => $status[$i],
                        "itemMainId" => $id,
//						"orderId" => $order[$i],
                        //                        "oldOrderStatus" => $orderstatus[$i],
                        "category" => $category[$i],
                        "manufacturer" => $manufacturer[$i],
                        "projectId" => $request->get('projectId'),
                        "newSwapDate" => Carbon\Carbon::now()->format('Y-m-d'),
                        "swapId" => $swapId[$i],
                        "swapType" => "Swap In",
                        "created_at" => Carbon\Carbon::now(),
                        "updated_at" => Carbon\Carbon::now(),
                    );

                    /*Serial Number Delete in Device start*/
                    $checkDeleteSerial = ItemFileEntry::where('id', $swapId[$i])->first();
                    $deleteSerial = SerialnumberDetail::where('serialNumber', $checkDeleteSerial['serialNumber'])->update(['status' => '']);
                    /*Serial Number Delete in Device End*/

                    if ($purchaseType[$i] == "Consignment") {

                        $getdeviceId = device::where('model_name', $mfgPartNumber[$i])->value('id');

                        if (!empty($getdeviceId)) {
                            $addserial['serialNumber'] = $serialNumber[$i];
                            $addserial['clientId'] = $request->get('hospital');
                            $addserial['deviceId'] = $getdeviceId;
                            $addserial['purchaseType'] = "Consignment";

                            $serialdevice = new SerialnumberDetail();
                            $serialdevice->fill($addserial);
                            $serialdevice->save();
                        }

                    }

                    if ($purchaseType[$i] == "Bulk") {
                        $upstatus['status'] = "Used In Bulk";
                    } else {
                        $upstatus['status'] = "Used In Consignment";
                    }

                    $serial = SerialnumberDetail::where('serialNumber', $serialNumber[$i])->first();
                    if ($serial) {
                        $serialupdate = SerialnumberDetail::where('serialNumber', $serialNumber[$i])->update($upstatus);
                    }

                    $insert_custom_field = new ItemFileEntry;
                    $insert_custom_field->fill($insertrecord);
                    $insert_custom_field->save();

                    /*Bulk Count Start*/

                    $device = device::where('model_name', $mfgPartNumber[$i])
//                        ->where('device_name', $supplyItem[$i])
                        ->first();
                    if (!empty($device)) {
                        $count = SerialnumberDetail::where('clientId', $request->get('client'))->where('deviceId', $device->id)->where('status', '=', '')->count();

                        $flag1 = false;
                        $flag2 = false;
                        $unitbluk = client_price::where('client_name', $request->get('client'))->where('device_id', $device->id)->where('bulk_check', 'True')->first();
                        $systembluk = client_price::where('client_name', $request->get('client'))->where('device_id', $device->id)->where('system_bulk_check', 'True')->first();

                        if (!empty($unitbluk)) {
                            $flag1 = true;
                        }

                        if (!empty($systembluk)) {
                            $flag2 = true;
                        }
                        if ($flag1 == true) {
                            $bulk['bulk'] = $count;
                            $bulkupdate = client_price::where('client_name', $request->get('client'))->where('device_id', $device->id)->update($bulk);
                        }

                        if ($flag2 == true) {
                            $systembulk['system_bulk'] = $count;
                            $bulkupdate = client_price::where('client_name', $request->get('client'))->where('device_id', $device->id)->update($systembulk);
                        }
                    }

                    /*Bulk Count end*/

                    $sep['swappedId'] = $insert_custom_field->id;
                    $sep['swapDate'] = Carbon\Carbon::now()->format('Y-m-d');
                    $sep['swapType'] = "Swap Out";
                    $updata = ItemFileEntry::where('id', $swapId[$i])->update($sep);

                }
            }

        }

        return Redirect::to('admin/repcasetracker');
    }

    /*Swap Device Completly new device Update*/
    public function swapupdates(Request $request, $id) {

        $rules = array(
            'procedure_date' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $checkserialNumber = $request->get('serialNumber');
        $checksupplyItem = $request->get('supplyItem');

        $flag1 = "FALSE";
        for ($i = 0; $i < count($checksupplyItem); $i++) {

            $checkdevice = ItemFileEntry::where('supplyItem', $checksupplyItem[$i])->where('serialNumber', $checkserialNumber[$i])->where('itemMainId', $id)->value('serialNumber');

            if ($checkdevice == $checkserialNumber[$i]) {
                $flag1 = "TRUE";
            } else {
                if ($checkdevice != $checkserialNumber[$i]) {
                    $getdevice = ItemFileEntry::where('serialNumber', $checkserialNumber[$i])->where('swapType', 'Swap In')->get();

                    $flag1 = count($getdevice) == 0 ? "TRUE" : "FALSE";
                }
            }

            if ($flag1 == "FALSE") {

                return redirect()->back()
                    ->withErrors(['serialNumber' => 'please Enter Valid serial Number..!!']);
            }

        }

        $serialnumbers = ItemFileEntry::where('itemMainId', $id)->get();
        $serialno = array();
        foreach ($serialnumbers as $item) {
            $serialno[] = $item->serialNumber;
        }

        $supplyItem = $request->get('supplyItem');
        $hospitalPart = $request->get('hospitalPart');
        $mfgPartNumber = $request->get('mfgPartNumber');
        $quantity = '1';
        $purchaseType = $request->get('purchaseType');
        $serialNumber = $request->get('serialNumber');
        $poNumber = $request->get('poNumber');
        $status = $request->get('status');
//		$order = $request->get('order');
        $category = $request->get('category');
        $manufacturer = $request->get('manufacturer');
        $swapId = $request->get('serialId');

        for ($i = 0; $i < count($supplyItem); $i++) {
            if (!in_array($serialNumber[$i], $serialno)) {
                if ($supplyItem[$i] != "") {

                    $insertrecord = array(
                        "repcaseID" => $request->get('repcaseID'),
                        "supplyItem" => $supplyItem[$i],
                        "hospitalPart" => $hospitalPart[$i],
                        "mfgPartNumber" => $mfgPartNumber[$i],
                        "quantity" => $quantity,
                        "purchaseType" => $purchaseType[$i],
                        "serialNumber" => $serialNumber[$i],
                        "poNumber" => $poNumber[$i],
                        "status" => $status[$i],
                        "itemMainId" => $id,
//						"orderId" => $order[$i],
                        //                        "oldOrderStatus" => $orderstatus[$i],
                        "category" => $category[$i],
                        "manufacturer" => $manufacturer[$i],
                        "projectId" => $request->get('projectId'),
                        "newSwapDate" => Carbon\Carbon::now()->format('Y-m-d'),
                        "swapId" => $swapId[$i],
                        "completeNew" => "Yes",
                        "swapType" => "Swap In",
                        "created_at" => Carbon\Carbon::now(),
                        "updated_at" => Carbon\Carbon::now(),
                    );

                    /*Serial Number Delete in Device start*/
                    $checkDeleteSerial = ItemFileEntry::where('id', $swapId[$i])->first();
                    $deleteSerial = SerialnumberDetail::where('serialNumber', $checkDeleteSerial['serialNumber'])->update(['status' => '']);
                    /*Serial Number Delete in Device End*/

                    if ($purchaseType[$i] == "Consignment") {

                        $getdeviceId = device::where('model_name', $mfgPartNumber[$i])->value('id');

                        if (!empty($getdeviceId)) {
                            $addserial['serialNumber'] = $serialNumber[$i];
                            $addserial['clientId'] = $request->get('hospital');
                            $addserial['deviceId'] = $getdeviceId;
                            $addserial['purchaseType'] = "Consignment";

                            $serialdevice = new SerialnumberDetail();
                            $serialdevice->fill($addserial);
                            $serialdevice->save();
                        }

                    }

                    if ($purchaseType[$i] == "Bulk") {
                        $upstatus['status'] = "Used In Bulk";
                    } else {
                        $upstatus['status'] = "Used In Consignment";
                    }

                    $serial = SerialnumberDetail::where('serialNumber', $serialNumber[$i])->first();
                    if ($serial) {
                        $serialupdate = SerialnumberDetail::where('serialNumber', $serialNumber[$i])->update($upstatus);
                    }

                    $insert_custom_field = new ItemFileEntry;
                    $insert_custom_field->fill($insertrecord);
                    $insert_custom_field->save();

                    /*Bulk Count Start*/

                    $device = device::where('model_name', $mfgPartNumber[$i])
//                        ->where('device_name', $supplyItem[$i])
                        ->first();
                    if (!empty($device)) {
                        $count = SerialnumberDetail::where('clientId', $request->get('client'))->where('deviceId', $device->id)->where('status', '=', '')->count();

                        $flag1 = false;
                        $flag2 = false;
                        $unitbluk = client_price::where('client_name', $request->get('client'))->where('device_id', $device->id)->where('bulk_check', 'True')->first();
                        $systembluk = client_price::where('client_name', $request->get('client'))->where('device_id', $device->id)->where('system_bulk_check', 'True')->first();

                        if (!empty($unitbluk)) {
                            $flag1 = true;
                        }

                        if (!empty($systembluk)) {
                            $flag2 = true;
                        }
                        if ($flag1 == true) {
                            $bulk['bulk'] = $count;
                            $bulkupdate = client_price::where('client_name', $request->get('client'))->where('device_id', $device->id)->update($bulk);
                        }

                        if ($flag2 == true) {
                            $systembulk['system_bulk'] = $count;
                            $bulkupdate = client_price::where('client_name', $request->get('client'))->where('device_id', $device->id)->update($systembulk);
                        }
                    }

                    /*Bulk Count end*/

                    $sep['swappedId'] = $insert_custom_field->id;
                    $sep['swapDate'] = Carbon\Carbon::now()->format('Y-m-d');
                    $sep['swapType'] = "Swap Out";
                    $updata = ItemFileEntry::where('id', $swapId[$i])->update($sep);

                }
            }

        }
//        $update['status'] = 'Complete';
        //
        //        $update_custom_field = order::whereIN('id', $order)->update($update);

        return Redirect::to('admin/repcasetracker');
    }
    /*Swap device end*/

    /*Get Serial Numbers from Device Start*/
    public function getserialnumber(Request $request) {
        $supplyItem = $request->get('supplyItem');
        $model = $request->get('mfgPartNumber');
        $client = $request->get('client');

        $device = device::where('model_name', $model)
//                            ->where('device_name', $supplyItem)
            ->first();

        $check = array();
        $checkserial = ItemFileEntry::get();

        foreach ($checkserial as $row) {
            $check[] = $row->serialNumber;
        }

        $serialNumber = SerialnumberDetail::where('clientId', $client)
            ->where('deviceId', $device['id'])
            ->whereNotIn('serialNumber', $check)
            ->get();

        $data = $serialNumber;

        // $html = "<select name ='serialNumber[]' type = 'text' class='js-example-basic-multiple2 repbox-input serialNumber' id='serialNumber' data-id='" . $request->get('id') . "'><option value=''>Select Serial Number</option>";

        // foreach ($serialNumber as $row) {
        //     $html .= "<option value='" . $row->serialNumber . "'>" . $row->serialNumber . "</option>";
        // }

        // $html .= "</select>";

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

    public function getserialnumbers(Request $request) {
        $supplyItem = $request->get('supplyItem');
        $model = $request->get('manufacturepart');
        $client = $request->get('hospital');
        $serialNumber = $request->get('serialNumber');
        $purchase = $request->get('purchase');
        $dataid = $request->get('dataid');

        $data = array();
        $data1 = array();

        for ($i = 0; $i < count($supplyItem); $i++) {

            if ($purchase[$i] == 'Bulk') {

                $device = device::where('model_name', $model[$i])
//                                    ->where('device_name', $supplyItem[$i])
                    ->first();

                $check = array();
                $checkserial = ItemFileEntry::get();

                foreach ($checkserial as $row) {
                    $check[] = $row->serialNumber;
                }

                $serialNumbers = SerialnumberDetail::where('clientId', $client)->where('deviceId', $device['id'])
                    ->whereNotIn('serialNumber', $check)->get();

                $data = $serialNumbers;
            } else {
                $data = array();
            }

            $data1[] = array('datas' => $data, 'dataid' => $dataid[$i], 'serial' => $serialNumber[$i], 'purchase' => $purchase[$i]);
        }

        if (count($data1)) {
            return [
                'value' => $data1,
                'status' => TRUE,
            ];
        } else {
            return [
                'value' => 'No result Found',
                'status' => FALSE,
            ];
        }

    }

    public function getserial(Request $request) {
        $supplyItem = $request->get('supplyItem');
        $model = $request->get('mfgPartNumber');
        $client = $request->get('client');

        $device = device::where('device_name', $supplyItem)->where('model_name', $model)->first();

        $check = array();
        $checkserial = ItemFileEntry::get();

        foreach ($checkserial as $row) {
            $check[] = $row->serialNumber;
        }

        $serialNumber = SerialnumberDetail::where('clientId', $client)
            ->where('deviceId', $device['id'])
            ->whereNotIn('serialNumber', $check)
            ->get();

        $data = $serialNumber;

        $html = "<select name ='serialNumber[]' type = 'text' class='js-example-basic-multiple2 repbox-input serialNumber' id='serialNumber' data-id='" . $request->get('id') . "'><option value=''>Select Serial Number</option>";

        foreach ($serialNumber as $row) {
            $html .= "<option value='" . $row->serialNumber . "'>" . $row->serialNumber . "</option>";
        }

        $html .= "</select>";

        if (count($data)) {
            return [
                'value' => $html,
                'status' => TRUE,
            ];
        } else {
            return [
                'value' => 'No result Found',
                'status' => FALSE,
            ];
        }

    }

    public function serialnumbers(Request $request) {

        $supplyItem = $request->get('supplyItem');
        $model = $request->get('manufacturepart');
        $client = $request->get('hospital');
        $serialNumber = $request->get('serialNumber');
        $purchase = $request->get('purchase');
        $dataid = $request->get('dataid');

        $data1 = array();

        for ($i = 0; $i < count($supplyItem); $i++) {

            if ($purchase[$i] == 'Bulk') {

                $device = device::where('device_name', $supplyItem[$i])->where('model_name', $model[$i])->first();

                $check = array();
                $checkserial = ItemFileEntry::get();

                foreach ($checkserial as $row) {
                    $check[] = $row->serialNumber;
                }

                $serialNumbers = SerialnumberDetail::where('clientId', $client)->where('deviceId', $device['id'])
                    ->whereNotIn('serialNumber', $check)->get();

                $data = $serialNumbers;

                $html = "<select name ='serialNumber[]' class='repbox-input serialNumber' id='serialNumber' data-id='" . $dataid[$i] . "'><option value=''>Select Serial Number</option>";

                $html .= "<option value='" . $serialNumber[$i] . "' SELECTED>" . $serialNumber[$i] . "</option>";
                if (!empty($data)) {

                    foreach ($data as $row) {
                        $html .= "<option value='" . $row->serialNumber . "'>" . $row->serialNumber . "</option>";
                    }
                }

                $html .= "</select>";
            } else {
                $html = "<input type='text' name='serialNumber[]' class='repbox-input serialNumber' value='" . $serialNumber[$i] . "' placeholder='Serial Number' id='serialNumber' data-id='" . $dataid[$i] . "'>";
            }

            $data1[] = array('data' => $html, 'dataid' => $dataid[$i], 'serial' => $serialNumber[$i], 'purchase' => $purchase[$i]);
        }

        if (count($data1)) {
            return [
                'value' => $data1,
                'status' => TRUE,
            ];
        } else {
            return [
                'value' => 'No result Found',
                'status' => FALSE,
            ];
        }

    }
    /*Get Serial Numbers from Device End*/

    /*Check Serial number check is bulk or not start*/
    public function checkserial(Request $request) {
        $serialnumber = $request->get('serialnumber');

        $status = "fail";

        $checkserial = SerialnumberDetail::where('serialNumber', $serialnumber)->first();
        if (!empty($checkserial)) {
            $status = "success";
        }

        $data = $status;

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
    /*Check Serial number check is bulk or not End*/

    /***/
    /*Get Discount and Price Using Serial number * 03/11/2017 10:45 A.M.*/
    public function getdiscount(Request $request) {

        $serialnumber = $request->get('serialnumber');
        $value = $request->get('value');

        $getData = SerialnumberDetail::where('serialNumber', $serialnumber)->first();
        $data = array();
        $data['discount'] = $getData['discount'];

        if ($value == 'Swap In') {

            $data['price'] = client_price::where('device_id', $getData['deviceId'])->where('client_name', $getData['clientId'])->value('system_cost');
        } else if ($value == 'Swap Out') {

            $data['price'] = client_price::where('device_id', $getData['deviceId'])->where('client_name', $getData['clientId'])->value('unit_cost');
        }

        $discount = $data['price'] * $data['discount'] / 100;
        $data['total'] = $data['price'] - $discount;

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

    /***/

    /**
     *New Device Form
     */
    public function addnewdevice() {
        $project = ['' => 'Project Name'] + project::where('is_delete', '0')->pluck('project_name', 'project_name')->all();

        return view('pages.repcasetracker.newdevice.add', compact('project'));
    }

    public function getcategoryName(Request $request) {

        $projectName = $request->get('projectid');

        $projectId = project::where('project_name', $projectName)->value('id');

        $getcategory = category::where('is_delete', '=', 0)->where('project_name', '=', $projectId)->get();
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

    /**
     * Store New Device Request
     * @param Request $request
     */

    public function storeRequest(Request $request) {

        $rules = array(
            'projectName' => 'required',
            'categoryName' => 'required',
            'deviceName' => 'required',
            'message' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['userId'] = Auth::user()->id;

        $data['categoryName'] = category::where('id', $request->get('categoryName'))->value('category_name');

        $store = new DeviceRequest();
        $store->fill($data);
        if ($store->save()) {

            $title = "New Device Request In Neptune-PPA";

            $datas = array(
                'title' => $title,
                'to' => 'punit@micrasolution.com',
//                'to' => 'admin@neptuneppa.com',
                'projectName' => $data['projectName'],
                'categoryName' => $data['categoryName'],
                'deviceName' => $data['deviceName'],
                'messages' => $data['message'],
            );

            $mail = Mail::send('emails.requestmail', $datas, function ($message) use ($datas) {

                $message->from('admin@neptuneppa.com', 'Neptune-PPA')->subject($datas['title']);

                $message->to($datas['to']);
                $admins = User::where('roll', '1')->where('status', 'Enabled')->select('email')->get();

                if (count($admins) > 0) {
                    foreach ($admins as $cc) {
                        if ($cc != "") {
                            $message->cc($cc->email);
                        }
                    }
                }
//            $message->cc('punit@micrasolution.com');
            });

            return Redirect::to('admin/repcasetracker');
        }

    }

    /**
     * Get Physician Email ID
     */
    public function getphyemail(Request $request) {

        $data = ItemfileDetails::where('doctors', $request['physician'])->where('email', '!=', '')->select('email')->distinct('email')->get();

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

    /*Update CaseId In repcase Table Migrate*/
    public function casemigration() {
        $main = ItemFileMain::orderBy('id', 'ASC')->get();
        $caseId = 1000;

        foreach ($main as $row) {
            $up['repcaseID'] = $caseId;

            $upcase = ItemFileMain::where('id', $row->id)->update($up);

            $casede = ItemFileEntry::where('itemMainId', $row->id)->update($up);

            $caseId++;
        }
    }

}
