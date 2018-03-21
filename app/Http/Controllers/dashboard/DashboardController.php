<?php

namespace App\Http\Controllers\dashboard;

use App\category;
use App\clients;
use App\Http\Controllers\Controller;
use App\Import_app;
use App\ItemFileEntry;
use App\Month;
use App\User;
use App\userClients;
use Auth;
use Illuminate\Http\Request;
use Log;
use URL;
use App\project;

class DashboardController extends Controller
{
    /**
     * Unit App Calculation
     * @param Request $request
     */

    public function index(Request $request)
    {

        /**
         * Session Data Query start
         */

        $getuserclients = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if (Auth::user()->roll == "2") {
            $clients = clients::whereIn('id', $getuserclients)->where('is_active', 1)->get();
        } else {
            $clients = clients::where('is_active', 1)->get();
        }
        $selectclients = array();
        $clientdetails = session('adminclient'); // check session for selected client
        $projectdetails = session('adminproject'); // check session fro selected project
        $selectprojects = '';

//        $selectclients = $clients[0]['id'];

        if (count($clientdetails) > 0) {
            $selectclients = $clientdetails[0];
        }

        if (!empty($projectdetails)) {
            $selectprojects = $projectdetails;
        }


        //get selected client and projects links
        $selectedclient = array('image' => '');
        $project = array();
        if (!empty($selectclients)) {

            $selectedclient = clients::where('id', $selectclients)->first();
            $project = project::leftJoin('project_clients', 'project_clients.project_id', '=', 'projects.id')
                ->where('project_clients.client_name', $selectclients)
                ->select('projects.*')
                ->get();
        }


        /**
         * Session Data End
         */

        $organization = $getuserclients;
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');
        }

        $projects = '';
        if ($request->session()->has('adminproject')) {
            $projects = session('adminproject');
        }

        /**
         * Market share Variables
         */
        $unit = empty($request['unit_value']) ? 'spend' : $request['unit_value'];


        /**
         * Market share Variables end
         */

        $case = ItemFileEntry::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
            ->where('item_file_main.produceDate', Current_date)
            ->select('item_file_entry.*', 'item_file_main.physician', 'item_file_main.phyEmail', 'item_file_main.clientId');
        if (!empty($organization)) {
            $case = $case->whereIn('item_file_main.clientId', $organization);
        }
        $case = $case->get();


        foreach ($case as $row) {
            $row->physician = User::where('email', $row->phyEmail)->value('name');
            $row->client = clients::where('id', $row->clientId)->value('client_name');
        }

        $bulk = Bulkcategory($organization, $projects);


        /**
         * Marketshare Calculation Start
         */

        $datas = clientData('', Current_Year, '', $organization, array($projects));

        if ($unit == 'spend') {

            $client_marketshares = client_marketshare($datas);

            $Final_client_marketshare = $client_marketshares['marketshare'];
            $final_client_totalspend = $client_marketshares['totalspend'];
        } else {

            $totalspends = array_sum(array_column($datas, 'price'));
            $manufacture = array();
            foreach ($datas as $item) {
                $manufacture[$item->manufacturer][] = $item;
            }

            $company = array();

            foreach ($manufacture as $key => $value) {
                $total = array_sum(array_column($value, 'price'));
                $total_device = count($value);
                $company[] = array(
                    'totalspend' => intval($total),
                    'manufacture' => $key,
                    'ms' => intval($total_device),
                );
            }

            $Final_client_marketshare = $company;
            $final_client_totalspend = intval($totalspends);
        }

        /**
         * Marketshare Calculation End
         */

        $clientSavings = '';

        $clientSaving = '';

        $cateogries = '';

