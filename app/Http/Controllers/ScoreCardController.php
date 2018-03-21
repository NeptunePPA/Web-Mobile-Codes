<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\roll;
use App\User;
use Auth;
use App\ScoreCard;
use App\ScoreCardImage;
use App\Month;
use App\clients;
use Session;


class ScoreCardController extends Controller
{

    public function index(Request $request)
    {
        $data = $request->all();


        /*get selected clientdetails*/
        $clientdetails = session('details');
        $clients = $clientdetails['clients'];

        $dtype = session('dtype');

        $devicetype = $dtype['devicetype'];
        $updatedate = $dtype['updatedate'];

        $clientname = clients::where('id', '=', $clients)->value('client_name');
        
        if (empty($data)) {
            $year = ['' => 'Select Year'] + ScoreCard::where('userId', Auth::user()->id)->orderBy('id', 'asc')->groupBy('year')->pluck('year', 'id')->all();


            $userId = Auth::user()->id;
            if ($request->session()->has('phyname')) {
                $userId = session('phyname');
            }

        } else if (!empty($data['physician'])) {

            $year = ['' => 'Select Year'] + ScoreCard::where('userId', $data['physician'])->orderBy('id', 'asc')->groupBy('year')->pluck('year', 'id')->all();

            $userId = $data['physician'];

            if (Auth::user()->roll == 2) {
                Session::put('phyname', $userId);
            }
        }
        $userdetails = User::where('id', $userId)->first();
        $username = $userdetails['name'];
        $projectname = $userdetails->prname['project_name'];

        $scorecarddate = ScoreCard::leftJoin('scorecard_images', 'scorecard_images.scorecardId', '=', 'scorecards.id')
            ->where('scorecards.userId', $userId)
            ->orderBy('scorecard_images.created_at', 'desc')
            ->first();


        return view('pages.frontend.scorecard', compact('year', 'clientname', 'userId', 'devicetype', 'updatedate', 'username', 'projectname', 'scorecarddate'));
    }

    public function getMonth()
    {

        $scoreId = Input::get('scoreId');
        $userId = Input::get('userId');

        $year = ScoreCard::where('id', $scoreId)->where('userId', $userId)->first();

        $data = ScoreCard::month()->where('year', $year['year'])->where('userId', $userId)->get();

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

    public function getImage($id)
    {
        $clientdetails = session('details');
        $clients = $clientdetails['clients'];

        $dtype = session('dtype');

        $devicetype = $dtype['devicetype'];
        $updatedate = $dtype['updatedate'];

        $clientname = clients::where('id', '=', $clients)->value('client_name');

        $userId = ScoreCard::where('id', $id)->value('userId');

        $image = ScoreCardImage::where('scorecardId', $id)->get();

        $userdetails = User::where('id', $userId)->first();
        $username = $userdetails['name'];
        $projectname = $userdetails->prname['project_name'];

        $scorecarddate = ScoreCard::leftJoin('scorecard_images', 'scorecard_images.scorecardId', '=', 'scorecards.id')
            ->where('scorecards.userId', $userId)
            ->orderBy('scorecard_images.created_at', 'desc')
            ->first();

        return view('pages.frontend.scorecardImage', compact('image', 'clientname', 'userId', 'devicetype', 'updatedate', 'username', 'projectname', 'scorecarddate'));
    }


    public function physician()
    {
        $clientdetails = session('details');
        $clients = $clientdetails['clients'];
        $project = $clientdetails['projects'];

        $dtype = session('dtype');

        $devicetype = $dtype['devicetype'];
        $updatedate = $dtype['updatedate'];

        $clientname = clients::where('id', '=', $clients)->value('client_name');

        $physician = ['' => 'Select Physician'] + User::leftjoin('user_clients', 'user_clients.userId', '=', 'users.id')
                ->leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
                ->select('users.*', 'user_clients.clientId')->where('user_clients.clientId', $clients)
                ->where('user_projects.projectId', $project)
                ->orderBy('users.id', 'asc')
                ->where('users.roll', '3')
                ->where('users.is_delete','0')
                ->where('users.status','Enabled')
                ->groupBy('user_clients.userId')
                ->pluck('users.name', 'users.id')->all();

        $userId = Auth::user()->id;
        $userdetails = User::where('id', $userId)->first();

        $scorecarddate = ScoreCard::leftJoin('scorecard_images', 'scorecard_images.scorecardId', '=', 'scorecards.id')
            ->where('scorecards.userId', $userId)
            ->orderBy('scorecard_images.created_at', 'desc')
            ->first();


        return view('pages.frontend.scorecardphy', compact('physician', 'clientname', 'devicetype', 'updatedate', 'scorecarddate'));

    }


    public function year($id)
    {


        /*get selected clientdetails*/
        $clientdetails = session('details');
        $clients = $clientdetails['clients'];

        $dtype = session('dtype');

        $devicetype = $dtype['devicetype'];
        $updatedate = $dtype['updatedate'];

        $clientname = clients::where('id', '=', $clients)->value('client_name');


        $year = ['' => 'Select Year'] + ScoreCard::where('userId', $id)->orderBy('id', 'asc')->groupBy('year')->pluck('year', 'id')->all();

        $userId = $id;

        $userdetails = User::where('id', $userId)->first();
        $username = $userdetails['name'];
        $projectname = $userdetails->prname['project_name'];

        $scorecarddate = ScoreCard::leftJoin('scorecard_images', 'scorecard_images.scorecardId', '=', 'scorecards.id')
            ->where('scorecards.userId', $userId)
            ->orderBy('scorecard_images.created_at', 'desc')
            ->first();


        // dd($username);
        return view('pages.frontend.scorecard', compact('year', 'clientname', 'userId', 'devicetype', 'updatedate', 'username', 'projectname', 'scorecarddate'));
    }
}
