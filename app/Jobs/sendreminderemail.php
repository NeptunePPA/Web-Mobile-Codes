<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendreminderemail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
	 
	protected $data;
	
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->data;
		
		Mail::send('emails.createschedule.',$data,function($message) use ($data){
		
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
                    $message->from('thummardhaval64@gmail.com')->subject($data['title']);
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