        return view('pages.dashboard.index', compact('case', 'cateogries', 'bulk', 'Final_client_marketshare', 'final_client_totalspend', 'unit', 'clientSaving', 'clientSavings', 'getuserclients', 'clients', 'selectclients', 'clientdetails', 'projectdetails', 'selectprojects', 'project', 'selectedclient', 'organization'));

    }

    public function app(Request $request)
    {


        /**
         * Session Data Query start
         */

        $getuserclients = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if (Auth::user()->roll == "2") {
            $clients = clients::whereIn('id', $getuserclients)->where('is_active', 1)->get();
        } else {
            $clients = clients::where('is_active', 1)->where('is_active', 1)->get();
        }
        $selectclients = array();
        $clientdetails = session('adminclient');
        $projectdetails = session('adminproject');

        if (count($clientdetails) > 0) {

            $selectclients = $clientdetails[0];
        }

        if (count($projectdetails) > 0) {
            $selectprojects = $projectdetails;
        } else {
            $selectprojects = '';
        }

        if (!empty($selectclients)) {

            $selectedclient = clients::where('id', $selectclients)->first();
            $project = project::leftJoin('project_clients', 'project_clients.project_id', '=', 'projects.id')
                ->where('project_clients.client_name', $selectclients)
                ->select('projects.*')
                ->get();
        } else {
            $selectedclient = array('image' => '');
            $project = array();
        }

        /**
         * Session Data End
         */


        $projects = '';
        if ($request->session()->has('adminproject')) {
            $projects = session('adminproject');
        }

        $userid = Auth::user()->id;
        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');
        }

        $category = category::leftjoin('category_sort', 'category_sort.category_name', '=', 'category.id')
            ->orderBy('category_sort.sort_number', 'ASC')
            ->whereIn('category_sort.client_name', $organization)
            ->where('category.is_active', '=', '1');
        if (!empty($projects)) {
            $category = $category->where('category.project_name', $projects);
        }
        $category = $category->select('category.*')->get();
        foreach ($category as $row) {
            if (!empty($row->image) && file_exists('public/category/' . $row->image)) {
                $row->image = URL::to('public/category/' . $row->image);
            } else {
                $row->image = '';
            }
        }
        return view('pages.dashboard.category', compact('category', 'getuserclients', 'clients', 'selectclients', 'clientdetails', 'projectdetails', 'selectprojects', 'project', 'selectedclient', 'organization'));
    }

    public function unitapp(Request $request, $id)
    {

        $userid = Auth::user()->id;

        $unit = $request->get('unit');
        $system = $request->get('system');
        $entry = $request->get('entry');
        $advanced = $request->get('advanced');

        if ($unit == '' && $system == '') {
            $unit = 'unit';
        }

        if ($entry == '' && $advanced == '') {
            $entry = 'entry';
        }

        $year = Current_Year;

        if ($request->get('year')) {
            $year = $request->get('year');
        }

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');
        }

        $projects = '';
        if ($request->session()->has('adminproject')) {
            $projects = session('adminproject');
        }

        $client_name = $organization[0];

        $category_name = category::leftjoin('category_sort', 'category_sort.category_name', '=', 'category.id')
            ->orderBy('category_sort.sort_number', 'ASC')
            ->whereIn('category_sort.client_name', $organization)
            ->where('category.is_active', '=', '1');

        if (!empty($projects)) {
            $category_name = $category_name->where('category.project_name', $projects);
        }

        $category_name = $category_name->select('category.*')->get();
        foreach ($category_name as $row) {
            if (!empty($row->image) && file_exists('public/category/' . $row->image)) {
                $row->image = URL::to('public/category/' . $row->image);
            } else {
                $row->image = '';
            }
        }

        $even_category = array();
        $odd_category = array();

        foreach ($category_name as $item => $values) {
            if ($item % 2 == 0) {
                $even_category[] = $values;
            } else {
                $odd_category[] = $values;
            }
        }

        $level = $entry == '' ? $advanced : $entry;

        $level = $level == 'entry' ? 'Entry' : 'Advanced';

        $type = $unit == '' ? $system : $unit;

        $type = $type == 'unit' ? 'Unit' : 'System';

        $checkdata = Import_app::where('category_name', $id)
            ->whereIn('client_name', $organization)
            ->where('device_level', $entry)
            ->where('project_name', $projects)
            ->where('year', $year)
            ->first();

        if ($unit != '' && $entry != '') {
            $category = categoryunitentry($organization, $id, $projects, $year);
            $manufacture = categoryunitentrymanufacture($organization, $id, $category, $projects, $year);
            $physician = categoryunitentryphysician($organization, $id, $category, $projects, $year);
            $phymanufature = categoryunitenrtyphysicianmanufacture($organization, $id, $physician, $projects, $year);

        } else if ($unit != '' && $advanced != '') {
            $category = categoryunitadvanced($organization, $id, $projects, $year);
            $manufacture = categoryunitadvancedmanufacture($organization, $id, $category, $projects, $year);
            $physician = categoryunitadvancedphysician($organization, $id, $category, $projects, $year);
            $phymanufature = cateogryunitadvancedphysicianmanufacture($organization, $id, $physician, $projects, $year);
        } else if ($system != '' && $entry != '') {
            $category = categorysystementry($organization, $id, $projects, $year);
            $manufacture = manufacturesystementry($organization, $id, $category, $projects, $year);
            $physician = physiciansystem($organization, $id, $category, $projects, $year);
            $phymanufature = physicianmanufacturesystem($organization, $id, $category, $projects, $year,$physician);

        } else if ($system != '' && $advanced != '') {
            $category = categorysystemadvanced($organization, $id, $projects, $year);
            $manufacture = manufacturesystemadvanced($organization, $id, $category, $projects, $year);
            $physician = physiciansystem($organization, $id, $category, $projects, $year);
            $phymanufature = physicianmanufacturesystem($organization, $id, $category, $projects, $year,$physician);
        }

        $categoryName = category::where('id', $id)->value('short_name', 'manufacture');

        $years = array();

        for ($i = 2015; $i <= 2020; $i++) {
            $years[$i] = $i;
        }

        return view('pages.dashboard.app', compact('years', 'year', 'category', 'categoryName', 'client_name', 'manufacture', 'physician', 'phymanufature', 'id', 'unit', 'advanced', 'entry', 'system', 'category_name', 'even_category', 'odd_category'));

    }

    public function getphysicianapp()
    {
//		dd('hello');
    }

    public function viewsaving(Request $request)
    {


        /**
         * Session Data Query start
         */

        $getuserclients = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if (Auth::user()->roll == "2") {
            $clients = clients::whereIn('id', $getuserclients)->where('is_active', 1)->get();
        } else {
            $clients = clients::where('is_active', 1)->where('is_active', 1)->get();
        }
        $selectclients = array();
        $clientdetails = session('adminclient');
        $projectdetails = session('adminproject');

        if (count($clientdetails) > 0) {

            $selectclients = $clientdetails[0];
        }

        if (count($projectdetails) > 0) {
            $selectprojects = $projectdetails;
        } else {
            $selectprojects = '';
        }

        if (!empty($selectclients)) {

            $selectedclient = clients::where('id', $selectclients)->first();
            $project = project::leftJoin('project_clients', 'project_clients.project_id', '=', 'projects.id')
                ->where('project_clients.client_name', $selectclients)
                ->select('projects.*')
                ->get();
        } else {
            $selectedclient = array('image' => '');
            $project = array();
        }

        /**
         * Session Data End
         */


        $userid = Auth::user()->id;
        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');
        }

        $projects = '';
        if ($request->session()->has('adminproject')) {
            $projects = session('adminproject');
        }

        $year = $request['year'];

        if (empty($year)) {
            $year = Current_Year;
        }

        $month = $request['month'];

        if (empty($month)) {
            $month = Current_month;
        }

        /**
         * Saving Calculation Start
         */
        $user_id = $request->get('user_id');

        if (empty($user_id)) {
            $user_first = User::leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
                ->leftJoin('user_clients', 'user_clients.userId', '=', 'users.id')
                ->where('user_projects.projectId', $projects)
                ->WhereIn('user_clients.clientId', $organization)
                ->where('users.status', 'Enabled')
                ->where('users.roll', 3)
                ->select('users.*')
                ->first();
        } else {
            $user_first = User::where('id', $user_id)->first();
        }

        $user_list = User::leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
            ->leftJoin('user_clients', 'user_clients.userId', '=', 'users.id')
            ->where('user_projects.projectId', $projects)
            ->WhereIn('user_clients.clientId', $organization)
            ->where('users.status', 'Enabled')
            ->where('users.roll', 3)
            ->pluck('users.name', 'users.id')
            ->all();

        $oldyear_saving = array();
        $newyear_saving = array();
        $final_saving = array();

        $months = Month::pluck('month', 'id')->all();

        $years = array();

        for ($i = 2015; $i <= 2020; $i++) {
            $years[$i] = $i;
        }

        $oldyear = $year - 1;

        $userSavings = '';
        $totalsaving = 0;
        $client_monthly_Savings = array();
        $clientSaving = '';

        /**
         * Client Total Spend And Saving Start
         */

        $userSavings_client = 0;
        $client_monthly_Savings_client = array();

        $client_saving_wise = '';

        /**
         * Client Total Spend And Saving End
         */

        /**
         * Saving Calculation End
         */

        /**
         * Saving Month wise saving for all user start
         */

        $saving_user = array();

        /**
         * Saving Month wise saving for all user End
         */

        return view('pages.dashboard.view.saving', compact('years', 'year', 'month', 'months', 'userSavings', 'clientSaving', 'saving_user', 'userSavings_client', 'client_monthly_Savings_client', 'client_saving_wise', 'client_saving_wise', 'user_first', 'user_list', 'client_monthly_Savings', 'getuserclients', 'clients', 'selectclients', 'clientdetails', 'projectdetails', 'selectprojects', 'project', 'selectedclient', 'organization', 'user_first'));
    }

    public function viewbulk(Request $request)
    {

        /**
         * Session Data Query start
         */

        $getuserclients = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if (Auth::user()->roll == "2") {
            $clients = clients::whereIn('id', $getuserclients)->where('is_active', 1)->get();
        } else {
            $clients = clients::where('is_active', 1)->where('is_active', 1)->get();
        }
        $selectclients = array();
        $clientdetails = session('adminclient');
        $projectdetails = session('adminproject');

        if (count($clientdetails) > 0) {

            $selectclients = $clientdetails[0];
        }

        if (count($projectdetails) > 0) {
            $selectprojects = $projectdetails;
        } else {
            $selectprojects = '';
        }

        if (!empty($selectclients)) {

            $selectedclient = clients::where('id', $selectclients)->first();
            $project = project::leftJoin('project_clients', 'project_clients.project_id', '=', 'projects.id')
                ->where('project_clients.client_name', $selectclients)
                ->select('projects.*')
                ->get();
        } else {
            $selectedclient = array('image' => '');
            $project = array();
        }

        /**
         * Session Data End
         */


        $userid = Auth::user()->id;
        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');
        }

        $projects = '';
        if ($request->session()->has('adminproject')) {
            $projects = session('adminproject');
        }

        $bulk = CategoryBulk($organization, $projects);

        return view('pages.dashboard.view.bulk', compact('bulk', 'getuserclients', 'clients', 'selectclients', 'clientdetails', 'projectdetails', 'selectprojects', 'project', 'selectedclient', 'organization'));
    }

    public function viewmarketshare(Request $request)
    {

        /**
         * Session Data Query start
         */

        $getuserclients = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if (Auth::user()->roll == "2") {
            $clients = clients::whereIn('id', $getuserclients)->where('is_active', 1)->get();
        } else {
            $clients = clients::where('is_active', 1)->where('is_active', 1)->get();
        }
        $selectclients = array();
        $clientdetails = session('adminclient');
        $projectdetails = session('adminproject');

        if (count($clientdetails) > 0) {

            $selectclients = $clientdetails[0];
        }

        if (count($projectdetails) > 0) {
            $selectprojects = $projectdetails;
        } else {
            $selectprojects = '';
        }

        if (!empty($selectclients)) {

            $selectedclient = clients::where('id', $selectclients)->first();
            $project = project::leftJoin('project_clients', 'project_clients.project_id', '=', 'projects.id')
                ->where('project_clients.client_name', $selectclients)
                ->select('projects.*')
                ->get();
        } else {
            $selectedclient = array('image' => '');
            $project = array();
        }

        /**
         * Session Data End
         */


        $userid = Auth::user()->id;
        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');
        }

        $projects = '';
        if ($request->session()->has('adminproject')) {
            $projects = session('adminproject');
        }

        /**
         * Market share Variables
         */
        $unit = $request['unit_value'];

        if (empty($unit)) {
            $unit = 'spend';
        }

        $year = $request['year'];

        if (empty($year)) {
            $year = Current_Year;
        }

        $month = $request['month'];

        if (empty($month)) {
            $month = Current_month;
        }
        /**
         * Market share Variables end
         */

        $user_list = User::leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
            ->leftJoin('user_clients', 'user_clients.userId', '=', 'users.id')
            ->where('user_projects.projectId', $projects)
            ->WhereIn('user_clients.clientId', $organization)
            ->where('users.status', 'Enabled')
            ->where('users.roll', 3)
            ->select('users.*')
            ->orderBy('users.name', 'ASC')
            ->get();

        /**
         * Marketshare Year Wise Calculation Start
         */

        $Final_client_marketshare_year = array();
        $final_client_totalspend_year = array();
        foreach ($user_list as $row) {
            /**
             * Marketshare Calculation Start
             */

            $datas = clientData('', $year, $row->email, $organization, array($projects));

            if ($unit == 'spend') {

                $client_marketshares = client_marketshare($datas);
                $Final_client_marketshare_year[] = $client_marketshares['marketshare'];
                $final_client_totalspend_year[] = $client_marketshares['totalspend'];

            } else {

                $totalspends = array_sum(array_column($datas, 'price'));
                $manufacture = array();
                foreach ($datas as $item) {
                    $manufacture[$item->manufacturer][] = $item;
                }

                $company = array();

                foreach ($manufacture as $key => $value) {
                    $total = array_sum(array_column($value, 'price'));
                    $total_device = count($value);
                    $company[] = array(
                        'totalspend' => intval($total),
                        'manufacture' => $key,
                        'ms' => intval($total_device),
                    );
                }

                $Final_client_marketshare_year[] = $company;
                $final_client_totalspend_year[] = $totalspends;
            }

            /**
             * Marketshare Calculation End
             */
        }

        /**
         * Marketshare Year Wise Calculation End
         */

        $Final_client_marketshare_month = array();
        $final_client_totalspend_month = array();

        /**
         * Marketshare Month Wise Calculation Start
         */
        foreach ($user_list as $row) {
            /**
             * Marketshare Calculation Start
             */

            $datas = clientData($month, $year, $row->email, $organization, array($projects));

            if ($unit == 'spend') {

                $client_marketshares = client_marketshare($datas);

                $Final_client_marketshare_month[] = $client_marketshares['marketshare'];
                $final_client_totalspend_month[] = $client_marketshares['totalspend'];
            } else {

                $totalspends = array_sum(array_column($datas, 'price'));
                $manufacture = array();
                foreach ($datas as $item) {
                    $manufacture[$item->manufacturer][] = $item;
                }

                $company = array();

                foreach ($manufacture as $key => $value) {
                    $total = array_sum(array_column($value, 'price'));
                    $total_device = count($value);
                    $company[] = array(
                        'totalspend' => intval($total),
                        'manufacture' => $key,
                        'ms' => intval($total_device),
                    );
                }

                $Final_client_marketshare_month[] = $company;
                $final_client_totalspend_month[] = $totalspends;
            }

            /**
             * Marketshare Calculation End
             */
        }

        $months = Month::pluck('month', 'id')->all();

        $years = array();

        for ($i = 2015; $i <= 2020; $i++) {
            $years[$i] = $i;
        }
        /**
         * Marketshare Month Wise Calculation End
         */

        return view('pages.dashboard.view.marketshare', compact('unit', 'years', 'months', 'year', 'month', 'user_list', 'Final_client_marketshare_month', 'final_client_totalspend_month', 'Final_client_marketshare_year', 'final_client_totalspend_year', 'getuserclients', 'clients', 'selectclients', 'clientdetails', 'projectdetails', 'selectprojects', 'project', 'selectedclient', 'organization'));
    }

    public function savingviewmore(Request $request)
    {

        /**
         * Session Data Query start
         */

        $getuserclients = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if (Auth::user()->roll == "2") {
            $clients = clients::whereIn('id', $getuserclients)->where('is_active', 1)->get();
        } else {
            $clients = clients::where('is_active', 1)->where('is_active', 1)->get();
        }
        $selectclients = array();
        $clientdetails = session('adminclient');
        $projectdetails = session('adminproject');

        if (count($clientdetails) > 0) {

            $selectclients = $clientdetails[0];
        }

        if (count($projectdetails) > 0) {
            $selectprojects = $projectdetails;
        } else {
            $selectprojects = '';
        }

        if (!empty($selectclients)) {

            $selectedclient = clients::where('id', $selectclients)->first();
            $project = project::leftJoin('project_clients', 'project_clients.project_id', '=', 'projects.id')
                ->where('project_clients.client_name', $selectclients)
                ->select('projects.*')
                ->get();
        } else {
            $selectedclient = array('image' => '');
            $project = array();
        }

        /**
         * Session Data End
         */


        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');
        }

        $projects = '';
        if ($request->session()->has('adminproject')) {
            $projects = session('adminproject');
        }

        /**
         * Saving Calculation Start
         */
        $oldyear_saving = array();
        $newyear_saving = array();
        $final_saving = array();

        $year = $request['year'];

        if (empty($year)) {
            $year = Current_Year;
        }

        $month = $request['month'];

        if (empty($month)) {
            $month = Current_month;
        }

        $oldyear = $year - 1;

        $totalsaving = 0;
        $clientSavings = 0;
        $clientSavingss = array();

        $clientSaving = '';
        /**
         * Category App Calculation Start
         */

        $cateogries = array();


        /**
         * Category App Calculation End
         */

        /**
         * Saving Calculation End
         */

        $months = Month::pluck('month', 'id')->all();

        $years = array();

        for ($i = 2015; $i <= 2020; $i++) {
            $years[$i] = $i;
        }

        return view('pages.dashboard.view.saving_view', compact('years', 'cateogries', 'year', 'month', 'months', 'clientSaving', 'clientSavings', 'getuserclients', 'clients', 'selectclients', 'clientdetails', 'projectdetails', 'selectprojects', 'project', 'selectedclient', 'organization'));
    }

    public function marketshareviewmore(Request $request)
    {

        /**
         * Session Data Query start
         */

        $getuserclients = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if (Auth::user()->roll == "2") {
            $clients = clients::whereIn('id', $getuserclients)->where('is_active', 1)->get();
        } else {
            $clients = clients::where('is_active', 1)->where('is_active', 1)->get();
        }
        $selectclients = array();
        $clientdetails = session('adminclient');
        $projectdetails = session('adminproject');

        if (count($clientdetails) > 0) {

            $selectclients = $clientdetails[0];
        }

        if (count($projectdetails) > 0) {
            $selectprojects = $projectdetails;
        } else {
            $selectprojects = '';
        }

        if (!empty($selectclients)) {

            $selectedclient = clients::where('id', $selectclients)->first();
            $project = project::leftJoin('project_clients', 'project_clients.project_id', '=', 'projects.id')
                ->where('project_clients.client_name', $selectclients)
                ->select('projects.*')
                ->get();
        } else {
            $selectedclient = array('image' => '');
            $project = array();
        }

        /**
         * Session Data End
         */


        $userid = Auth::user()->id;
        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');
        }

        $projects = '';
        if ($request->session()->has('adminproject')) {
            $projects = session('adminproject');
        }

        /**
         * Market share Variables
         */
        $unit = $request['unit_value'];

        if (empty($unit)) {
            $unit = 'spend';
        }

        $year = $request['year'];

        if (empty($year)) {
            $year = Current_Year;
        }

        $month = $request['month'];

        if (empty($month)) {
            $month = Current_month;
        }

        /**
         * Marketshare Calculation for Month
         */

        /**
         * Marketshare Calculation Start
         */

        $datas = clientData('', $year, '', $organization, array($projects));

        if ($unit == 'spend') {

            $client_marketshares = client_marketshare($datas);

            $Final_client_marketshare_year = $client_marketshares['marketshare'];
            $final_client_totalspend_year = $client_marketshares['totalspend'];
        } else {

            $totalspends = array_sum(array_column($datas, 'price'));
            $manufacture = array();
            foreach ($datas as $item) {
                $manufacture[$item->manufacturer][] = $item;
            }

            $company = array();

            foreach ($manufacture as $key => $value) {
                $total = array_sum(array_column($value, 'price'));
                $total_device = count($value);
                $company[] = array(
                    'totalspend' => intval($total),
                    'manufacture' => $key,
                    'ms' => intval($total_device),
                );
            }

            $Final_client_marketshare_year = $company;
            $final_client_totalspend_year = $totalspends;
        }
        /**
         * Marketshare Calculation For Month Start
         */

        $Final_client_marketshare_month = array();
        $final_client_totalspend_month = array();
        /**
         * Marketshare Calculation Start
         */

        $datas = clientData($month, $year, '', $organization, array($projects));

        if ($unit == 'spend') {

            $client_marketshares = client_marketshare($datas);

            $Final_client_marketshare_month = $client_marketshares['marketshare'];
            $final_client_totalspend_month = $client_marketshares['totalspend'];
        } else {

            $totalspends = array_sum(array_column($datas, 'price'));
            $manufacture = array();
            foreach ($datas as $item) {
                $manufacture[$item->manufacturer][] = $item;
            }

            $company = array();

            foreach ($manufacture as $key => $value) {
                $total = array_sum(array_column($value, 'price'));
                $total_device = count($value);
                $company[] = array(
                    'totalspend' => intval($total),
                    'manufacture' => $key,
                    'ms' => intval($total_device),
                );
            }

            $Final_client_marketshare_month = $company;
            $final_client_totalspend_month = $totalspends;
        }

        $months = Month::pluck('month', 'id')->all();

        $years = array();

        for ($i = 2015; $i <= 2020; $i++) {
            $years[$i] = $i;
        }
        /**
         * Marketshare Calculation End
         */

        /**
         * Marketshare Month Wise Calculation End
         */

        return view('pages.dashboard.view.marketshare_view', compact('years', 'months', 'year', 'month', 'unit', 'Final_client_marketshare_month', 'Final_client_marketshare_year', 'final_client_totalspend_month', 'final_client_totalspend_year', 'getuserclients', 'clients', 'selectclients', 'clientdetails', 'projectdetails', 'selectprojects', 'project', 'selectedclient', 'organization'));
    }

    /**
     * Neptune Count Function start
     */
    public function neptune(Request $request)
    {

        /**
         * Session Data Query start
         */

        $getuserclients = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if (Auth::user()->roll == "2") {
            $clients = clients::whereIn('id', $getuserclients)->where('is_active', 1)->get();
        } else {
            $clients = clients::where('is_active', 1)->where('is_active', 1)->get();
        }
        $selectclients = array();

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');
        }


        $projectdetails = session('adminproject');

        if (count($organization) > 0) {

            $selectclients = $organization[0];
        }

        if (count($projectdetails) > 0) {
            $selectprojects = $projectdetails;
        } else {
            $selectprojects = '';
        }

        if (!empty($selectclients)) {

            $selectedclient = clients::where('id', $selectclients)->first();
            $project = project::leftJoin('project_clients', 'project_clients.project_id', '=', 'projects.id')
                ->where('project_clients.client_name', $selectclients)
                ->select('projects.*')
                ->get();
        } else {
            $selectedclient = array('image' => '');
            $project = array();
        }

        /**
         * Session Data End
         */

        $user_id = $request->get('user_id');


        if (empty($user_id)) {
            $user_first = User::leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
                ->leftJoin('user_clients', 'user_clients.userId', '=', 'users.id')
                ->where('user_projects.projectId', $selectprojects)
                ->WhereIn('user_clients.clientId', $organization)
                ->where('users.status', 'Enabled')
                ->where('users.roll', 3)
                ->select('users.*')
                ->first();
        } else {
            $user_first = User::where('id', $user_id)->first();
        }

        $user_list = User::leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
            ->leftJoin('user_clients', 'user_clients.userId', '=', 'users.id')
            ->where('user_projects.projectId', $selectprojects)
            ->WhereIn('user_clients.clientId', $organization)
            ->where('users.status', 'Enabled')
            ->where('users.roll', 3)
            ->pluck('users.name', 'users.id')
            ->all();

        $user_id = $user_id == '' ? $user_first['id'] : $user_id;

        $user = GetuserLogin($user_id, $organization);

        $userDetails = userwisedata($user_id, $organization, $selectprojects);

        $client = GetclientLogin($user_id, $organization, $selectprojects);

