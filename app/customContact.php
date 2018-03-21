<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class customContact extends Model
{
    protected $table = 'custom_contact_info';

    protected $fillable = [
        'clientId','deviceId','order_email','cc1','cc2','cc3','cc4','cc5','cc6','subject','cc1Number','cc2Number','cc3Number'
        ,'cc4Number','cc5Number','cc6Number','orderNumber'
    	];

    public function client(){

	    return $this->belongsTo('App\clients','clientId');

	}

	public function user(){
		return $this->belongsTo('App\User','order_email');
	}

	
    public static function clientname(){
	  	return static::leftjoin('clients', 'clients.id', '=', 'custom_contact_info.clientId')->leftjoin('users', 'users.id', '=', 'custom_contact_info.order_email')
	            ->select('custom_contact_info.*', 'clients.client_name', 'custom_contact_info.clientId as client','users.email', 'custom_contact_info.order_email as mail');
	}
}
