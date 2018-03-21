<?php

use Illuminate\Database\Seeder;
use App\roll;
use App\User;
use App\project;
use App\project_clients;
use App\clients;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
    	$client = new clients();
        $client->item_no = "25453";
        $client->client_name = "test client";
        $client->street_address = "Varchha, Surat";
        $client->city = "Surat";
        $client->state = "1";
        $client->is_delete = "0";
        $client->is_active = "0";
        $client->save();


        $project = new project();
        $project->project_name = "Test Project";
        $project->is_delete = "0";
        $project->save();

        $projectclients = new project_clients();
        $projectclients->project_id = "1";
        $projectclients->client_name = "1";
        $projectclients->save();


        $masteradmin = new user();
        $masteradmin->name = "dhaval";
        $masteradmin->email = "thummardhaval64@gmail.com";
        $masteradmin->organization = "";
        $masteradmin->org_type = "";
        $masteradmin->roll = "1";
        $masteradmin->projectname = "1";
        $masteradmin->status = "Enabled";
        $masteradmin->password = Hash::make("admin");
        $masteradmin->is_delete = "0";
        $masteradmin->is_agree = "0";
        $masteradmin->save();
    }
}
