<?php

namespace App\Console\Commands;

use Mail;
use App\schedule;
use App\User;
use App\clients;
use Illuminate\Console\Command;

class schedulereminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending emails for schedule.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        
		$now = date('d-m-Y');
		$schedules = schedule::join('projects', 'projects.id', '=', 'schedule.project_name')
							->join('users', 'users.id', '=', 'schedule.physician_name')
							->join('manufacturers', 'manufacturers.id', '=', 'schedule.manufacturer')
							->join('device', 'device.id', '=', 'schedule.device_name')
							->join('clients', 'clients.id', '=', 'schedule.client_name')
							->select('schedule.*', 'clients.client_name', 'users.name', 'manufacturers.manufacturer_name', 'device.device_name as device', 'projects.project_name as pro_name')
							->where('schedule.status','=','Active')
							->where('schedule.event_date','>',$now)
							->orderby('schedule.id','DESC')
							->get();
							
                foreach ($schedules as $schedule) {
                    $title = "Welcome to Neptune-PPA - Schedule ";
                    $projectname = $schedule->pro_name;
                    $clientname = $schedule->client_name;
                    $physician = $schedule->name;
                    $patientid = $schedule->patient_id;
                    $manufacturer = $schedule->manufacturer_name;
                    $device = $schedule->device;
                    $model_name = $schedule->model_no;
                    $rep_name = $schedule->rep_name;
                    $event_date = $schedule->event_date;
                    $start_time = $schedule->start_time;
					
					$physicianid = $schedule->physician_name;
					
				
                    $data = array('title' => $title, 'projectname' => $projectname, 'clientname' => $clientname, 'physician' => $physician, 'patient_id' => $patientid, 'manufacturer' => $manufacturer, 'device' => $device, 'model_no' => $model_name, 'rep_name' => $rep_name, 'event_date' => $event_date, 'start_time' => $start_time,'physicianid'=>$physicianid);
                
				
					$oneday = $event_date - $now;
					$threeday = $event_date - $now;
					$week = $event_date - $now;
				
					
					if($oneday == 1 || $threeday == 3 || $week == 7)
					{
						Mail::send('emails.createschedule',$data,function($message) use ($data){
						
								$repemail = user::where('name','=',$data['rep_name'])
											->where('roll','=',5)
											->where('status','=','Enabled')
											->value('email');
								$physicianmail = user::where('id','=',$data['physicianid'])
												->where('roll','=',3)
												->where('status','=','Enabled')
												->value('email');
								
								if($repemail != "")
								{
									$message->to($repemail);
								}
								
								if($physicianmail != "")
								{
									$message->to($physicianmail);
								}
									$message->from('admin@neptuneppa.com')->subject($data['title']);
								$organization = clients::where('client_name','=',$data['clientname'])->value('id');
								$get_user_emails = user::where('roll','=',2)
													->where('organization','=',$organization)
													->where('status','=','Enabled')
													->where('is_delete','=',0)
													->get();
								foreach ($get_user_emails as $user_email) 
								{
										if($user_email != "")
										{
											$message->to($user_email->email);
										}
								} 
							
						});
					}
		
			}
		
    }
}
