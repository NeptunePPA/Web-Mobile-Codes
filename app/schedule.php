<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class schedule extends Model
{
    protected $table = 'schedule';

    protected $fillable = ['project_name', 'client_name', 'physician_name','patient_id','manufacturer','device_name','model_no', 'rep_name','event_date','start_time','status','is_delete'];
}
