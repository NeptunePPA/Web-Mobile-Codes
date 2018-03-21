<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $table = 'orders'; 

     protected $fillable = [
        'manufacturer_name','model_name','model_no','unit_cost','system_cost','cco','reimbrusement','order_date','orderby', 'rep','sent_to','status','bulk_check','is_delete','is_archive','created_at','updated_at','clientId','deviceId'
    ];

    public function devicename()
    {
          return $this->belongsTo('App\device','deviceId');
    }


    public function user(){
    	return $this->belongsTo('App\User','orderby');
	}

    /*orderclients*/
    public function orderclients()
    {
    	 return $this->belongsTo('App\clients','clientId');
    }

    /*manufacturer name*/
    public function manufacturer(){
        return $this->belongsTo('App\manufacturers','manufacturer_name');
    }
    


}
