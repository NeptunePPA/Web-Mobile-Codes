<?php

use App\userClients;
use App\clients;
use App\project;


function checkcurrentsession()
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
        if (!empty($clientdetails)) {
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
      return $getuserclients;
}