//        $device = GetDeviceData($user_id, $organization);

        $client_name = clients::where('id', $selectclients)->value('client_name');

        return view('pages.dashboard.neptune', compact('getuserclients', 'user_id', 'clients', 'selectclients', 'clientdetails', 'projectdetails', 'selectprojects', 'project', 'selectedclient', 'organization', 'user', 'client', 'userDetails', 'user_list', 'client_name'));
    }
    /**
     * Neptune Count Function End
     */

    //get category app for dashboard using ajax
    public function getcategoryappajax(Request $request)
    {

        $organization = checkcurrentsession();
        $year = Current_Year;
        if (!empty($request['year'])) {
            $year = $request['year'];
        }

        $oldyear = $year - 1;
        $month = Current_month;
        if (!empty($request['month'])) {
            $month = $request['month'];
        }

        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');
        }

        $projects = '';
        if ($request->session()->has('adminproject')) {
            $projects = session('adminproject');
        }

        $category = category::leftjoin('category_sort', 'category_sort.category_name', '=', 'category.id')
            ->orderBy('category_sort.sort_number', 'ASC')
            ->whereIn('category_sort.client_name', $organization)
            ->where('category.is_active', '=', '1');
        if (!empty($projects)) {
            $category = $category->where('category.project_name', $projects);
        }
        $category = $category->select('category.*')->get();

        $cateogries = array();

        foreach ($category as $category_row) {
            $cateogries[$category_row->short_name] = categoryAppvalue($organization, $category_row->id, $projects, $year, '');
        }

        return $cateogries;
    }

    public function getsavingvalueajax(Request $request)
    {


        $organization = checkcurrentsession();
        $year = Current_Year;
        $oldyear = $year - 1;
        $month = Current_month;


        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');
        }

        $projects = '';
        if ($request->session()->has('adminproject')) {
            $projects = session('adminproject');
        }

        $clientSavings = '';
        $totalsaving = 0;
        $clientSavingss = array();
        $categoryData = category::where('project_name', $projects)
            ->where('is_active', 1)
            ->get();

        if (!empty($categoryData)) {
            for ($i = 1; $i <= 12; $i++) {

                $entrylevel_saving = array();
                $advacnedlevel_saving = array();
                $newadvacnedlevel_saving = array();
                $newentrylevel_saving = array();
                $clientscorecard_saving = array();

                $clientDelta_spend = 0;


                foreach ($categoryData as $row) {

                    $entrylevel_saving[$row->id]['oldyearapp'] = Appcalculationoldyear($organization, 'Entry Level', $oldyear, $row->id, '', array($projects));
                    $entrylevel_saving[$row->id]['newyearapp'] = appvlaueCurrentyear($organization, 'Entry Level', $year, $i, $row->id, '', array($projects));
                    $advacnedlevel_saving[$row->id]['oldyearapp'] = Appcalculationoldyear($organization, 'Advanced Level', $oldyear, $row->id, '', array($projects));
                    $advacnedlevel_saving[$row->id]['newyearapp'] = appvlaueCurrentyear($organization, 'Advanced Level', $year, $i, $row->id, '', array($projects));

                    $newentrylevel_saving[$row->id][] = array_merge($entrylevel_saving[$row->id]['oldyearapp'], $entrylevel_saving[$row->id]['newyearapp']);
                    $newadvacnedlevel_saving[$row->id][] = array_merge($advacnedlevel_saving[$row->id]['oldyearapp'], $advacnedlevel_saving[$row->id]['newyearapp']);

                    $clientscorecard_saving[$row->id] = array_merge($newentrylevel_saving[$row->id], $newadvacnedlevel_saving[$row->id]);

                }

                $finalclients = array();
                $clientDelta_savings = 0;
                foreach ($clientscorecard_saving as $kwy => $vals) {
                    foreach ($vals as $gd) {

                        $olddevice = $gd['oldavgvlaue'];
                        $utilization = $gd['totaldevice'];
                        $newdevice = $gd['currentavgvalue'];

                        if ($olddevice != 0 && $utilization != 0) {
                            $gd['oldSpend'] = $olddevice * $utilization;
                        } else {
                            $gd['oldSpend'] = 0;
                        }

                        if ($newdevice != 0 && $utilization != 0) {
                            $gd['newSpend'] = $newdevice * $utilization;
                        } else {
                            $gd['newSpend'] = 0;
                        }

                        $gd['delta'] = 0;
                        if ($gd['newSpend'] != 0) {
                            $gd['delta'] = $gd['newSpend'] - $gd['oldSpend'];
                        }

                        $clientDelta_savings = $clientDelta_savings + $gd['delta'];
                        $clientDelta_spend = $clientDelta_spend + $gd['newSpend'];

                    }

                }

                $clientSavingss[$i] = array(
                    'totalspend' => round($clientDelta_spend,0),
                    'month' => getMonthName($i),
                    'totalsaving' => round($clientDelta_savings,0),
                );
                $totalsaving = $totalsaving + $clientDelta_savings;
                if ($i == $month) {
                    $clientSavings = $clientDelta_savings;
                }

            }
        }
        $clientSaving = $totalsaving;

        $clientSavings = $clientSavings < 0 ? '<label> $('.number_format(abs(round($clientSavings, 0))).')</label>' : '<label style="color: gold"> $'.number_format(abs(round($clientSavings, 0))).'</label>';
        $clientSaving = $clientSaving < 0 ? '<label> $('.number_format(abs(round($clientSaving, 0))).')</label>' : '<label style="color: gold"> $'.number_format(abs(round($clientSaving, 0))).'</label>';


        $data = array('month' => $clientSavings, 'year' => $clientSaving);
        return $data;
    }

    public function getsavingviewvalueajax(Request $request)
    {

        $organization = checkcurrentsession();
        $year = $request->get('year');
        $oldyear = $year - 1;
        $month = $request->get('month');
        $user_first = $request->get('user_first');


        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');
        }

        $projects = '';
        if ($request->session()->has('adminproject')) {
            $projects = session('adminproject');
        }

        $userSavings = '';
        $totalsaving = 0;
        $client_monthly_Savings = array();

        for ($i = 1; $i <= 12; $i++) {

            $categoryData = category::where('project_name', $projects)->where('is_active', 1)->get();

            $entrylevel_saving = array();
            $advacnedlevel_saving = array();
            $newadvacnedlevel_saving = array();
            $newentrylevel_saving = array();
            $clientscorecard_saving = array();

            $clientDelta_spend = 0;

            foreach ($categoryData as $row) {

                $entrylevel_saving[$row->id]['oldyearapp'] = Appcalculationoldyear($organization, 'Entry Level', $oldyear, $row->id, $user_first['email'], array($projects));
                $entrylevel_saving[$row->id]['newyearapp'] = appvlaueCurrentyear($organization, 'Entry Level', $year, $i, $row->id, $user_first['email'], array($projects));
                $advacnedlevel_saving[$row->id]['oldyearapp'] = Appcalculationoldyear($organization, 'Advanced Level', $oldyear, $row->id, $user_first['email'], array($projects));
                $advacnedlevel_saving[$row->id]['newyearapp'] = appvlaueCurrentyear($organization, 'Advanced Level', $year, $i, $row->id, $user_first['email'], array($projects));

                $newentrylevel_saving[$row->id][] = array_merge($entrylevel_saving[$row->id]['oldyearapp'], $entrylevel_saving[$row->id]['newyearapp']);
                $newadvacnedlevel_saving[$row->id][] = array_merge($advacnedlevel_saving[$row->id]['oldyearapp'], $advacnedlevel_saving[$row->id]['newyearapp']);

                $clientscorecard_saving[$row->id] = array_merge($newentrylevel_saving[$row->id], $newadvacnedlevel_saving[$row->id]);

            }

            $finalclients = array();
            $clientDelta_savings = 0;
            foreach ($clientscorecard_saving as $kwy => $vals) {
                foreach ($vals as $gd) {

                    $olddevice = $gd['oldavgvlaue'];
                    $utilization = $gd['totaldevice'];
                    $newdevice = $gd['currentavgvalue'];

                    if ($olddevice != 0 && $utilization != 0) {
                        $gd['oldSpend'] = $olddevice * $utilization;
                    } else {
                        $gd['oldSpend'] = 0;
                    }

                    if ($newdevice != 0 && $utilization != 0) {
                        $gd['newSpend'] = $newdevice * $utilization;
                    } else {
                        $gd['newSpend'] = 0;
                    }

                    $gd['delta'] = 0;
                    if ($gd['newSpend'] != 0) {
                        $gd['delta'] = $gd['newSpend'] - $gd['oldSpend'];
                    }

                    $clientDelta_savings = $clientDelta_savings + $gd['delta'];
                    $clientDelta_spend = $clientDelta_spend + $gd['newSpend'];

                }

            }

            $client_monthly_Savings[] = array(
                'totalspend' => round($clientDelta_spend,0),
                'month' => getMonthName($i),
                'totalsaving' => round($clientDelta_savings,0),
            );

            $totalsaving = $totalsaving + $clientDelta_savings;

            if ($i == $month) {
                $userSavings = $clientDelta_savings;
            }

        }

        $clientSaving = $totalsaving;


        $userSavings = $userSavings < 0 ? '<label> $('.number_format(abs(round($userSavings, 0))).')</label>' : '<label style="color: gold"> $'.number_format(abs(round($userSavings, 0))).'</label>';
        $clientSaving = $clientSaving < 0 ? '<label> $('.number_format(abs(round($clientSaving, 0))).')</label>' : '<label style="color: gold"> $'.number_format(abs(round($clientSaving, 0))).'</label>';

        $data = array(
            'month' => $userSavings,
            'year' => $clientSaving,
            'monthwise' => $client_monthly_Savings,
        );

        return $data;

    }

    public function getsavingviewvalueajax_client(Request $request)
    {

        $organization = checkcurrentsession();
        $year = $request->get('year');
        $oldyear = $year - 1;
        $month = $request->get('month');
        $user_first = $request->get('user_first');


        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');
        }

        $projects = '';
        if ($request->session()->has('adminproject')) {
            $projects = session('adminproject');
        }


        $userSavings_client = 0;
        $client_monthly_Savings_client = array();
        $totalsaving_client = 0;
        for ($i = 1; $i <= 12; $i++) {

            $categoryData = category::where('project_name', $projects)->where('is_active', 1)->get();

            $entrylevel_saving_client = array();
            $advacnedlevel_saving_client = array();
            $newadvacnedlevel_saving_client = array();
            $newentrylevel_saving_client = array();
            $clientscorecard_saving_client = array();

            $client_spend_wise = 0;

            foreach ($categoryData as $row) {

                $entrylevel_saving_client[$row->id]['oldyearapp'] = Appcalculationoldyear($organization, 'Entry Level', $oldyear, $row->id, '', array($projects));
                $entrylevel_saving_client[$row->id]['newyearapp'] = appvlaueCurrentyear($organization, 'Entry Level', $year, $i, $row->id, '', array($projects));
                $advacnedlevel_saving_client[$row->id]['oldyearapp'] = Appcalculationoldyear($organization, 'Advanced Level', $oldyear, $row->id, '', array($projects));
                $advacnedlevel_saving_client[$row->id]['newyearapp'] = appvlaueCurrentyear($organization, 'Advanced Level', $year, $i, $row->id, '', array($projects));

                $newentrylevel_saving_client[$row->id][] = array_merge($entrylevel_saving_client[$row->id]['oldyearapp'], $entrylevel_saving_client[$row->id]['newyearapp']);
                $newadvacnedlevel_saving_client[$row->id][] = array_merge($advacnedlevel_saving_client[$row->id]['oldyearapp'], $advacnedlevel_saving_client[$row->id]['newyearapp']);

                $clientscorecard_saving_client[$row->id] = array_merge($newentrylevel_saving_client[$row->id], $newadvacnedlevel_saving_client[$row->id]);

            }

            $finalclients = array();
            $client_saving_wises = 0;
            foreach ($clientscorecard_saving_client as $kwys => $values) {
                foreach ($values as $gds) {

                    $olddevice_client = $gds['oldavgvlaue'];
                    $utilization_client = $gds['totaldevice'];
                    $newdevice_client = $gds['currentavgvalue'];

                    if ($olddevice_client != 0 && $utilization_client != 0) {
                        $gds['oldSpend'] = $olddevice_client * $utilization_client;
                    } else {
                        $gds['oldSpend'] = 0;
                    }

                    if ($newdevice_client != 0 && $utilization_client != 0) {
                        $gds['newSpend'] = $newdevice_client * $utilization_client;
                    } else {
                        $gds['newSpend'] = 0;
                    }

                    $gds['delta'] = $gds['newSpend'] - $gds['oldSpend'];

                    $client_saving_wises = $client_saving_wises + $gds['delta'];
                    $client_spend_wise = $client_spend_wise + $gds['newSpend'];

                }

            }

            $client_monthly_Savings_client[] = array(
                'totalspend' => round($client_spend_wise,0),
                'month' => getMonthName($i),
                'totalsaving' => round($client_saving_wises,0),
            );

            $totalsaving_client = $totalsaving_client + $client_saving_wises;

            if ($i == $month) {
                $userSavings_client = $client_saving_wises;
            }

        }

        $client_saving_wise = $totalsaving_client;

        $userSavings_client = $userSavings_client < 0 ? '<label> $('.number_format(abs(round($userSavings_client, 0))).')</label>' : '<label style="color: gold"> $'.number_format(abs(round($userSavings_client, 0))).'</label>';
        $client_saving_wise = $client_saving_wise < 0 ? '<label> $('.number_format(abs(round($client_saving_wise, 0))).')</label>' : '<label style="color: gold"> $'.number_format(abs(round($client_saving_wise, 0))).'</label>';

        $data = array(
            'month' => $userSavings_client,
            'year' => $client_saving_wise,
            'monthwise' => $client_monthly_Savings_client,
        );

        return $data;
    }

    public function getsaving_chart_value_client(Request $request)
    {

        $organization = checkcurrentsession();
        $year = $request->get('year');
        $oldyear = $year - 1;
        $month = $request->get('month');


        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');
        }

        $projects = '';
        if ($request->session()->has('adminproject')) {
            $projects = session('adminproject');
        }

        $user_list_client = User::leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
            ->leftJoin('user_clients', 'user_clients.userId', '=', 'users.id')
            ->where('user_projects.projectId', $projects)
            ->WhereIn('user_clients.clientId', $organization)
            ->where('users.status', 'Enabled')
            ->where('users.roll', 3)
            ->select('users.*')
            ->get();

        $saving_user = array();
        foreach ($user_list_client as $rows) {

            $categoryData_users = category::where('project_name', $projects)->where('is_active', 1)->get();

            $entrylevel_saving_users = array();
            $advacnedlevel_saving_users = array();
            $newadvacnedlevel_saving_users = array();
            $newentrylevel_saving_users = array();
            $clientscorecard_saving_users = array();

            $clientDelta_spend_user = 0;

            foreach ($categoryData_users as $row) {

                $entrylevel_saving_users[$row->id]['oldyearapp'] = Appcalculationoldyear($organization, 'Entry Level', $oldyear, $row->id, $rows->email, array($projects));
                $entrylevel_saving_users[$row->id]['newyearapp'] = appvlaueCurrentyear($organization, 'Entry Level', $year, $month, $row->id, $rows->email, array($projects));
                $advacnedlevel_saving_users[$row->id]['oldyearapp'] = Appcalculationoldyear($organization, 'Advanced Level', $oldyear, $row->id, $rows->email, array($projects));
                $advacnedlevel_saving_users[$row->id]['newyearapp'] = appvlaueCurrentyear($organization, 'Advanced Level', $year, $month, $row->id, $rows->email, array($projects));

                $newentrylevel_saving_users[$row->id][] = array_merge($entrylevel_saving_users[$row->id]['oldyearapp'], $entrylevel_saving_users[$row->id]['newyearapp']);
                $newadvacnedlevel_saving_users[$row->id][] = array_merge($advacnedlevel_saving_users[$row->id]['oldyearapp'], $advacnedlevel_saving_users[$row->id]['newyearapp']);

                $clientscorecard_saving_users[$row->id] = array_merge($newentrylevel_saving_users[$row->id], $newadvacnedlevel_saving_users[$row->id]);

            }

            $finalclients = array();
            $clientDelta_savings_user = 0;
            foreach ($clientscorecard_saving_users as $kwy_user => $vals_user) {
                foreach ($vals_user as $gd_user) {

                    $olddevice = $gd_user['oldavgvlaue'];
                    $utilization = $gd_user['totaldevice'];
                    $newdevice = $gd_user['currentavgvalue'];

                    if ($olddevice != 0 && $utilization != 0) {
                        $gd_user['oldSpend'] = $olddevice * $utilization;
                    } else {
                        $gd_user['oldSpend'] = 0;
                    }

                    if ($newdevice != 0 && $utilization != 0) {
                        $gd_user['newSpend'] = $newdevice * $utilization;
                    } else {
                        $gd_user['newSpend'] = 0;
                    }

                    $gd_user['delta'] = 0;
                    if ($gd_user['newSpend'] != 0) {
                        $gd_user['delta'] = $gd_user['newSpend'] - $gd_user['oldSpend'];
                    }

                    $clientDelta_savings_user = $clientDelta_savings_user + $gd_user['delta'];
                    $clientDelta_spend_user = $clientDelta_spend_user + $gd_user['newSpend'];

                }
            }

            $saving_user[] = array(
                'user_name' => $rows->name,
                'saving' => round($clientDelta_savings_user,0),
                'spend' => round($clientDelta_spend_user, 0),
            );

        }


        return $this->array_sort_by_column($saving_user, 'saving');
    }

    function array_sort_by_column($arr, $col, $dir = SORT_DESC)
    {
        $sort_col = array();
        foreach ($arr as $key => $row) {
            $sort_col[$key] = $row[$col];
        }

        array_multisort($sort_col, $dir, $arr);


        return $arr;
    }

    public function savings(Request $request)
    {


        /**
         * Session Data Query start
         */

        $getuserclients = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if (Auth::user()->roll == "2") {
            $clients = clients::whereIn('id', $getuserclients)->where('is_active', 1)->get();
        } else {
            $clients = clients::where('is_active', 1)->where('is_active', 1)->get();
        }
        $selectclients = array();
        $clientdetails = session('adminclient');
        $projectdetails = session('adminproject');

        if (count($clientdetails) > 0) {

            $selectclients = $clientdetails[0];
        }

        if (count($projectdetails) > 0) {
            $selectprojects = $projectdetails;
        } else {
            $selectprojects = '';
        }

        if (!empty($selectclients)) {

            $selectedclient = clients::where('id', $selectclients)->first();
            $project = project::leftJoin('project_clients', 'project_clients.project_id', '=', 'projects.id')
                ->where('project_clients.client_name', $selectclients)
                ->select('projects.*')
                ->get();
        } else {
            $selectedclient = array('image' => '');
            $project = array();
        }


        /**
         * Session Data End
         */
        $user_id = $request['user_id'];

        $organization = userClients::where('userId', Auth::user()->id)->select('clientId')->get();
        if ($request->session()->has('adminclient')) {
            $organization = session('adminclient');
        }

        $projects = '';
        if ($request->session()->has('adminproject')) {
            $projects = session('adminproject');
        }

        $client_name = $organization[0];
        $user_first = array();
        if (count($user_id) > 0) {
            $user_first = User::leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
                ->leftJoin('user_clients', 'user_clients.userId', '=', 'users.id')
                ->where('user_projects.projectId', $projects)
                ->WhereIn('user_clients.clientId', $organization)
                ->where('users.status', 'Enabled')
                ->where('users.roll', 3)
                ->whereIn('users.id', $user_id)
                ->select('users.*')
                ->get();
        }

        $user_list = User::leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
            ->leftJoin('user_clients', 'user_clients.userId', '=', 'users.id')
            ->where('user_projects.projectId', $projects)
            ->WhereIn('user_clients.clientId', $organization)
            ->where('users.status', 'Enabled')
            ->where('users.roll', 3)
            ->pluck('users.name', 'users.id')
            ->all();

        $months = Month::pluck('month', 'id')->all();

        $month = $request['month'];

        if(empty($month)){
            $month = Current_month;
        }
        $year = $request['year'];

        if(empty($year)){
            $year = Current_Year;
        }
        $years = array();

        for ($i = 2015; $i <= 2020; $i++) {
            $years[$i] = $i;
        }

        $oldyear = $year - 1;


        return view('pages.dashboard.view.savings', compact('client_name','user_id', 'month', 'months', 'years', 'year', 'user_list', 'clients', 'user_first', 'selectclients', 'clientdetails', 'projectdetails', 'selectprojects', 'project', 'selectedclient', 'organization'));
    }

}
