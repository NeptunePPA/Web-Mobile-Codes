<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userClients extends Model
{
     protected $fillable = [
      		'userId','clientId'
     ];

     protected $table='user_clients';

     /*get clientname*/
    public function clientname(){
        return $this->belongsTo('App\clients','clientId');
    }

    /*get userclient*/
    public function users(){
    	return $this->belongsTo('App\User','userId');
    }
}
