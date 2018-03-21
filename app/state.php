<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class state extends Model
{
    protected $table = 'state'; 

    /*state with client*/
    public function clientname(){
    	return $this->hasMany('App\clients','state');
    }

}
