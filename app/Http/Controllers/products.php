<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\device;
use App\order;
use Illuminate\Support\Facades\Input;
use Auth;
use Illuminate\Support\Facades\Redirect;
use App\User;
use Mail;
use Cookie;
use App\device_custom_field;
use App\clients;
use Illuminate\Support\Facades\DB;
use App\category;
use App\client_price;
use Session;
use App\Devicefeatures;
use App\Clientcustomfeatures;
use Carbon\Carbon;
use App\customContact;
use App\Survey;
use App\SurveyAnswer;
use App\userClients;
use App\SerialnumberDetail;
use App\ItemFileEntry;
use App\ItemFileMain;
use App\physciansPreference;
use App\physciansPreferenceAnswer;

/*Mail Box Models*/
use App\MailTo;
use App\MailList;



class products extends Controller
{

    public function newdevice($id, Request $request)
    {
        $categoryid = $id;
        // $user_organization = Auth::user()->organization;


        /*get selected clientdetails*/
        $clientdetails = session('details');
        $clients = $clientdetails['clients'];

        $clientname = clients::where('id', '=', $clients)->value('client_name');
        $entry_levels = device::leftjoin('client_price', 'client_price.device_id', '=', 'device.id')
            ->leftjoin('device_features', 'device_features.device_id', '=', 'device.id')
            ->join('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
            ->select('device.id', 'device.device_name', 'device.model_name', 'device.device_image', 'device.longevity', 'device.shock', 'device.size', 'device.research', 'device.website_page as site_info', 'device.url', 'device.overall_value', 'device_features.longevity_check', 'device_features.shock_check', 'device_features.size_check', 'device_features.research_check', 'device_features.siteinfo_check', 'device_features.overall_value_check', 'client_price.device_id', 'client_price.unit_cost', 'client_price.bulk_unit_cost', 'client_price.bulk_unit_cost_check', 'client_price.bulk', 'client_price.bulk_check', 'client_price.cco_discount', 'client_price.cco_discount_check', 'client_price.unit_rep_cost', 'client_price.unit_rep_cost_check', 'client_price.unit_repless_discount', 'client_price.unit_repless_discount_check', 'client_price.system_cost', 'client_price.system_cost_check', 'client_price.bulk_system_cost', 'client_price.bulk_system_cost', 'client_price.bulk_system_cost_check', 'client_price.system_repless_cost', 'client_price.system_repless_cost_check', 'client_price.system_repless_discount', 'client_price.system_repless_discount_check', 'client_price.reimbursement', 'client_price.reimbursement_check',
                'client_price.system_bulk', 'client_price.system_bulk_check', 'client_price.order_email', 'manufacturers.manufacturer_logo', 'client_price.unit_cost_highlight', 'client_price.bulk_highlight', 'client_price.cco_highlight', 'client_price.cco_discount_highlight', 'client_price.unit_repless_highlight', 'client_price.unit_repless_discount_highlight', 'client_price.system_cost_highlight', 'client_price.system_bulk_highlight', 'client_price.system_repless_highlight', 'client_price.system_repless_discount_highlight', 'client_price.reimbursement_highlight', 'device_features.longevity_highlight', 'device_features.shock_highlight', 'device_features.size_highlight', 'device_features.research_highlight', 'device_features.siteinfo_highlight', 'device_features.overall_value_highlight')
            ->where('client_price.client_name', '=', $clients)
            ->where('device_features.client_name', '=', $clients)
            ->where('device.category_name', '=', $id)
            ->where('device.level_name', '=', 'Entry Level')
            ->where('device.is_delete', '=', 0)
            ->where('device.status', '=', 'Enabled')
            ->where('client_price.system_cost_check', '=', 'True')
            ->where('client_price.is_delete', '=', 0)
            ->get();

        $productid = [];
        $exclusivecheck = [];
        $sizecheck = [];
        $longevitycheck = [];
        $shockcheck = [];
        $bulkcheck = [];
        $siteinfocheck = [];
        $researchcheck = [];
        $replessdiscountcheck = [];
        $replesscostcheck = [];

        foreach ($entry_levels as $entry_level) {


            if ($entry_level->shock != "") {
                $entry_level->shock = explode('/', $entry_level->shock);
                $entry_level->shock[0] == "" ? "0" : $entry_level->shock[0];
                $entry_level->shock[1] == "" ? "0" : $entry_level->shock[1];
            }

            if ($entry_level->size != "") {
                $entry_level->size = explode('/', $entry_level->size);
                $entry_level->size[0] == "" ? "0" : $entry_level->size[0];
                $entry_level->size[1] == "" ? "0" : $entry_level->size[1];
            }

            $bulk = $entry_level->system_bulk;

            $entry_level->remain_bulk = $bulk;

            $deviceid = $entry_level->id;
            $entry_level->custom_fields = device_custom_field::leftJoin('client_custom_field', 'client_custom_field.c_id', '=', 'device_custom_field.id')
                ->select('device_custom_field.id', 'device_custom_field.field_name', 'device_custom_field.field_value', 'client_custom_field.field_check', 'client_custom_field.fileld_highlight')
                ->where('client_custom_field.device_id', '=', $deviceid)
                ->where('client_custom_field.client_name', '=', $clients)->get();


            $system_cost = $entry_level->system_cost;

            if ($entry_level->bulk_system_cost_check == "True" && $entry_level->system_bulk_check == "True" && $bulk != 0) {

                $system_cost -= ($system_cost * $entry_level->bulk_system_cost) / 100;
                $entry_level->system_cost = $system_cost;
            }


            $entry_level->repless_cost = "-";

            if ($entry_level->system_repless_discount_check == "True") {
                $system_cost -= ($system_cost * $entry_level->system_repless_discount) / 100;
                $entry_level->repless_cost = $system_cost;
            }

            if ($entry_level->system_repless_cost_check == "True") {
                $system_cost -= $entry_level->system_repless_cost;
                $entry_level->repless_cost = $system_cost;
            }


            $replessdiscountcheck[] = $entry_level->system_repless_discount_check;
            $replesscostcheck[] = $entry_level->system_repless_cost_check;
            $exclusivecheck[] = $entry_level->exclusive_check;
            $sizecheck[] = $entry_level->size_check;
            $longevitycheck[] = $entry_level->longevity_check;
            $shockcheck[] = $entry_level->shock_check;
            $bulkcheck[] = $entry_level->system_bulk_check;
            $siteinfocheck[] = $entry_level->siteinfo_check;
            $researchcheck[] = $entry_level->research_check;


            $productid[] = $entry_level->id;

            /*CCo Value Check*/
            $entry_level['cco_check_hightlight'] = "False";

            if ($entry_level->cco_discount_highlight == "True") {
                $entry_level['cco_check_hightlight'] = "True";
            } else if ($entry_level->cco_highlight == "True") {
                $entry_level['cco_check_hightlight'] = "True";
            }

            /*Unit Repless Check*/
            $entry_level['unitrepless_hightlight'] = "False";

            if ($entry_level->unit_repless_highlight == "True") {
                $entry_level['unitrepless_hightlight'] = "True";
            } else if ($entry_level->unit_repless_discount_highlight == "True") {
                $entry_level['unitrepless_hightlight'] = "True";
            }

            /*System Repless Check*/

            $entry_level['systemrepless_hightlight'] = "False";

            if ($entry_level->system_repless_highlight == "True") {
                $entry_level['systemrepless_hightlight'] = "True";
            } else if ($entry_level->system_repless_discount_highlight == "True") {
                $entry_level['systemrepless_hightlight'] = "True";
            }
        }
        // exit();


        $entry_custom_fields = device_custom_field::whereIn('device_id', $productid)
            ->get();


        $replessdiscount_option = "False";
        $replesscost_option = "False";
        $exclusive_option = "False";
        $longevity_option = "False";
        $shock_option = "False";
        $siteinfo_option = "False";
        $size_option = "False";
        $bulk_option = "False";
        $research_option = "False";


        if ((count(array_unique($replessdiscountcheck)) == 1 && end($replessdiscountcheck) == "True") || count(array_unique($replessdiscountcheck)) > 1) {
            $replessdiscount_option = "True";

        }

        if ((count(array_unique($replesscostcheck)) == 1 && end($replesscostcheck) == "True") || count(array_unique($replesscostcheck)) > 1) {

            $replesscost_option = "True";
        }

        if ((count(array_unique($sizecheck)) == 1 && end($sizecheck) == "True") || count(array_unique($sizecheck)) > 1) {
            $size_option = "True";


        }

        if ((count(array_unique($exclusivecheck)) == 1 && end($exclusivecheck) == "True") || count(array_unique($exclusivecheck)) > 1) {
            $exclusive_option = "True";
        }

        if ((count(array_unique($longevitycheck)) == 1 && end($longevitycheck) == "True") || count(array_unique($longevitycheck)) > 1) {
            $longevity_option = "True";

        }

        if ((count(array_unique($shockcheck)) == 1 && end($shockcheck) == "True") || count(array_unique($shockcheck)) > 1) {
            $shock_option = "True";
        }

        if ((count(array_unique($bulkcheck)) == 1 && end($bulkcheck) == "True") || count(array_unique($bulkcheck)) > 1) {
            $bulk_option = "True";
        }

        if ((count(array_unique($siteinfocheck)) == 1 && end($siteinfocheck) == "True") || count(array_unique($siteinfocheck)) > 1) {
            $siteinfo_option = "True";
        }

        if ((count(array_unique($researchcheck)) == 1 && end($researchcheck) == "True") || count(array_unique($researchcheck)) > 1) {
            $research_option = "True";
        }


        $advance_levels = device::join('client_price', 'client_price.device_id', '=', 'device.id')
            ->leftjoin('device_features', 'device_features.device_id', '=', 'device.id')
            ->join('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
            ->select('device.id', 'device.device_name', 'device.model_name', 'device.device_image', 'device.longevity', 'device.shock', 'device.size', 'device.research', 'device.website_page as site_info', 'device.url', 'device.overall_value', 'device_features.longevity_check', 'device_features.shock_check', 'device_features.size_check', 'device_features.research_check', 'device_features.siteinfo_check', 'device_features.overall_value_check', 'client_price.device_id', 'client_price.unit_cost', 'client_price.bulk_unit_cost', 'client_price.bulk_unit_cost_check', 'client_price.bulk', 'client_price.bulk_check', 'client_price.cco_discount', 'client_price.cco_discount_check', 'client_price.unit_rep_cost', 'client_price.unit_rep_cost_check', 'client_price.unit_repless_discount', 'client_price.unit_repless_discount_check', 'client_price.system_cost', 'client_price.system_cost_check', 'client_price.bulk_system_cost', 'client_price.bulk_system_cost', 'client_price.bulk_system_cost_check', 'client_price.system_repless_cost', 'client_price.system_repless_cost_check', 'client_price.system_repless_discount', 'client_price.system_repless_discount_check', 'client_price.reimbursement', 'client_price.reimbursement_check',
                'client_price.system_bulk', 'client_price.system_bulk_check', 'client_price.order_email', 'manufacturers.manufacturer_logo', 'client_price.unit_cost_highlight', 'client_price.bulk_highlight', 'client_price.cco_highlight', 'client_price.cco_discount_highlight', 'client_price.unit_repless_highlight', 'client_price.unit_repless_discount_highlight', 'client_price.system_cost_highlight', 'client_price.system_bulk_highlight', 'client_price.system_repless_highlight', 'client_price.system_repless_discount_highlight', 'client_price.reimbursement_highlight', 'device_features.longevity_highlight', 'device_features.shock_highlight', 'device_features.size_highlight', 'device_features.research_highlight', 'device_features.siteinfo_highlight', 'device_features.overall_value_highlight')
            ->where('client_price.client_name', '=', $clients)
            ->where('device_features.client_name', '=', $clients)
            ->where('device.category_name', '=', $id)
            ->where('device.level_name', '=', 'Advanced Level')
            ->where('device.is_delete', '=', 0)
            ->where('device.status', '=', 'Enabled')
            ->where('client_price.system_cost_check', '=', 'True')
            ->where('client_price.is_delete', '=', 0)
            ->get();
        $advance_productid = [];
        $advanceexclusivecheck = [];
        $advancesizecheck = [];
        $advancelongevitycheck = [];
        $advanceshockcheck = [];
        $advancebulkcheck = [];
        $advancesiteinfocheck = [];
        $advancereplessdiscountcheck = [];
        $advancereplesscostcheck = [];
        $advanceresearchcheck = [];

        foreach ($advance_levels as $advance_level) {

            if ($advance_level->shock != "") {
                $advance_level->shock = explode('/', $advance_level->shock);
                $advance_level->shock[0] == "" ? "0" : $advance_level->shock[0];
                $advance_level->shock[1] == "" ? "0" : $advance_level->shock[1];
            }


            if ($advance_level->size != "") {
                $advance_level->size = explode('/', $advance_level->size);
                $advance_level->size[0] == "" ? "0" : $advance_level->size[0];
                $advance_level->size[1] == "" ? "0" : $advance_level->size[1];
            }


            $bulk = $advance_level->system_bulk;
            $advance_level->remain_bulk = $bulk;
            $deviceid = $advance_level->id;
            $advance_level->custom_fields = device_custom_field::leftJoin('client_custom_field', 'client_custom_field.c_id', '=', 'device_custom_field.id')
                ->select('device_custom_field.id', 'device_custom_field.field_name', 'device_custom_field.field_value', 'client_custom_field.field_check', 'client_custom_field.fileld_highlight')
                ->where('client_custom_field.device_id', '=', $deviceid)
                ->where('client_custom_field.client_name', '=', $clients)->get();

            $system_cost = $advance_level->system_cost;

            if ($advance_level->bulk_system_cost_check == "True" && $advance_level->system_bulk_check == "True" && $bulk != 0) {

                $system_cost -= ($system_cost * $advance_level->bulk_system_cost) / 100;
                $advance_level->system_cost = $system_cost;
            }


            $advance_level->repless_cost = "-";

            if ($advance_level->system_repless_discount_check == "True") {

                $system_cost -= ($system_cost * $advance_level->system_repless_discount) / 100;
                $advance_level->repless_cost = $system_cost;
            }

            if ($advance_level->system_repless_cost_check == "True") {
                $system_cost -= $advance_level->system_repless_cost;
                $advance_level->repless_cost = $system_cost;
            }

            $advancereplessdiscountcheck[] = $advance_level->system_repless_discount_check;
            $advancereplesscostcheck[] = $advance_level->system_repless_cost_check;
            $advanceexclusivecheck[] = $advance_level->exclusive_check;
            $advancesizecheck[] = $advance_level->size_check;
            $advancelongevitycheck[] = $advance_level->longevity_check;
            $advanceshockcheck[] = $advance_level->shock_check;
            $advancebulkcheck[] = $advance_level->system_bulk_check;
            $advancesiteinfocheck[] = $advance_level->siteinfo_check;
            $advanceresearchcheck[] = $advance_level->research_check;

            $advance_productid[] = $advance_level->id;

            /*CCo Value Check*/
            $advance_level['cco_check_hightlight'] = "False";

            if ($advance_level->cco_discount_highlight == "True") {
                $advance_level['cco_check_hightlight'] = "True";
            } else if ($advance_level->cco_highlight == "True") {
                $advance_level['cco_check_hightlight'] = "True";
            }

            /*Unit Repless Check*/
            $advance_level['unitrepless_hightlight'] = "False";

            if ($advance_level->unit_repless_highlight == "True") {
                $advance_level['unitrepless_hightlight'] = "True";
            } else if ($advance_level->unit_repless_discount_highlight == "True") {
                $advance_level['unitrepless_hightlight'] = "True";
            }

            /*System Repless Check*/

            $advance_level['systemrepless_hightlight'] = "False";

            if ($advance_level->system_repless_highlight == "True") {
                $advance_level['systemrepless_hightlight'] = "True";
            } else if ($advance_level->system_repless_discount_highlight == "True") {
                $advance_level['systemrepless_hightlight'] = "True";
            }
        }


        $advance_custom_fields = device_custom_field::whereIn('device_id', $advance_productid)
            ->get();


        $advance_replessdiscount_option = "False";
        $advance_replesscost_option = "False";
        $advance_exclusive_option = "False";
        $advance_longevity_option = "False";
        $advance_shock_option = "False";
        $advance_siteinfo_option = "False";
        $advance_size_option = "False";
        $advance_bulk_option = "False";
        $advance_research_option = "False";


        if ((count(array_unique($advancereplessdiscountcheck)) == 1 && end($advancereplessdiscountcheck) == "True") || count(array_unique($advancereplessdiscountcheck)) > 1) {
            $advance_replessdiscount_option = "True";

        }

        if ((count(array_unique($advancereplesscostcheck)) == 1 && end($advancereplesscostcheck) == "True") || count(array_unique($advancereplesscostcheck)) > 1) {

            $advance_replesscost_option = "True";
        }

        if (count(array_unique($advancesizecheck)) == 1 && end($advancesizecheck) == "True" || count(array_unique($advancesizecheck)) > 1) {
            $advance_size_option = "True";
        }

        if (count(array_unique($advanceexclusivecheck)) == 1 && end($advanceexclusivecheck) == "True" || count(array_unique($advanceexclusivecheck)) > 1) {
            $advance_exclusive_option = "True";
        }


        if (count(array_unique($advancelongevitycheck)) == 1 && end($advancelongevitycheck) == "True" || count(array_unique($advancelongevitycheck)) > 1) {
            $advance_longevity_option = "True";
        }

        if (count(array_unique($advanceshockcheck)) == 1 && end($advanceshockcheck) == "True" || count(array_unique($advanceshockcheck)) > 1) {
            $advance_shock_option = "True";
        }


        if (count(array_unique($advancebulkcheck)) == 1 && end($advancebulkcheck) == "True" || count(array_unique($advancebulkcheck)) > 1) {
            $advance_bulk_option = "True";
        }


        if (count(array_unique($advancesiteinfocheck)) == 1 && end($advancesiteinfocheck) == "True" || count(array_unique($advancesiteinfocheck)) > 1) {
            $advance_siteinfo_option = "True";
        }

        if (count(array_unique($advanceresearchcheck)) == 1 && end($advanceresearchcheck) == "True" || count(array_unique($advanceresearchcheck)) > 1) {
            $advance_research_option = "True";
        }


        $devicetype = "SYSTEM COST";
        $categoryname = category::where('id', '=', $id)->value('category_name');

        $updatedate = client_price::orderby(DB::raw('date(is_updated)'), 'desc')
            ->where('client_name', '=', $clients)
            ->value('is_updated');
        $updatedate = Carbon::parse($updatedate)->format('m/d/Y');

        $dtype['devicetype'] = $devicetype;
        $dtype['updatedate'] = $updatedate;

        $request->session()->put('dtype', $dtype);
//dd($entry_levels);
        if (count($entry_levels) == "0" && count($advance_levels) == "0") {
            if (strpos(url()->previous(), 'changeout') !== false) {
                Session::flash('message', 'There is no device in this category!');
                return Redirect::to('changeout/mainmenu');

            }
            return Redirect::to('changeout/devices/' . $categoryid);

        }

        return view('pages/frontend/products', compact('entry_levels', 'advance_levels', 'clientname', 'categoryname', 'devicetype', 'system_cost', 'repless_cost', 'updatedate', 'size_option', 'exclusive_option', 'bulk_option', 'longevity_option', 'shock_option', 'siteinfo_option', 'advance_size_option', 'advance_exclusive_option', 'advance_bulk_option', 'advance_longevity_option', 'advance_shock_option', 'advance_siteinfo_option', 'entry_custom_fields', 'advance_custom_fields', 'replesscost_option', 'replessdiscount_option', 'advance_replesscost_option', 'advance_replessdiscount_option', 'research_option', 'advance_research_option'));

    }

    public function changeout($id, Request $request)
    {

        $categoryid = $id;
        //$user_organization = Auth::user()->organization;


        /*get selected clientdetails*/
        $clientdetails = session('details');
        $clients = $clientdetails['clients'];

        $clientname = clients::where('id', '=', $clients)->value('client_name');


        $entry_levels = device::join('client_price', 'client_price.device_id', '=', 'device.id')
            ->leftjoin('device_features', 'device_features.device_id', '=', 'device.id')
            ->join('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
            ->select('device.id', 'device.device_name', 'device.model_name', 'device.device_image', 'device.longevity', 'device.shock', 'device.size', 'device.research', 'device.website_page as site_info', 'device.url', 'device.overall_value', 'device_features.longevity_check', 'device_features.shock_check', 'device_features.size_check', 'device_features.research_check', 'device_features.siteinfo_check', 'device_features.overall_value_check', 'client_price.device_id', 'client_price.unit_cost', 'client_price.bulk_unit_cost', 'client_price.bulk_unit_cost_check', 'client_price.bulk', 'client_price.bulk_check', 'client_price.cco_discount', 'client_price.cco_discount_check', 'client_price.unit_rep_cost', 'client_price.unit_rep_cost_check', 'client_price.unit_repless_discount', 'client_price.unit_repless_discount_check', 'client_price.system_cost', 'client_price.system_cost_check', 'client_price.bulk_system_cost', 'client_price.bulk_system_cost', 'client_price.bulk_system_cost_check', 'client_price.system_repless_cost', 'client_price.system_repless_cost_check', 'client_price.system_repless_discount', 'client_price.system_repless_discount_check', 'client_price.reimbursement', 'client_price.reimbursement_check',
                'client_price.system_bulk', 'client_price.system_bulk_check', 'client_price.order_email', 'manufacturers.manufacturer_logo', 'client_price.unit_cost_highlight', 'client_price.bulk_highlight', 'client_price.cco_highlight', 'client_price.cco_discount_highlight', 'client_price.unit_repless_highlight', 'client_price.unit_repless_discount_highlight', 'client_price.system_cost_highlight', 'client_price.system_bulk_highlight', 'client_price.system_repless_highlight', 'client_price.system_repless_discount_highlight', 'client_price.reimbursement_highlight', 'device_features.longevity_highlight', 'device_features.shock_highlight', 'device_features.size_highlight', 'device_features.research_highlight', 'device_features.siteinfo_highlight', 'device_features.overall_value_highlight')
            ->where('client_price.client_name', '=', $clients)
            ->where('device_features.client_name', '=', $clients)
            ->where('device.category_name', '=', $id)
            ->where('device.level_name', '=', 'Entry Level')
            ->where('device.is_delete', '=', 0)
            ->where('device.status', '=', 'Enabled')
            ->where('client_price.unit_cost_check', '=', 'True')
            ->get();


        $productid = [];
        $sizecheck = [];
        $exclusivecheck = [];
        $longevitycheck = [];
        $shockcheck = [];
        $bulkcheck = [];
        $siteinfocheck = [];
        $replessdiscountcheck = [];
        $replesscostcheck = [];
        $ccocostcheck = [];
        $ccodiscountcheck = [];
        $researchcheck = [];

        foreach ($entry_levels as $entry_level) {


            if ($entry_level->shock != "") {
                $entry_level->shock = explode('/', $entry_level->shock);
                $entry_level->shock[0] == "" ? "0" : $entry_level->shock[0];
                $entry_level->shock[0] == "" ? "0" : $entry_level->shock[1];
            }

            if ($entry_level->size != "") {
                $entry_level->size = explode('/', $entry_level->size);
                $entry_level->size[0] == "" ? "0" : $entry_level->size[0];
                $entry_level->size[0] == "" ? "0" : $entry_level->size[1];
            }

            $bulk = $entry_level->bulk;
            $entry_level->remain_bulk = $bulk;
            $deviceid = $entry_level->id;
            $entry_level->custom_fields = device_custom_field::leftJoin('client_custom_field', 'client_custom_field.c_id', '=', 'device_custom_field.id')
                ->select('device_custom_field.id', 'device_custom_field.field_name', 'device_custom_field.field_value', 'client_custom_field.field_check', 'client_custom_field.fileld_highlight')
                ->where('client_custom_field.device_id', '=', $deviceid)
                ->where('client_custom_field.client_name', '=', $clients)->get();

            $unit_cost = $entry_level->unit_cost;

            if ($entry_level->bulk_unit_cost_check == "True" && $entry_level->bulk_check == "True" && $bulk != 0) {

                $unit_cost -= ($entry_level->unit_cost * $entry_level->bulk_unit_cost) / 100;

                $entry_level->unit_cost = $unit_cost;
            }

            if ($entry_level->cco_discount_check == "True") {
                $unit_cost -= ($unit_cost * $entry_level->cco_discount) / 100;
                $entry_level->cco_discount = $unit_cost;
            } else if ($entry_level->cco_check == "True") {
                $unit_cost -= $entry_level->cco;
                $entry_level->cco_discount = $unit_cost;
            } else {
                $entry_level->cco_discount = "-";
            }

            $entry_level->unit_repless_cost = "-";

            if ($entry_level->unit_repless_discount_check == "True") {

                $unit_cost -= ($unit_cost * $entry_level->unit_repless_discount) / 100;
                $entry_level->unit_repless_cost = $unit_cost;
            }

            if ($entry_level->unit_rep_cost_check == "True") {
                $unit_cost -= $entry_level->unit_rep_cost;
                $entry_level->unit_repless_cost = $unit_cost;
            }


            $exclusivecheck[] = $entry_level->exclusive_check;
            $sizecheck[] = $entry_level->size_check;
            $longevitycheck[] = $entry_level->longevity_check;
            $shockcheck[] = $entry_level->shock_check;
            $bulkcheck[] = $entry_level->bulk_check;
            $siteinfocheck[] = $entry_level->siteinfo_check;
            $replessdiscountcheck[] = $entry_level->unit_repless_discount_check;
            $replesscostcheck[] = $entry_level->unit_rep_cost_check;
            $ccocostcheck[] = $entry_level->cco_check;
            $ccodiscountcheck[] = $entry_level->cco_discount_check;
            $researchcheck[] = $entry_level->research_check;

            $productid[] = $entry_level->id;

            /*CCo Value Check*/
            $entry_level['cco_check_hightlight'] = "False";

            if ($entry_level->cco_discount_highlight == "True") {
                $entry_level['cco_check_hightlight'] = "True";
            } else if ($entry_level->cco_highlight == "True") {
                $entry_level['cco_check_hightlight'] = "True";
            }

            /*Unit Repless Check*/
            $entry_level['unitrepless_hightlight'] = "False";

            if ($entry_level->unit_repless_highlight == "True") {
                $entry_level['unitrepless_hightlight'] = "True";
            } else if ($entry_level->unit_repless_discount_highlight == "True") {
                $entry_level['unitrepless_hightlight'] = "True";
            }

            /*System Repless Check*/

            $entry_level['systemrepless_hightlight'] = "False";

            if ($entry_level->system_repless_highlight == "True") {
                $entry_level['systemrepless_hightlight'] = "True";
            } else if ($entry_level->system_repless_discount_highlight == "True") {
                $entry_level['systemrepless_hightlight'] = "True";
            }


        }

        $entry_custom_fields = device_custom_field::whereIn('device_id', $productid)
            ->get();

        $replessdiscount_option = "False";
        $replesscost_option = "False";
        $exclusive_option = "False";
        $longevity_option = "False";
        $shock_option = "False";
        $siteinfo_option = "False";
        $size_option = "False";
        $bulk_option = "False";
        $ccocost_option = "False";
        $ccodiscount_option = "False";
        $research_option = "False";

        if ((count(array_unique($ccodiscountcheck)) == 1 && end($ccodiscountcheck) == "True") || count(array_unique($ccodiscountcheck)) > 1) {
            $ccodiscount_option = "True";

        }

        if ((count(array_unique($ccocostcheck)) == 1 && end($ccocostcheck) == "True") || count(array_unique($ccocostcheck)) > 1) {

            $ccocost_option = "True";
        }


        if ((count(array_unique($replessdiscountcheck)) == 1 && end($replessdiscountcheck) == "True") || count(array_unique($replessdiscountcheck)) > 1) {
            $replessdiscount_option = "True";

        }

        if ((count(array_unique($replesscostcheck)) == 1 && end($replesscostcheck) == "True") || count(array_unique($replesscostcheck)) > 1) {

            $replesscost_option = "True";
        }

        if ((count(array_unique($sizecheck)) == 1 && end($sizecheck) == "True") || count(array_unique($sizecheck)) > 1) {
            $size_option = "True";
        }

        if ((count(array_unique($exclusivecheck)) == 1 && end($exclusivecheck) == "True") || count(array_unique($exclusivecheck)) > 1) {
            $exclusive_option = "True";
        }

        if ((count(array_unique($longevitycheck)) == 1 && end($longevitycheck) == "True") || count(array_unique($longevitycheck)) > 1) {
            $longevity_option = "True";
        }

        if ((count(array_unique($shockcheck)) == 1 && end($shockcheck) == "True") || count(array_unique($shockcheck)) > 1) {
            $shock_option = "True";
        }

        if ((count(array_unique($bulkcheck)) == 1 && end($bulkcheck) == "True") || count(array_unique($bulkcheck)) > 1) {
            $bulk_option = "True";
        }

        if ((count(array_unique($siteinfocheck)) == 1 && end($siteinfocheck) == "True") || count(array_unique($siteinfocheck)) > 1) {
            $siteinfo_option = "True";
        }

        if ((count(array_unique($researchcheck)) == 1 && end($researchcheck) == "True") || count(array_unique($researchcheck)) > 1) {
            $research_option = "True";
        }


        $advance_levels = device::join('client_price', 'client_price.device_id', '=', 'device.id')
            ->leftjoin('device_features', 'device_features.device_id', '=', 'device.id')
            ->join('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
            ->select('device.id', 'device.device_name', 'device.model_name', 'device.device_image', 'device.longevity', 'device.shock', 'device.size', 'device.research', 'device.website_page as site_info', 'device.url', 'device.overall_value', 'device_features.longevity_check', 'device_features.shock_check', 'device_features.size_check', 'device_features.research_check', 'device_features.siteinfo_check', 'device_features.overall_value_check', 'client_price.device_id', 'client_price.unit_cost', 'client_price.bulk_unit_cost', 'client_price.bulk_unit_cost_check', 'client_price.bulk', 'client_price.bulk_check', 'client_price.cco_discount', 'client_price.cco_discount_check', 'client_price.unit_rep_cost', 'client_price.unit_rep_cost_check', 'client_price.unit_repless_discount', 'client_price.unit_repless_discount_check', 'client_price.system_cost', 'client_price.system_cost_check', 'client_price.bulk_system_cost', 'client_price.bulk_system_cost', 'client_price.bulk_system_cost_check', 'client_price.system_repless_cost', 'client_price.system_repless_cost_check', 'client_price.system_repless_discount', 'client_price.system_repless_discount_check', 'client_price.reimbursement', 'client_price.reimbursement_check',
                'client_price.system_bulk', 'client_price.system_bulk_check', 'client_price.order_email', 'manufacturers.manufacturer_logo', 'client_price.unit_cost_highlight', 'client_price.bulk_highlight', 'client_price.cco_highlight', 'client_price.cco_discount_highlight', 'client_price.unit_repless_highlight', 'client_price.unit_repless_discount_highlight', 'client_price.system_cost_highlight', 'client_price.system_bulk_highlight', 'client_price.system_repless_highlight', 'client_price.system_repless_discount_highlight', 'client_price.reimbursement_highlight', 'device_features.longevity_highlight', 'device_features.shock_highlight', 'device_features.size_highlight', 'device_features.research_highlight', 'device_features.siteinfo_highlight', 'device_features.overall_value_highlight')
            ->where('client_price.client_name', '=', $clients)
            ->where('device_features.client_name', '=', $clients)
            ->where('device.category_name', '=', $id)
            ->where('device.level_name', '=', 'Advanced Level')
            ->where('device.is_delete', '=', 0)
            ->where('device.status', '=', 'Enabled')
            ->where('client_price.unit_cost_check', '=', 'True')
            ->get();

        $advance_productid = [];
        $advanceexclusivecheck = [];
        $advancesizecheck = [];
        $advancelongevitycheck = [];
        $advanceshockcheck = [];
        $advancebulkcheck = [];
        $advancesiteinfocheck = [];
        $advancereplesscostcheck = [];
        $advancereplessdiscountcheck = [];
        $advanceccocostcheck = [];
        $advanceccodiscountcheck = [];
        $advanceresearchcheck = [];


        foreach ($advance_levels as $advance_level) {

            if ($advance_level->shock != "") {
                $advance_level->shock = explode('/', $advance_level->shock);
                $advance_level->shock[0] == "" ? "0" : $advance_level->shock[0];
                $advance_level->shock[0] == "" ? "0" : $advance_level->shock[1];
            }

            if ($advance_level->size != "") {
                $advance_level->size = explode('/', $advance_level->size);
                $advance_level->size[0] == "" ? "0" : $advance_level->size[0];
                $advance_level->size[0] == "" ? "0" : $advance_level->size[1];
            }

            $bulk = $advance_level->bulk;

            $advance_level->remain_bulk = $bulk;
            $deviceid = $advance_level->id;
            $advance_level->custom_fields = device_custom_field::leftJoin('client_custom_field', 'client_custom_field.c_id', '=', 'device_custom_field.id')
                ->select('device_custom_field.id', 'device_custom_field.field_name', 'device_custom_field.field_value', 'client_custom_field.field_check', 'client_custom_field.fileld_highlight')
                ->where('client_custom_field.device_id', '=', $deviceid)
                ->where('client_custom_field.client_name', '=', $clients)->get();

            $unit_cost = $advance_level->unit_cost;

            if ($advance_level->bulk_unit_cost_check == "True" && $advance_level->bulk_check == "True" && $bulk != 0) {

                $unit_cost -= ($advance_level->unit_cost * $advance_level->bulk_unit_cost) / 100;

                $advance_level->unit_cost = $unit_cost;
            }

            if ($advance_level->cco_discount_check == "True") {
                $unit_cost -= ($unit_cost * $advance_level->cco_discount) / 100;
                $advance_level->cco_discount = $unit_cost;
            } else if ($advance_level->cco_check == "True") {
                $unit_cost -= $advance_level->cco;
                $advance_level->cco_discount = $unit_cost;
            } else {
                $advance_level->cco_discount = "-";
            }

            $advance_level->unit_repless_cost = "-";

            if ($advance_level->unit_repless_discount_check == "True") {

                $unit_cost -= ($unit_cost * $advance_level->unit_repless_discount) / 100;
                $advance_level->unit_repless_cost = $unit_cost;
            }

            if ($advance_level->unit_rep_cost_check == "True") {
                $unit_cost -= $advance_level->unit_rep_cost;
                $advance_level->unit_repless_cost = $unit_cost;
            }


            $advanceexclusivecheck[] = $advance_level->exclusive_check;
            $advancesizecheck[] = $advance_level->size_check;
            $advancelongevitycheck[] = $advance_level->longevity_check;
            $advanceshockcheck[] = $advance_level->shock_check;
            $advancebulkcheck[] = $advance_level->bulk_check;
            $advancesiteinfocheck[] = $advance_level->siteinfo_check;
            $advancereplessdiscountcheck[] = $advance_level->unit_repless_discount_check;
            $advancereplesscostcheck[] = $advance_level->unit_rep_cost_check;
            $advanceccocostcheck[] = $advance_level->cco_check;
            $advanceccodiscountcheck[] = $advance_level->cco_discount_check;
            $advanceresearchcheck[] = $advance_level->research_check;

            $advance_productid[] = $advance_level->id;

            /*CCo Value Check*/
            $advance_level['cco_check_hightlight'] = "False";

            if ($advance_level->cco_discount_highlight == "True") {
                $advance_level['cco_check_hightlight'] = "True";
            } else if ($advance_level->cco_highlight == "True") {
                $advance_level['cco_check_hightlight'] = "True";
            }

            /*Unit Repless Check*/
            $advance_level['unitrepless_hightlight'] = "False";

            if ($advance_level->unit_repless_highlight == "True") {
                $advance_level['unitrepless_hightlight'] = "True";
            } else if ($advance_level->unit_repless_discount_highlight == "True") {
                $advance_level['unitrepless_hightlight'] = "True";
            }

            /*System Repless Check*/

            $advance_level['systemrepless_hightlight'] = "False";

            if ($advance_level->system_repless_highlight == "True") {
                $advance_level['systemrepless_hightlight'] = "True";
            } else if ($advance_level->system_repless_discount_highlight == "True") {
                $advance_level['systemrepless_hightlight'] = "True";
            }

        }

        $advance_custom_fields = device_custom_field::whereIn('device_id', $advance_productid)->get();

        $advance_ccodiscount_option = "False";
        $advance_ccocost_option = "False";
        $advance_replessdiscount_option = "False";
        $advance_replesscost_option = "False";
        $advance_exclusive_option = "False";
        $advance_longevity_option = "False";
        $advance_shock_option = "False";
        $advance_siteinfo_option = "False";
        $advance_size_option = "False";
        $advance_bulk_option = "False";
        $advance_research_option = "False";


        if ((count(array_unique($advanceccodiscountcheck)) == 1 && end($advanceccodiscountcheck) == "True") || count(array_unique($advanceccodiscountcheck)) > 1) {
            $advance_ccodiscount_option = "True";

        }

        if ((count(array_unique($advanceccocostcheck)) == 1 && end($advanceccocostcheck) == "True") || count(array_unique($advanceccocostcheck)) > 1) {

            $advance_ccocost_option = "True";
        }
        if ((count(array_unique($advancereplessdiscountcheck)) == 1 && end($advancereplessdiscountcheck) == "True") || count(array_unique($advancereplessdiscountcheck)) > 1) {
            $advance_replessdiscount_option = "True";

        }

        if ((count(array_unique($advancereplesscostcheck)) == 1 && end($advancereplesscostcheck) == "True") || count(array_unique($advancereplesscostcheck)) > 1) {

            $advance_replesscost_option = "True";
        }

        if (count(array_unique($advancesizecheck)) == 1 && end($advancesizecheck) == "True" || count(array_unique($advancesizecheck)) > 1) {
            $advance_size_option = "True";
        }

        if (count(array_unique($advanceexclusivecheck)) == 1 && end($advanceexclusivecheck) == "True" || count(array_unique($advanceexclusivecheck)) > 1) {
            $advance_exclusive_option = "True";
        }


        if (count(array_unique($advancelongevitycheck)) == 1 && end($advancelongevitycheck) == "True" || count(array_unique($advancelongevitycheck)) > 1) {
            $advance_longevity_option = "True";
        }

        if (count(array_unique($advanceshockcheck)) == 1 && end($advanceshockcheck) == "True" || count(array_unique($advanceshockcheck)) > 1) {
            $advance_shock_option = "True";
        }


        if (count(array_unique($advancebulkcheck)) == 1 && end($advancebulkcheck) == "True" || count(array_unique($advancebulkcheck)) > 1) {
            $advance_bulk_option = "True";
        }


        if (count(array_unique($advancesiteinfocheck)) == 1 && end($advancesiteinfocheck) == "True" || count(array_unique($advancesiteinfocheck)) > 1) {
            $advance_siteinfo_option = "True";
        }

        if (count(array_unique($advanceresearchcheck)) == 1 && end($advanceresearchcheck) == "True" || count(array_unique($advanceresearchcheck)) > 1) {
            $advance_research_option = "True";
        }


        $devicetype = "UNIT COST";
        $categoryname = category::where('id', '=', $id)->value('category_name');
        $updatedate = client_price::orderby(DB::raw('date(is_updated)'), 'desc')
            ->where('client_name', '=', $clients)
            ->value('is_updated');
        $updatedate = Carbon::parse($updatedate)->format('m/d/Y');

        $dtype['devicetype'] = $devicetype;
        $dtype['updatedate'] = $updatedate;
        $request->session()->put('dtype', $dtype);


        if (count($entry_levels) == "0" && count($advance_levels) == "0") {
            if (strpos(url()->previous(), 'newdevice') !== false) {
                Session::flash('message', 'There is no device in this category!');
                return Redirect::to('newdevice/mainmenu');

            }
            return Redirect::to('newdevice/devices/' . $categoryid);
        }
        return view('pages/frontend/products', compact('entry_levels', 'advance_levels', 'clientname', 'categoryname', 'devicetype', 'unit_cost', 'cco_discount', 'unit_repless_cost', 'updatedate', 'size_option', 'exclusive_option', 'bulk_option', 'longevity_option', 'shock_option', 'siteinfo_option', 'advance_size_option', 'advance_exclusive_option', 'advance_bulk_option', 'advance_longevity_option', 'advance_shock_option', 'advance_siteinfo_option', 'entry_custom_fields', 'advance_custom_fields', 'replesscost_option', 'replessdiscount_option', 'advance_replessdiscount_option', 'advance_replesscost_option', 'advance_ccocost_option', 'advance_ccodiscount_option', 'ccocost_option', 'ccodiscount_option', 'research_option', 'advance_research_option'));

    }

    public function compareproduct()
    {
        $user_organization = Auth::user()->organization;


        /*get selected clientdetails*/
        $clientdetails = session('details');
        $clients = $clientdetails['clients'];

        $clientname = clients::where('id', '=', $clients)->value('client_name');

        $products = Input::get('product_chk');
        $devicetype = Input::get('devicetype');

        $first_product = device::join('client_price', 'client_price.device_id', '=', 'device.id')
            ->leftjoin('device_features', 'device_features.device_id', '=', 'device.id')
            ->join('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
            ->select('device.id', 'device.device_name', 'device.model_name', 'device.device_image', 'device.longevity', 'device.shock', 'device.size', 'device.research', 'device.website_page as site_info', 'device.url', 'device.overall_value', 'device_features.longevity_check', 'device_features.shock_check', 'device_features.size_check', 'device_features.research_check', 'device_features.siteinfo_check', 'device_features.overall_value_check', 'client_price.device_id', 'client_price.unit_cost', 'client_price.bulk_unit_cost', 'client_price.bulk_unit_cost_check', 'client_price.bulk', 'client_price.bulk_check', 'client_price.cco', 'client_price.cco_check', 'client_price.cco_discount', 'client_price.cco_discount_check', 'client_price.unit_rep_cost', 'client_price.unit_rep_cost_check', 'client_price.unit_repless_discount', 'client_price.unit_repless_discount_check', 'client_price.system_cost', 'client_price.system_cost_check', 'client_price.bulk_system_cost', 'client_price.bulk_system_cost', 'client_price.bulk_system_cost_check', 'client_price.system_repless_cost', 'client_price.system_repless_cost_check', 'client_price.system_repless_discount', 'client_price.system_repless_discount_check', 'client_price.reimbursement', 'client_price.reimbursement_check', 'client_price.system_bulk', 'client_price.system_bulk_check', 'client_price.order_email', 'manufacturers.manufacturer_logo', 'client_price.unit_cost_delta_check', 'client_price.cco_discount_delta_check', 'client_price.reimbursement_delta_check', 'client_price.system_cost_delta_check', 'client_price.system_repless_discount_delta_check', 'client_price.unit_repless_discount_delta_check', 'device_features.longevity_delta_check', 'device_features.shock_delta_check', 'device_features.size_delta_check', 'device_features.research_delta_check', 'device_features.site_info_delta_check', 'device_features.overall_value_delta_check', 'cco_delta_check', 'unit_repless_delta_check', 'system_repless_delta_check'
                , 'client_price.unit_cost_highlight', 'client_price.bulk_highlight', 'client_price.cco_highlight', 'client_price.cco_discount_highlight', 'client_price.unit_repless_highlight', 'client_price.unit_repless_discount_highlight', 'client_price.system_cost_highlight', 'client_price.system_bulk_highlight', 'client_price.system_repless_highlight', 'client_price.system_repless_discount_highlight', 'client_price.reimbursement_highlight', 'device_features.longevity_highlight', 'device_features.shock_highlight', 'device_features.size_highlight', 'device_features.research_highlight', 'device_features.siteinfo_highlight', 'device_features.overall_value_highlight')
            ->where('device.id', '=', $products[0])
            ->where('client_price.client_name', '=', $clients)
            ->where('device_features.client_name', '=', $clients)
            ->get();

        foreach ($first_product as $f_product) {


            if ($devicetype == "UNIT COST") {

                $bulk = $f_product->bulk;
                $f_product->remain_bulk = $bulk;


                $deviceid = $f_product->id;
                $f_product->custom_fields = device_custom_field::leftJoin('client_custom_field', 'client_custom_field.c_id', '=', 'device_custom_field.id')
                    ->select('device_custom_field.id', 'device_custom_field.field_name', 'device_custom_field.field_value', 'client_custom_field.field_check', 'client_custom_field.fileld_highlight')
                    ->where('client_custom_field.device_id', '=', $deviceid)
                    ->where('client_custom_field.client_name', '=', $clients)->get();

                $first_unit_cost = $f_product->unit_cost;

                $unit_cost = $f_product->unit_cost;
                if ($f_product->bulk_unit_cost_check == "True" && $f_product->bulk_check == "True" && $bulk != 0) {

                    $unit_cost -= ($f_product->unit_cost * $f_product->bulk_unit_cost) / 100;

                    $f_product->unit_cost = $unit_cost;
                }
                if ($f_product->cco_discount_check == "True") {
                    $unit_cost -= ($unit_cost * $f_product->cco_discount) / 100;

                    $f_product->cco_discount = $unit_cost;
                } else if ($f_product->cco_check == "True") {
                    $unit_cost -= $f_product->cco;
                    $f_product->cco_discount = $unit_cost;
                } else {
                    $f_product->cco_discount = "-";
                }


                if ($f_product->unit_repless_discount_check == "True") {

                    $unit_cost -= ($unit_cost * $f_product->unit_repless_discount) / 100;
                    $f_product->unit_repless_cost = $unit_cost;
                } else if ($f_product->unit_rep_cost_check == "True") {
                    $unit_cost -= $f_product->unit_rep_cost;
                    $f_product->unit_repless_cost = $unit_cost;
                } else {
                    $f_product->unit_repless_cost = '-';
                }
            } else {
                $first_unit_cost = $f_product->sytem_cost;
                $system_cost = $f_product->system_cost;


                $bulk = $f_product->system_bulk;
                $f_product->remain_bulk = $bulk;
                $deviceid = $f_product->id;
                $f_product->custom_fields = device_custom_field::leftJoin('client_custom_field', 'client_custom_field.c_id', '=', 'device_custom_field.id')
                    ->select('device_custom_field.id', 'device_custom_field.field_name', 'device_custom_field.field_value', 'client_custom_field.field_check', 'client_custom_field.fileld_delta_check', 'client_custom_field.fileld_highlight')
                    ->where('client_custom_field.device_id', '=', $deviceid)
                    ->where('client_custom_field.client_name', '=', $clients)->get();

                if ($f_product->bulk_system_cost_check == "True" && $f_product->system_bulk_check == "True" && $bulk != 0) {

                    $system_cost -= ($f_product->system_cost * $f_product->bulk_system_cost) / 100;

                    $f_product->system_cost = $system_cost;
                }
                if ($f_product->system_repless_discount_check == "True") {

                    $system_cost -= ($system_cost * $f_product->system_repless_discount) / 100;
                    $f_product->system_repless_cost = $system_cost;
                } else if ($f_product->system_repless_cost_check == "True") {

                    $system_cost -= $f_product->system_repless_cost;
                    $f_product->system_repless_cost = $system_cost;
                } else {
                    $f_product->system_repless_cost = '-';
                }
            }

            /*CCo Value Check*/
            $f_product['cco_check_hightlight'] = "False";

            if ($f_product->cco_discount_highlight == "True") {
                $f_product['cco_check_hightlight'] = "True";
            } else if ($f_product->cco_highlight == "True") {
                $f_product['cco_check_hightlight'] = "True";
            }

            /*Unit Repless Check*/
            $f_product['unitrepless_hightlight'] = "False";

            if ($f_product->unit_repless_highlight == "True") {
                $f_product['unitrepless_hightlight'] = "True";
            } else if ($f_product->unit_repless_discount_highlight == "True") {
                $f_product['unitrepless_hightlight'] = "True";
            }

            /*System Repless Check*/

            $f_product['systemrepless_hightlight'] = "False";

            if ($f_product->system_repless_highlight == "True") {
                $f_product['systemrepless_hightlight'] = "True";
            } else if ($f_product->system_repless_discount_highlight == "True") {
                $f_product['systemrepless_hightlight'] = "True";
            }


        }


        $second_product = device::join('client_price', 'client_price.device_id', '=', 'device.id')
            ->leftjoin('device_features', 'device_features.device_id', '=', 'device.id')
            ->join('manufacturers', 'manufacturers.id', '=', 'device.manufacturer_name')
            ->select('device.id', 'device.device_name', 'device.model_name', 'device.device_image', 'device.longevity', 'device.shock', 'device.size', 'device.research', 'device.website_page as site_info', 'device.url', 'device.overall_value', 'device_features.longevity_check', 'device_features.shock_check', 'device_features.size_check', 'device_features.research_check', 'device_features.siteinfo_check', 'device_features.overall_value_check', 'client_price.device_id', 'client_price.unit_cost', 'client_price.bulk_unit_cost', 'client_price.bulk_unit_cost_check', 'client_price.bulk', 'client_price.bulk_check', 'client_price.cco_discount', 'client_price.cco_discount_check', 'client_price.cco', 'client_price.cco_check', 'client_price.unit_rep_cost', 'client_price.unit_rep_cost_check', 'client_price.unit_repless_discount', 'client_price.unit_repless_discount_check', 'client_price.system_cost', 'client_price.system_cost_check', 'client_price.bulk_system_cost', 'client_price.bulk_system_cost', 'client_price.bulk_system_cost_check', 'client_price.system_repless_cost', 'client_price.system_repless_cost_check', 'client_price.system_repless_discount', 'client_price.system_repless_discount_check', 'client_price.reimbursement', 'client_price.reimbursement_check', 'client_price.system_bulk', 'client_price.system_bulk_check', 'client_price.order_email', 'manufacturers.manufacturer_logo', 'client_price.unit_cost_delta_check', 'client_price.cco_discount_delta_check', 'client_price.reimbursement_delta_check', 'client_price.system_cost_delta_check', 'client_price.system_repless_discount_delta_check', 'client_price.unit_repless_discount_delta_check', 'device_features.longevity_delta_check', 'device_features.shock_delta_check', 'device_features.size_delta_check', 'device_features.research_delta_check', 'device_features.site_info_delta_check', 'device_features.overall_value_delta_check', 'cco_delta_check', 'unit_repless_delta_check', 'system_repless_delta_check'
                , 'client_price.unit_cost_highlight', 'client_price.bulk_highlight', 'client_price.cco_highlight', 'client_price.cco_discount_highlight', 'client_price.unit_repless_highlight', 'client_price.unit_repless_discount_highlight', 'client_price.system_cost_highlight', 'client_price.system_bulk_highlight', 'client_price.system_repless_highlight', 'client_price.system_repless_discount_highlight', 'client_price.reimbursement_highlight', 'device_features.longevity_highlight', 'device_features.shock_highlight', 'device_features.size_highlight', 'device_features.research_highlight', 'device_features.siteinfo_highlight', 'device_features.overall_value_highlight')
            ->where('device.id', '=', $products[1])
            ->where('client_price.client_name', '=', $clients)
            ->where('device_features.client_name', '=', $clients)
            ->get();

        foreach ($second_product as $s_product) {
            $deviceid = $s_product->id;
            $s_product->scustom_fields = device_custom_field::leftJoin('client_custom_field', 'client_custom_field.c_id', '=', 'device_custom_field.id')
                ->select('device_custom_field.id', 'device_custom_field.field_name', 'device_custom_field.field_value', 'client_custom_field.field_check', 'client_custom_field.fileld_delta_check', 'client_custom_field.fileld_highlight')
                ->where('client_custom_field.device_id', '=', $deviceid)
                ->where('client_custom_field.client_name', '=', $clients)->get();

            $categoryname = category::where('id', '=', $s_product->category_name)->value('category_name');


            if ($devicetype == "UNIT COST") {


                $bulk = $s_product->bulk;
                $s_product->remain_bulk = $bulk;

                $second_unit_cost = $s_product->unit_cost;
                $deviceid = $s_product->id;
                $s_product->custom_fields = device_custom_field::where('device_id', $deviceid)->get();

                $unit_cost = $s_product->unit_cost;
                if ($s_product->bulk_unit_cost_check == "True" && $s_product->bulk_check == "True" && $bulk != 0) {

                    $unit_cost -= ($s_product->unit_cost * $s_product->bulk_unit_cost) / 100;

                    $s_product->unit_cost = $unit_cost;
                }

                if ($s_product->cco_discount_check == "True") {
                    $unit_cost -= ($unit_cost * $s_product->cco_discount) / 100;

                    $s_product->cco_discount = $unit_cost;
                } else if ($s_product->cco_check == "True") {

                    $unit_cost -= $s_product->cco;
                    $s_product->cco_discount = $unit_cost;

                } else {
                    $s_product->cco_discount = "-";
                }


                if ($s_product->unit_repless_discount_check == "True") {

                    $unit_cost -= ($unit_cost * $s_product->unit_repless_discount) / 100;
                    $s_product->unit_repless_cost = $unit_cost;
                } else if ($s_product->unit_rep_cost_check == "True") {
                    $unit_cost -= $s_product->unit_rep_cost;
                    $s_product->unit_repless_cost = $unit_cost;
                } else {
                    $s_product->unit_repless_cost = '-';
                }
            } else {

                $second_unit_cost = $s_product->system_cost;
                $system_cost = $s_product->system_cost;


                $bulk = $s_product->system_bulk;
                $s_product->remain_bulk = $bulk;
                $deviceid = $s_product->id;

                if ($s_product->bulk_system_cost_check == "True" && $s_product->system_bulk_check == "True" && $bulk != 0) {

                    $system_cost -= ($s_product->system_cost * $s_product->bulk_system_cost) / 100;

                    $s_product->system_cost = $system_cost;
                }

                if ($s_product->system_repless_discount_check == "True") {

                    $system_cost -= ($system_cost * $s_product->system_repless_discount) / 100;
                    $s_product->system_repless_cost = $system_cost;
                } else if ($s_product->system_repless_cost_check == "True") {
                    $system_cost -= $s_product->system_repless_cost;
                    $s_product->system_repless_cost = $system_cost;
                } else {
                    $s_product->system_repless_cost = '-';
                }
            }

            /*CCo Value Check*/
            $s_product['cco_check_hightlight'] = "False";

            if ($s_product->cco_discount_highlight == "True") {
                $s_product['cco_check_hightlight'] = "True";
            } else if ($s_product->cco_highlight == "True") {
                $s_product['cco_check_hightlight'] = "True";
            }

            /*Unit Repless Check*/
            $s_product['unitrepless_hightlight'] = "False";

            if ($s_product->unit_repless_highlight == "True") {
                $s_product['unitrepless_hightlight'] = "True";
            } else if ($s_product->unit_repless_discount_highlight == "True") {
                $s_product['unitrepless_hightlight'] = "True";
            }

            /*System Repless Check*/

            $s_product['systemrepless_hightlight'] = "False";

            if ($s_product->system_repless_highlight == "True") {
                $s_product['systemrepless_hightlight'] = "True";
            } else if ($s_product->system_repless_discount_highlight == "True") {
                $s_product['systemrepless_hightlight'] = "True";
            }

        }


        $first_cost = $devicetype == "UNIT COST" ? $f_product->unit_cost : $f_product->system_cost;
        $second_cost = $devicetype == "UNIT COST" ? $s_product->unit_cost : $s_product->system_cost;

        $check_unit_cost = min($first_cost, $second_cost);
        $first_cost = $check_unit_cost == $first_cost ? 'True' : 'False';


        $productid = $first_cost == 'True' ? $f_product->id : $s_product->id;
        $productname = $first_cost == 'True' ? $f_product->device_name : $s_product->device_name;

        $productimage = $first_cost == 'True' ? $f_product->device_image : $s_product->device_image;

        $f_repless_cost = $devicetype == "UNIT COST" ? $f_product->unit_repless_cost : $f_product->system_repless_cost;

        $s_repless_cost = $devicetype == "UNIT COST" ? $s_product->unit_repless_cost : $s_product->system_repless_cost;


        if ($first_cost == "True") {

            $unit_cost_delta_check = "False";
            $cco_discount_delta_check = "False";
            $system_cost_delta_check = "False";
            $reimbursement_delta_check = "False";
            $unit_repless_delta_check = "False";
            $system_repless_delta_check = "False";
            $longevity_diff = "";
            $research_delta_check = "False";
            $site_info_delta_check = "False";
            $overall_value_delta_check = "False";


            if ($s_product->unit_cost_delta_check == "True" && $f_product->unit_cost_delta_check == "True") {
                $unit_cost_delta_check = "True";
            }

            if ($s_product->system_cost_delta_check == "True" && $f_product->system_cost_delta_check == "True") {
                $system_cost_delta_check = "True";
            }

            if ($s_product->reimbursement_delta_check == "True" && $f_product->reimbursement_delta_check == "True") {
                $reimbursement_delta_check = "True";
            }

            if ($s_product->research_delta_check == "True" && $f_product->research_delta_check == "True") {
                $research_delta_check = "True";
            }

            if ($s_product->site_info_delta_check == "True" && $f_product->site_info_delta_check == "True") {
                $site_info_delta_check = "True";
            }

            if ($s_product->overall_value_delta_check == "True" && $f_product->overall_value_delta_check == "True") {
                $overall_value_delta_check = "True";
            }


            if ($s_product->cco_discount_delta_check == "True" || $s_product->cco_delta_check == "True" && $f_product->cco_discount_delta_check == "True" || $f_product->cco_delta_check == "True") {
                $cco_discount_delta_check = "True";

            }

            if ($s_product->unit_repless_discount_delta_check == "True" || $s_product->unit_repless_delta_check == "True" && $f_product->unit_repless_discount_delta_check == "True" || $s_product->unit_repless_delta_check == "True") {
                $unit_repless_delta_check = "True";
            }

            if ($s_product->system_repless_discount_delta_check == "True" || $s_product->system_repless_delta_check == "True" && $f_product->system_repless_discount_delta_check == "True" || $s_product->system_repless_delta_check == "True") {
                $system_repless_delta_check = "True";
            }


            /*Second Device Custom Fields*/

            $f_custom_f = array();
            $s_custom_f = array();

            foreach ($s_product->scustom_fields as $s_custom) {

                $s_custom_f[] = $s_custom->field_name;

            }
            foreach ($f_product->custom_fields as $f_custom) {

                $f_custom_f[] = $f_custom->field_name;
            }

            $result = array_intersect($f_custom_f, $s_custom_f);

            $custom_fields_data2 = device_custom_field::leftJoin('client_custom_field', 'client_custom_field.c_id', '=', 'device_custom_field.id')
                ->select('device_custom_field.id', 'device_custom_field.field_name', 'device_custom_field.field_value', 'client_custom_field.field_check', 'client_custom_field.fileld_delta_check', 'client_custom_field.fileld_highlight')
                ->where('client_custom_field.device_id', '=', $s_product->id)
                ->whereIn('device_custom_field.field_name', $result)
                ->where('client_custom_field.client_name', '=', $clients)
                ->where('client_custom_field.field_check', '=', 'True')
                ->where('client_custom_field.fileld_delta_check', '=', 'True')
                ->get();

            $custom_fields_data1 = device_custom_field::leftJoin('client_custom_field', 'client_custom_field.c_id', '=', 'device_custom_field.id')
                ->select('device_custom_field.id', 'device_custom_field.field_name', 'device_custom_field.field_value', 'client_custom_field.field_check', 'client_custom_field.fileld_delta_check', 'client_custom_field.fileld_highlight')
                ->where('client_custom_field.device_id', '=', $f_product->id)
                ->whereIn('device_custom_field.field_name', $result)
                ->where('client_custom_field.client_name', '=', $clients)
                ->where('client_custom_field.field_check', '=', 'True')
                ->where('client_custom_field.fileld_delta_check', '=', 'True')
                ->get();

            $data2 = array();
            foreach ($custom_fields_data2 as $key2) {
                $data2[$key2->field_name] = $key2->field_value;
            }

            $data1 = array();
            foreach ($custom_fields_data1 as $key1) {
                $data1[$key1->field_name] = $key1->field_value;
            }
            $custom_diff = array();

            if (count($data2) > 0 && count($data1) > 0) {

                foreach ($data1 as $key => $value) {

                    if (array_key_exists($key, $data2)) {
                        $difference = $data1[$key];

                        if (is_numeric($data1[$key]) && is_numeric($data2[$key])) {
                            $difference = $data1[$key] - $data2[$key];
                        }


                    }
                    $custom_diff[$key] = $difference;
                }

            }


            $unit_cost_diff = $s_product->unit_cost - $f_product->unit_cost;
            $cco_diff = $s_product->cco_discount - $f_product->cco_discount;
            $system_cost_diff = $s_product->system_cost - $f_product->system_cost;
            $reimbursement_diff = $s_product->reimbursement - $f_product->reimbursement;

            if ($s_product->longevity != "" && $f_product->longevity != "") {
                $longevity_diff = $s_product->longevity - $f_product->longevity;
            }


            $system_repless_cost_diff = $s_product->system_repless_cost - $f_product->system_repless_cost;

            $unit_repless_cost_diff = $s_product->unit_repless_cost - $f_product->unit_repless_cost;

            $repless_cost_diff = $s_repless_cost - $f_repless_cost;

            $shock_diff = 0;
            $ct_diff = 0;
            $size_g_diff = 0;
            $size_cc_diff = 0;

            $f_product->shock = $f_product->shock == "" ? "00/00" : $f_product->shock;
            $s_product->shock = $s_product->shock == "" ? "00/00" : $s_product->shock;

            $shock_ct_f_product = explode('/', $f_product->shock);
            $shock_ct_s_product = explode('/', $s_product->shock);

            $shock_f_product = $shock_ct_f_product[0];
            $ct_f_product = $shock_ct_f_product[1];
            $shock_s_product = $shock_ct_s_product[0];
            $ct_s_product = $shock_ct_s_product[1];
            $shock_diff = $shock_s_product - $shock_f_product;
            $ct_diff = $ct_s_product - $ct_f_product;


            $shock_ct = "True";
            if ($f_product->shock_check != "True" || $s_product->shock_check != "True") {

                $shock_ct = "False";
                // $shock_f_product = $shock_f_product ."J/".$ct_f_product."s";
                // $shock_s_product = $shock_s_product ."J/".$ct_s_product."s";

            }


            $f_product->size = $f_product->size == "" ? "00/00" : $f_product->size;
            $s_product->size = $s_product->size == "" ? "00/00" : $s_product->size;

            $size_f_product = explode('/', $f_product->size);
            $size_s_product = explode('/', $s_product->size);
            $size_g_f_product = $size_f_product[0];
            $size_cc_f_product = $size_f_product[1];
            $size_g_s_product = $size_s_product[0];
            $size_cc_s_product = $size_s_product[1];
            $size_g_diff = $size_g_s_product - $size_g_f_product;
            $size_cc_diff = $size_cc_s_product - $size_cc_f_product;

            $size_diff = $size_g_diff . "g/" . $size_cc_diff . "cc";

            /*07/02/2017*/
            $shock_f_product = "";
            $shock_s_product = "";
            if ($f_product->shock != "") {
                $shock_ct_f_product = explode('/', $f_product->shock);
                $shock_f_product = $shock_ct_f_product[0];
                $ct_f_product = $shock_ct_f_product[1];
                $shock_f_product = $shock_f_product . "J/" . $ct_f_product . "s";
            }

            if ($s_product->shock != "") {
                $shock_ct_s_product = explode('/', $s_product->shock);
                $shock_s_product = $shock_ct_s_product[0];
                $ct_s_product = $shock_ct_s_product[1];
                $shock_s_product = $shock_s_product . "J/" . $ct_s_product . "s";
            }

            $size_f_product = "";
            $size_s_product = "";

            if ($f_product->size != "") {
                $size_f_product = explode('/', $f_product->size);
                $size_g_f_product = $size_f_product[0];
                $size_cc_f_product = $size_f_product[1];
                $size_f_product = $size_g_f_product . "g/" . $size_cc_f_product . "cc";
            }

            if ($s_product->size != "") {
                $size_s_product = explode('/', $s_product->size);
                $size_g_s_product = $size_s_product[0];
                $size_cc_s_product = $size_s_product[1];
                $size_s_product = $size_g_s_product . "g/" . $size_cc_s_product . "cc";

            }

            $research = $f_product->research;
            $siteinfo = $f_product->site_info;
            $overAll = $f_product->overall_value;

        } else {

            $unit_cost_delta_check = "False";
            $cco_discount_delta_check = "False";
            $system_cost_delta_check = "False";
            $reimbursement_delta_check = "False";
            $unit_repless_delta_check = "False";
            $system_repless_delta_check = "False";
            $longevity_diff = "";
            $research_delta_check = "False";
            $site_info_delta_check = "False";
            $overall_value_delta_check = "False";


            // print_r($s_product->unit_cost_delta_check);
            if ($s_product->unit_cost_delta_check == "True" && $f_product->unit_cost_delta_check == "True") {

                $unit_cost_delta_check = "True";
            }

            if ($s_product->system_cost_delta_check == "True" && $f_product->system_cost_delta_check == "True") {
                $system_cost_delta_check = "True";
            }

            if ($s_product->reimbursement_delta_check == "True" && $f_product->reimbursement_delta_check == "True") {
                $reimbursement_delta_check = "True";
            }

            if ($s_product->cco_discount_delta_check == "True" || $s_product->cco_delta_check == "True" && $f_product->cco_discount_delta_check == "True" || $f_product->cco_delta_check == "True") {
                $cco_discount_delta_check = "True";

            }

            if ($s_product->unit_repless_discount_delta_check == "True" || $s_product->unit_repless_delta_check == "True" && $f_product->unit_repless_discount_delta_check == "True" || $s_product->unit_repless_delta_check == "True") {
                $unit_repless_delta_check = "True";
            }

            if ($s_product->system_repless_discount_delta_check == "True" || $s_product->system_repless_delta_check == "True" && $f_product->system_repless_discount_delta_check == "True" || $s_product->system_repless_delta_check == "True") {
                $system_repless_delta_check = "True";
            }

            $f_custom_f = array();
            $s_custom_f = array();

            foreach ($s_product->scustom_fields as $s_custom) {

                $s_custom_f[] = $s_custom->field_name;

            }
            foreach ($f_product->custom_fields as $f_custom) {

                $f_custom_f[] = $f_custom->field_name;
            }

            $result = array_intersect($s_custom_f, $f_custom_f);

            $custom_fields_data2 = device_custom_field::leftJoin('client_custom_field', 'client_custom_field.c_id', '=', 'device_custom_field.id')
                ->select('device_custom_field.id', 'device_custom_field.field_name', 'device_custom_field.field_value', 'client_custom_field.field_check', 'client_custom_field.fileld_delta_check', 'client_custom_field.fileld_highlight')
                ->where('client_custom_field.device_id', '=', $s_product->id)
                ->whereIn('device_custom_field.field_name', $result)
                ->where('client_custom_field.client_name', '=', $clients)
                ->where('client_custom_field.field_check', '=', 'True')
                ->where('client_custom_field.fileld_delta_check', '=', 'True')
                ->get();

            $custom_fields_data1 = device_custom_field::leftJoin('client_custom_field', 'client_custom_field.c_id', '=', 'device_custom_field.id')
                ->select('device_custom_field.id', 'device_custom_field.field_name', 'device_custom_field.field_value', 'client_custom_field.field_check', 'client_custom_field.fileld_delta_check', 'client_custom_field.fileld_highlight')
                ->where('client_custom_field.device_id', '=', $f_product->id)
                ->whereIn('device_custom_field.field_name', $result)
                ->where('client_custom_field.client_name', '=', $clients)
                ->where('client_custom_field.field_check', '=', 'True')
                ->where('client_custom_field.fileld_delta_check', '=', 'True')
                ->get();
            $data2 = array();
            foreach ($custom_fields_data2 as $key2) {
                $data2[$key2->field_name] = $key2->field_value;
            }

            $data1 = array();
            foreach ($custom_fields_data1 as $key1) {
                $data1[$key1->field_name] = $key1->field_value;
            }
            $custom_diff = array();

            if (count($data2) > 0 && count($data1) > 0) {

                foreach ($data2 as $key => $value) {

                    if (array_key_exists($key, $data1)) {
                        $difference = $data2[$key];
                        if (is_numeric($data1[$key]) && is_numeric($data2[$key])) {
                            $difference = $data2[$key] - $data1[$key];
                        }


                    }

                    $custom_diff[$key] = $difference;
                }

            }


            $unit_cost_diff = $f_product->unit_cost - $s_product->unit_cost;
            $cco_diff = $f_product->cco_discount - $s_product->cco_discount;
            $system_cost_diff = $f_product->system_cost - $s_product->system_cost;
            $reimbursement_diff = $f_product->reimbursement - $s_product->reimbursement;

            if ($s_product->longevity != "" && $f_product->longevity != "") {

                $longevity_diff = $f_product->longevity - $s_product->longevity;

            }


            $system_repless_cost_diff = $f_product->system_repless_cost - $s_product->system_repless_cost;

            $unit_repless_cost_diff = $f_product->unit_repless_cost - $s_product->unit_repless_cost;

            $repless_cost_diff = $f_repless_cost - $s_repless_cost;

            $shock_diff = 0;
            $ct_diff = 0;
            $size_g_diff = 0;
            $size_cc_diff = 0;

            $shock_ct_f_product = "";
            $shock_ct_s_product = "";

            /*07/02/2017*/
            $shock_f_product = "";
            $shock_s_product = "";

            if ($f_product->shock != "" && $s_product->shock != "") {

                $shock_ct_f_product = explode('/', $f_product->shock);
                $shock_ct_s_product = explode('/', $s_product->shock);
                $shock_f_product = $shock_ct_f_product[0];
                $ct_f_product = $shock_ct_f_product[1];
                $shock_s_product = $shock_ct_s_product[0];
                $ct_s_product = $shock_ct_s_product[1];
                $shock_diff = $shock_f_product - $shock_s_product;
                $ct_diff = $ct_f_product - $ct_s_product;
                $shock_ct = "True";
                if ($f_product->shock_check != "True" || $s_product->shock_check != "True") {

                    $shock_ct = "False";
                    // $shock_f_product = $shock_f_product ."J/".$ct_f_product."s";
                    // $shock_s_product = $shock_s_product ."J/".$ct_s_product."s";

                }
            }

            if ($f_product->shock != "") {
                $shock_ct_f_product = explode('/', $f_product->shock);
                $shock_f_product = $shock_ct_f_product[0];
                $ct_f_product = $shock_ct_f_product[1];
                $shock_f_product = $shock_f_product . "J/" . $ct_f_product . "s";
            }

            if ($s_product->shock != "") {
                $shock_ct_s_product = explode('/', $s_product->shock);
                $shock_s_product = $shock_ct_s_product[0];
                $ct_s_product = $shock_ct_s_product[1];
                $shock_s_product = $shock_s_product . "J/" . $ct_s_product . "s";
            }


            $size_f_product = "";
            $size_s_product = "";

            if ($f_product->size != "" && $s_product->size != "") {

                $size_f_product = explode('/', $f_product->size);
                $size_s_product = explode('/', $s_product->size);
                $size_g_f_product = $size_f_product[0];
                $size_cc_f_product = $size_f_product[1];
                $size_g_s_product = $size_s_product[0];
                $size_cc_s_product = $size_s_product[1];
                $size_g_diff = $size_g_f_product - $size_g_s_product;
                $size_cc_diff = $size_cc_f_product - $size_cc_s_product;

            }
            $size_diff = $size_g_diff . "g/" . $size_cc_diff . "cc";

            if ($f_product->size != "") {
                $size_f_product = explode('/', $f_product->size);
                $size_g_f_product = $size_f_product[0];
                $size_cc_f_product = $size_f_product[1];
                $size_f_product = $size_g_f_product . "g/" . $size_cc_f_product . "cc";
            }

            if ($s_product->size != "") {
                $size_s_product = explode('/', $s_product->size);
                $size_g_s_product = $size_s_product[0];
                $size_cc_s_product = $size_s_product[1];
                $size_s_product = $size_g_s_product . "g/" . $size_cc_s_product . "cc";

            }

            $research = $s_product->research;
            $siteinfo = $s_product->site_info;
            $overAll = $s_product->overall_value;

        }

        $first_replesscost_check = $devicetype == "UNIT COST" ? $f_product->unit_rep_cost_check : $f_product->system_repless_cost_check;
        $first_replessdiscount_check = $devicetype == "UNIT COST" ? $f_product->unit_repless_discount_check : $f_product->system_repless_discount_check;
        $first_ccocost_check = $f_product->cco_check;
        $first_ccodiscount_check = $f_product->cco_discount_check;

        $first_exclusivecheck = $f_product->exclusive_check;
        $first_sizecheck = $f_product->size_check;
        $first_longevitycheck = $f_product->longevity_check;
        $first_shockcheck = $f_product->shock_check;
        $first_sizecheck = $f_product->size_check;
        $first_bulkcheck = $devicetype == "UNIT COST" ? $f_product->bulk_check : $f_product->system_bulk_check;
        $first_siteinfocheck = $f_product->siteinfo_check;
        $first_researchcheck = $f_product->research_check;


        $second_replesscost_check = $devicetype == "UNIT COST" ? $s_product->unit_rep_cost_check : $s_product->system_repless_cost_check;
        $second_replessdiscount_check = $devicetype == "UNIT COST" ? $s_product->unit_repless_discount_check : $s_product->system_repless_discount_check;
        $second_ccocost_check = $s_product->cco_check;
        $second_ccodiscount_check = $s_product->cco_discount_check;
        $second_exclusivecheck = $s_product->exclusive_check;
        $second_sizecheck = $s_product->size_check;
        $second_longevitycheck = $s_product->longevity_check;
        $second_shockcheck = $s_product->shock_check;
        $second_sizecheck = $s_product->size_check;
        $second_bulkcheck = $devicetype == "UNIT COST" ? $s_product->bulk_check : $s_product->system_bulk_check;
        $second_siteinfocheck = $s_product->siteinfo_check;
        $second_researchcheck = $s_product->research_check;


        $exclusive_option = "True";
        $size_option = "True";
        $longevity_option = "True";
        $shock_option = "True";
        $size_option = "True";
        $bulk_option = "True";
        $siteinfo_option = "True";
        $cco_discount_option = "True";
        $repless_discount_option = "True";
        $research_option = "True";
        $overall_value = "True";

        $longevity_delta_check = "False";
        $shock_delta_check = "False";
        $size_delta_check = "False";
        $research_delta_check = "False";
        $site_info_delta_check = "False";
        $overall_value_delta_check = "False";


        if (($first_replesscost_check == "True" && $second_replesscost_check == "True") && ($first_replessdiscount_check == "True" && $second_replessdiscount_check == "True")) {
            $repless_discount_option = "True";
        } else if (($first_replesscost_check == "False" && $second_replesscost_check == "False") && ($first_replessdiscount_check == "False" && $second_replessdiscount_check == "False")) {
            $repless_discount_option = "False";
        }


        if (($first_ccocost_check == "True" && $second_ccocost_check == "True") && ($first_ccodiscount_check == "True" && $second_ccodiscount_check == "True")) {
            $cco_discount_option = "True";
        } else if (($first_ccocost_check == "False" && $second_ccocost_check == "False") && ($first_ccodiscount_check == "False" && $second_ccodiscount_check == "False")) {
            $cco_discount_option = "False";

        }


        if ($first_exclusivecheck == "True" && $second_exclusivecheck == "True") {
            $exclusive_option = "True";
        } else if ($first_exclusivecheck == "" && $second_exclusivecheck == "") {
            $exclusive_option = "False";
        }


        if ($first_sizecheck == "True" && $second_sizecheck == "True") {
            if ($f_product->size_delta_check == "True" && $s_product->size_delta_check == "True") {

                $size_delta_check = "True";
            }

            $size_option = "True";
        } else if ($first_sizecheck == "" && $second_sizecheck == "") {
            $size_option = "False";
        }


        if ($first_longevitycheck == "True" && $second_longevitycheck == "True") {
            if ($f_product->longevity_delta_check == "True" && $s_product->longevity_delta_check == "True") {

                $longevity_delta_check = "True";
            }
            $longevity_option = "True";
        } else if ($first_longevitycheck == "" && $second_longevitycheck == "") {
            $longevity_option = "False";
        }


        if ($first_shockcheck == "True" && $second_shockcheck == "True") {
            if ($f_product->shock_delta_check == "True" && $s_product->shock_delta_check == "True") {

                $shock_delta_check = "True";
            }
            $shock_option = "True";
        } else if ($first_shockcheck == "" && $second_shockcheck == "") {
            $shock_option = "False";
        }

        if ($first_researchcheck == "True" && $second_researchcheck == "True") {
            if ($f_product->research_delta_check == "True" && $s_product->research_delta_check == "True") {

                $research_delta_check = "True";
            }
            $research_option = "True";
        } else if ($first_researchcheck == "" && $second_researchcheck == "") {
            $research_option = "False";
        }

        if ($first_siteinfocheck == "True" && $second_siteinfocheck == "True") {
            if ($f_product->site_info_delta_check == "True" && $s_product->site_info_delta_check == "True") {

                $site_info_delta_check = "True";
            }
            $siteinfo_option = "True";
        } else if ($first_siteinfocheck == "" && $second_siteinfocheck == "") {
            $siteinfo_option = "False";
        }

        if ($f_product->overall_value_check == "True" && $s_product->overall_value_check == "True") {
            if ($f_product->overall_value_delta_check == "True" && $s_product->overall_value_delta_check == "True") {

                $overall_value_delta_check = "True";
            }
            $overall_value = "True";
        } else if ($first_siteinfocheck == "" && $second_siteinfocheck == "") {
            $siteinfo_option = "False";
        }


        if ($first_bulkcheck == "True" && $second_bulkcheck == "True") {
            $bulk_option = "True";
        } else if ($first_bulkcheck == "False" && $second_bulkcheck == "False") {
            $bulk_option = "False";
        }


        $cco_check_value = "False";
        if (($f_product->cco_discount_check == "True" || $f_product->cco_check == "True") && ($s_product->cco_discount_check == "True" || $s_product->cco_check == "True")) {
            $cco_check_value = "True";
        }


        $repless_discount_value = "False";
        if (($first_replesscost_check == "True" || $first_replessdiscount_check == "True") && ($second_replesscost_check == "True" || $second_replessdiscount_check == "True")) {
            $repless_discount_value = "True";
        }


        $updatedate = client_price::orderby(DB::raw('date(is_updated)'), 'desc')
            ->where('client_name', '=', $clients)
            ->value('is_updated');
        $updatedate = Carbon::parse($updatedate)->format('m/d/Y');


        return view('pages/frontend/compare', compact('first_product', 'second_product', 'check_unit_cost', 'clientname', 'categoryname', 'updatedate', 'devicetype', 'system_cost_diff', 'reimbursement_diff', 'longevity_diff', 'shock_diff', 'ct_diff', 'cco_diff', 'unit_cost_diff', 'size_g_diff', 'size_cc_diff', 'shock_ct_f_product', 'shock_ct_s_product', 'size_f_product', 'size_s_product', 'shock_ct', 'shock_f_product', 'shock_s_product', 'ct_f_product', 'ct_s_product', 'productid', 'productname', 'productimage', 'exclusive_option', 'size_option', 'longevity_option', 'shock_option', 'size_option', 'bulk_option', 'siteinfo_option', 'repless_discount_option', 'cco_discount_option', 'cco_check_value', 'repless_cost_diff', 'repless_discount_value', 'research_option', 'unit_cost_delta_check', 'cco_discount_delta_check', 'system_cost_delta_check', 'reimbursement_delta_check', 'size_diff', 'system_repless_delta_check', 'unit_repless_delta_check', 'system_repless_cost_diff', 'unit_repless_cost_diff', 'custom_fields_data', 'longevity_delta_check', 'size_delta_check', 'shock_delta_check', 'overall_value', 'longevity_delta_check', 'shock_delta_check', 'size_delta_check', 'research_delta_check', 'site_info_delta_check', 'overall_value_delta_check', 'research', 'siteinfo', 'overAll', 'custom_diff'));


    }

    public function purchase(Request $request)
    {

        $devicetype = $request->get('devicetype');
        $deviceid = $request->get('deviceid');
        $surveyId = $request->get('surveyId');

        $user_organization = Auth::user()->organization;
        /*get selected clientdetails*/
        $clientdetails = session('details');
        $clients = $clientdetails['clients'];


        $orderdate = date('Y-m-d');
        $orderby = Auth::user()->id;
        $sento = Auth::user()->email;
        $devicedetails = device::join('client_price', 'client_price.device_id', '=', 'device.id')
            ->select('device.*', 'client_price.device_id', 'client_price.unit_cost', 'client_price.bulk_unit_cost', 'client_price.bulk_unit_cost_check', 'client_price.bulk', 'client_price.bulk_check', 'client_price.cco_discount', 'client_price.cco_discount_check', 'client_price.unit_rep_cost', 'client_price.unit_rep_cost_check', 'client_price.unit_repless_discount', 'client_price.unit_repless_discount_check', 'client_price.system_cost', 'client_price.system_cost_check', 'client_price.bulk_system_cost', 'client_price.bulk_system_cost', 'client_price.bulk_system_cost_check', 'client_price.system_repless_cost', 'client_price.system_repless_cost_check', 'client_price.system_repless_discount', 'client_price.system_repless_discount_check', 'client_price.reimbursement', 'client_price.reimbursement_check', 'client_price.order_email', 'client_price.cco', 'client_price.cco_check', 'client_price.system_bulk', 'client_price.system_bulk_check')
            ->where('device.id', '=', $deviceid)
            ->where('client_price.client_name', '=', $clients)
            ->get();


        foreach ($devicedetails as $devicedetail) {


            $user_organization = $clients;
            $devicerep = $devicedetail->rep_email;
            $orderuser = $devicedetail->order_email;


        }

        if ($devicetype == "UNIT COST") {


            $bulk = $devicedetail->bulk;
            $devicedetail->remain_bulk = $bulk;

            $second_unit_cost = $devicedetail->unit_cost;

            $unit_cost = $devicedetail->unit_cost;
            if ($devicedetail->bulk_unit_cost_check == "True" && $devicedetail->bulk_check == "True" && $bulk != 0) {

                $unit_cost -= ($devicedetail->unit_cost * $devicedetail->bulk_unit_cost) / 100;

                $devicedetail->unit_cost = $unit_cost;
            }

            if ($devicedetail->cco_discount_check == "True") {
                $unit_cost -= ($unit_cost * $devicedetail->cco_discount) / 100;

                $devicedetail->cco_discount = $unit_cost;
            } else if ($devicedetail->cco_check == "True") {
                $unit_cost -= $devicedetail->cco;
                $devicedetail->cco_discount = $unit_cost;
            } else {
                $devicedetail->cco_discount = "-";
            }


            if ($devicedetail->unit_repless_discount_check == "True") {

                $unit_cost -= ($unit_cost * $devicedetail->unit_repless_discount) / 100;
                $devicedetail->unit_repless_cost = $unit_cost;
            } else if ($devicedetail->unit_rep_cost_check == "True") {
                $unit_cost -= $devicedetail->unit_rep_cost;
                $devicedetail->unit_repless_cost = $unit_cost;
            } else {
                $devicedetail->unit_repless_cost = '-';
            }
        } else {

            $second_unit_cost = $devicedetail->system_cost;
            $system_cost = $devicedetail->system_cost;


            $bulk = $devicedetail->system_bulk;
            $devicedetail->remain_bulk = $bulk;
            $deviceid = $devicedetail->id;
            $devicedetail->custom_fields = device_custom_field::where('device_id', $deviceid)->get();

            if ($devicedetail->bulk_system_cost_check == "True" && $devicedetail->system_bulk_check == "True" && $bulk != 0) {

                $system_cost -= ($devicedetail->system_cost * $devicedetail->bulk_system_cost) / 100;

                $devicedetail->system_cost = $system_cost;
            }

            if ($devicedetail->system_repless_discount_check == "True") {

                $system_cost -= ($system_cost * $devicedetail->system_repless_discount) / 100;
                $devicedetail->system_repless_cost = $system_cost;
            } else if ($devicedetail->system_repless_cost_check == "True") {
                $system_cost -= $devicedetail->system_repless_cost;
                $devicedetail->system_repless_cost = $system_cost;
            } else {
                $devicedetail->system_repless_cost = '-';
            }
        }

        if ($devicedetail->bulk_check == "True" && $devicedetail->bulk_unit_cost_check == "True" && $devicedetail->remain_bulk > 0) {
            $unit_bulk = "True";
        } else {
            $unit_bulk = "False";
        }

        if ($devicedetail->system_bulk_check == "True" && $devicedetail->bulk_system_cost_check == "True" && $devicedetail->remain_bulk > 0) {
            $system_bulk = "True";
        } else {
            $system_bulk = "False";
        }

        $manufacturer_name = $devicedetail->manufacturer_name;
        $device_name = $devicedetail->device_name;
        $model_no = $devicedetail->model_name;

        $unit_cost = $devicetype == "UNIT COST" ? $devicedetail->unit_cost : '0';
        $system_cost = $devicetype == "SYSTEM COST" ? $devicedetail->system_cost : '0';
        $cco = $devicetype == "SYSTEM COST" ? '0' : $devicedetail->cco_discount;
        $bulk_check = $devicetype == "SYSTEM COST" ? $system_bulk : $unit_bulk;

        $order_detail = array(
            'manufacturer_name' => $manufacturer_name,
            'model_name' => $device_name,
            'model_no' => $model_no,
            'unit_cost' => $unit_cost,
            'system_cost' => $system_cost,
            'cco' => $cco,
            'order_date' => $orderdate,
            'orderby' => $orderby,
            'rep' => $devicerep,
            'sent_to' => $sento,
            'status' => 'New',
            'bulk_check' => $bulk_check,
            'is_delete' => 0,
            'clientId' => $clients,
            'deviceId' => $deviceid,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()

        );
        $placeorder = order::insert($order_detail);

        if ($placeorder) {

            // survey answer flag update
            if (count($surveyId) > 0) {
                $survey['flag'] = 'True';

                $SurveyAnswer = physciansPreferenceAnswer::whereIn('id', $surveyId)->update($survey);
            }


            /* get clients for administrator email*/
            $physician_client = user::where('id', '=', $orderby)
                ->where('status', '=', 'Enabled')->where('is_delete', '0')->first();

            $clients = [];
            foreach ($physician_client->userclients as $row) {
                $clients[] = $row->clientId;
            }

            $clientdetails = session('details');
            $currentclients = $clientdetails['clients'];

            $currentclientsId = $currentclients;

            // $administrators = User::leftJoin('user_clients','user_clients.userId','=','users.id')
            // ->where('users.roll', '=', 2)
            // ->where('users.status','=','Enabled')
            // ->where('users.is_delete','0')
            // ->where('user_clients.clientId',$currentclientsId)
            // ->get();


            $physicianemail = $sento;
            $orderemail = User::where('id', '=', $orderuser)
                ->where('status', '!=', 'Disabled')
                ->where('is_delete', '0')
                ->value('email');


            /*get current user clients*/

            $manufacturer = device::where('id', $deviceid)->first();
            $manufacturerName = $manufacturer->manufacturer->manufacturer_name;

            $repemail = User::repcontact()->where('users.roll', '5')
                ->where('rep_contact_info.deviceId', $deviceid)
                ->where('rep_contact_info.repStatus', 'Yes')
                ->where('users.organization', $manufacturer->manufacturer_name)
                ->where('users.is_delete', '0')
                ->where('users.status', 'Enabled')
                ->select('users.email');

            if (Auth::user()->roll == 2) {
                $repemail = $repemail->whereIn('user_clients.clientId', $currentclientsId);
            } else {
                $repemail = $repemail->where('user_clients.clientId', $currentclientsId);
            }
            $repemail = $repemail->get();

            $title = "Welcome to Neptune-PPA - Order Details ";
            $orderid = order::get()->last();
            $orderid = $orderid->id;
            $order_details = order::leftjoin('manufacturers', 'manufacturers.id', '=', 'orders.manufacturer_name')
                ->leftjoin('users', 'users.id', '=', 'orders.rep')
                ->leftjoin('users as ob', 'ob.id', '=', 'orders.orderby')
                ->select('orders.*', 'users.name', 'ob.name as ob_name', 'manufacturers.manufacturer_name')
                ->where('orders.id', '=', $orderid)->get();

            foreach ($order_details as $order_detail) {
                $manufacturer = $order_detail->manufacturer_name;
                $device_name = $order_detail->model_name;
                $model_no = $order_detail->model_no;
                $unit_cost = $order_detail->unit_cost;
                $system_cost = $order_detail->system_cost;
                $cco = $order_detail->cco;
                $orderdate = $order_detail->order_date;
                $orderby = $order_detail->ob_name;
                $devicerep = $order_detail->name;
                $sento = $order_detail->sent_to;
            }


            // Custom Contact Mail sending

            $deviceId = $devicedetail->id;

            $clientdetails = session('details');
            $currentclients = $clientdetails['clients'];

            $currentclientsId = $currentclients;

            $clientId = $currentclientsId;

            $maildata = customContact::where('deviceId', $deviceId);
            if (Auth::user()->roll == 2) {
                $maildata = $maildata->whereIN('clientId', $clientId);
            } else {
                $maildata = $maildata->where('clientId', $clientId);
            }
            $maildata = $maildata->first();
            if (empty($maildata)) {
                $userMail = "";
                $cc1 = "";
                $cc2 = "";
                $cc3 = "";
                $cc4 = "";
                $cc5 = "";
                $cc6 = "";
            } else {
                $userMail = $maildata->order_email == '0' ? '' : $maildata->user->email;
                $cc1 = $maildata['cc1'];
                $cc2 = $maildata['cc2'];
                $cc3 = $maildata['cc3'];
                $cc4 = $maildata['cc4'];
                $cc5 = $maildata['cc5'];
                $cc6 = $maildata['cc6'];
                $title = $maildata['subject'] == "" ? $title : $maildata['subject'];

            }

            $data = array(
                'title' => $title,
                'physician' => $physicianemail,
                'rep_email' => $repemail,
                'order_email' => $userMail,
                // 'administrator_email' => $administrators,
                'manufacturer_name' => $manufacturer,
                'model_name' => $device_name,
                'model_no' => $model_no,
                //'unit_cost' => $unit_cost,
                //'system_cost' => $system_cost,
                //'cco' => $cco,
                'order_date' => $orderdate,
                'orderby' => $orderby,
                'rep' => $devicerep,
                'sent_to' => $sento,
                'cc1' => $cc1,
                'cc2' => $cc2,
                'cc3' => $cc3,
                'cc4' => $cc4,
                'cc5' => $cc5,
                'cc6' => $cc6
            );

            $email = array();
            $cc = array();
            if ($physicianemail != "") {
                $email[]= $physicianemail;
            }

            if ($userMail != "") {
                $email[]= $userMail;
            }

            foreach ($repemail as $repmail) {
                if ($repmail->email != "") {
                    $email[]= $repmail->email;
                }
            }

            if ($cc1 != "") {
                $cc[] = $cc1;
            }
            if ($cc2 != "") {
                $cc[] = $cc2;
            }
            if ($cc3 != "") {
                $cc[] = $cc3;
            }
            if ($cc4 != "") {
                $cc[] = $cc4;
            }
            if ($cc5 != "") {
                $cc[] = $cc5;
            }
            if ($cc6 != "") {
                $cc[] = $cc6;
            }

            $mail['message'] = '<div style="background: #f1f1f1; text-align: left; width: 700px;"  >
                                        <p style="font-weight: normal; font-size: 19px; margin-top: 15px;"><span>Your Order Details Are Mention Below</span></p>
                                        <p style="font-weight: normal; font-size: 19px; margin-top: 15px;"><span><b>Manufacturer:</b></span><span>'.$manufacturer.'</span><br></p>
                                        <p style="font-weight: normal; font-size: 19px; margin-top: 15px;"><span><b>Device Name:</b></span>
                                        <span>'.$device_name.'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Model Name:</b></span><span>'.$model_no.'</span><br></p>
                                        <p style="font-weight: normal; font-size: 19px; margin-top: 15px;"><span><b>Order Date:</b></span><span>'.Carbon::parse($orderdate)->format('m-d-Y').'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span><b>Order By:</b></span><span>'.$orderby.'</span><br></p>
                                        <p style="font-weight: normal; font-size: 19px; margin-top: 15px;"><span><b>Rep:</b></span><span>'.$devicerep.'</span></p><br>
                                        <p style="font-weight: normal; font-size: 19px; margin-top: 15px;"><span>If, Causes Any Problem then Contact us At admin@neptneppa.com</span></p>
                                 </div>';
            $mail['from'] = 'admin@neptuneppa.com';
            $mail['subject'] = $title;
            $mail['status'] = "Send";

            $usermail = new MailList;
            $usermail->fill($mail);

            if($usermail->save()){
                if(count($email) > 0){
                    foreach($email as $mails){
                        $to['mailId'] = $usermail->id;
                        $to['mail'] = $mails;
                        $to['status'] = "TO";

                        $sendto = new MailTo;
                        $sendto->fill($to);
                        $sendto->save();
                    }
                }
                if(count($cc) > 0){
                    foreach ($cc as $c){
                        $ccmail['mailId'] = $usermail->id;
                        $ccmail['mail'] = $c;
                        $ccmail['status'] = "CC";

                        $sendcc = new MailTo;
                        $sendcc->fill($ccmail);
                        $sendcc->save();
                    }
                }
            }


            Mail::send('emails.securemail', $data, function ($message) use ($data) {
                $message->from('admin@neptuneppa.com','Neptune-PPA')->subject($data['title']);
                if ($data['physician'] != "") {
                    $message->to($data['physician']);
                }

                if ($data['order_email'] != "") {
                    $message->to($data['order_email']);
                }
                if ($data['cc1'] != "") {
                    $message->cc($data['cc1']);
                }

                if ($data['cc2'] != "") {
                    $message->cc($data['cc2']);
                }
                if ($data['cc3'] != "") {
                    $message->cc($data['cc3']);
                }
                if ($data['cc4'] != "") {
                    $message->cc($data['cc4']);
                }
                if ($data['cc5'] != "") {
                    $message->cc($data['cc5']);
                }
                if ($data['cc6'] != "") {
                    $message->cc($data['cc6']);
                }

//                $message->cc("punitkathiriya@gmail.com");

                // foreach ($data['administrator_email'] as $administrator) {
                // 	if ($administrator->email != "") {
                // 		$message->to($administrator->email);
                // 	}
                // }

                foreach ($data['rep_email'] as $repmail) {
                    if ($repmail->email != "") {
                        $message->to($repmail->email);
                    }
                }
            });
        }
        return Redirect::to('menu');
    }

    // Rep Contact information Function

    public function repContactInfo(Request $request)
    {

        $id = $request->get('id');

        $clientdetails = session('details');

        $clients = $clientdetails['clients'];

        $manufacturer = device::where('id', $id)->first();
        $manufacturerName = $manufacturer->manufacturer->manufacturer_name;


        $rep = User::repcontact()->where('users.roll', '5')
            ->where('rep_contact_info.deviceId', $id)
            ->where('rep_contact_info.repStatus', 'Yes')
            ->where('users.organization', $manufacturer->manufacturer_name)
            ->where('users.status', 'Enabled')
            ->where('user_clients.clientId', $clients)
            ->where('user_projects.projectId', $manufacturer->project_name)
            ->groupBy('users.id')
            ->get();
        // dd($rep);

        $clientname = clients::where('id', '=', $clients)->value('client_name');

        if (count($rep)) {
            $rep = [
                'data' => $rep,
                'status' => TRUE
            ];
        } else {
            $rep = [
                'data' => "No Data Found",
                'status' => False
            ];
        }

        $data = ['rep' => $rep, 'manufacturer' => $manufacturerName, 'clientName' => $clientname];

        return [
            'value' => $data,
            'status' => TRUE
        ];

    }

    // Survey question get Function

    public function surveyQuestion(Request $request)
    {

        $id = $request->get('id');
        $clientdetails = session('details');
        $clients = $clientdetails['clients'];

        $survey = physciansPreference::where('deviceId', $id)->where('clientId', $clients)->where('check', 'True')->where('flag', 'True')->get();
//dd(count($survey));
        $data = array('survey' => $survey, 'deviceId' => $id);
//dd($survey);
        if (count($survey))
            return [
                'value' => $data,
                'status' => TRUE
            ];
        else
            return [
                'value' => $id,
                'status' => FALSE
            ];


    }

    public function surveyQuestionAnswer(Request $request)
    {
        $data = $request->all();
        $id = $request->get('question');
        $check = $request->get('check');
        $clientdetails = session('details');
        $clients = $clientdetails['clients'];
        $deviceId = $request->get('deviceId');
        $userId = Auth::user()->id;

        $question = physciansPreference::whereIn('id', $id)->get();

        $answer = array();
        $flag = array();
        for ($i = 0; $i < count($id); $i++) {
            $answer['clientId'] = $clients;
            $answer['deviceId'] = $deviceId;
            $answer['userId'] = $userId;
            $answer['question'] = $question[$i]['question'];
            $answer['check'] = $question[$i]['check'];
            $answer['answer'] = $check[$i];
            $answer['preId'] = $id[$i];
            $answer['flag'] = "False";

            $survey = new physciansPreferenceAnswer();
            $survey->fill($answer);
            $survey->save();

            $flag[] = $survey->id;
        }
        $checkvalue['surveyId'] = $flag;
        $checkvalue['deviceid'] = $deviceId;
        if (count($checkvalue))
            return [
                'value' => $checkvalue,
                'status' => TRUE
            ];
        else
            return [
                'value' => 'No result Found',
                'status' => FALSE
            ];
    }

    public function surveyData()
    {

        $survey = Survey::orderBy('id', 'asc')->get();

        $data = [];
        foreach ($survey as $row) {
            $rowData = [];
            $rowData[1]['question'] = $row['que_1'];
            $rowData[1]['check'] = $row['que_1_check'];
            $rowData[2]['question'] = $row['que_2'];
            $rowData[2]['check'] = $row['que_2_check'];
            $rowData[3]['question'] = $row['que_3'];
            $rowData[3]['check'] = $row['que_3_check'];
            $rowData[4]['question'] = $row['que_4'];
            $rowData[4]['check'] = $row['que_4_check'];
            $rowData[5]['question'] = $row['que_5'];
            $rowData[5]['check'] = $row['que_5_check'];
            $rowData[6]['question'] = $row['que_6'];
            $rowData[6]['check'] = $row['que_6_check'];
            $rowData[7]['question'] = $row['que_7'];
            $rowData[7]['check'] = $row['que_7_check'];
            $rowData[8]['question'] = $row['que_8'];
            $rowData[8]['check'] = $row['que_8_check'];

            foreach ($rowData as $item) {
                $phy['clientId'] = $row->clientId;
                $phy['deviceId'] = $row->deviceId;
                $phy['question'] = $item['question'];
                $phy['check'] = $item['check'];
                $phy['flag'] = $row->status;

                $sur = new physciansPreference();
                $sur->fill($phy);
                $sur->save();
            }

        }

    }

    public function surveyAnswerData()
    {
        $survey = SurveyAnswer::orderBy('id', 'asc')->get();

        foreach ($survey as $row) {
            $rowData = [];
            $rowData[0]['question'] = $row['que_1'];
            $rowData[0]['check'] = $row['que_1_check'];
            $rowData[0]['answer'] = $row['que_1_answer'];
            $rowData[1]['question'] = $row['que_2'];
            $rowData[1]['check'] = $row['que_2_check'];
            $rowData[1]['answer'] = $row['que_1_answer'];
            $rowData[2]['question'] = $row['que_3'];
            $rowData[2]['check'] = $row['que_3_check'];
            $rowData[2]['answer'] = $row['que_1_answer'];
            $rowData[3]['question'] = $row['que_4'];
            $rowData[3]['check'] = $row['que_4_check'];
            $rowData[3]['answer'] = $row['que_1_answer'];
            $rowData[4]['question'] = $row['que_5'];
            $rowData[4]['check'] = $row['que_5_check'];
            $rowData[4]['answer'] = $row['que_1_answer'];
            $rowData[5]['question'] = $row['que_6'];
            $rowData[5]['check'] = $row['que_6_check'];
            $rowData[5]['answer'] = $row['que_1_answer'];
            $rowData[6]['question'] = $row['que_7'];
            $rowData[6]['check'] = $row['que_7_check'];
            $rowData[6]['answer'] = $row['que_1_answer'];
            $rowData[7]['question'] = $row['que_8'];
            $rowData[7]['check'] = $row['que_8_check'];
            $rowData[7]['answer'] = $row['que_1_answer'];

            $sur = Survey::where('id', $row->surveyId)->first();

            $data = array();
            $getId = physciansPreference::where('clientId', $sur['clientId'])->where('deviceId', $sur['deviceId'])->get();
            foreach ($getId as $item) {
                $data[] = $item->id;
            }

            for ($i = 0; $i < count($data); $i++) {
                $phy['clientId'] = $sur['clientId'];
                $phy['deviceId'] = $row->deviceId;
                $phy['userId'] = $row->user_id;
                $phy['question'] = $rowData[$i]['question'];
                $phy['check'] = $rowData[$i]['check'];
                $phy['answer'] = $rowData[$i]['answer'];
                $phy['preId'] = $data[$i];
                $phy['flag'] = "False";

//dd($phy);
                $sure = new physciansPreferenceAnswer();
                $sure->fill($phy);
                $sure->save();
            }
        }
        die;
    }

}
