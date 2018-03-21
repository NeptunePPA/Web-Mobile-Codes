<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class project_clients extends Model
{
    protected $table = 'project_clients'; 


    /*projectclients*/
    public function clientname(){
    	return $this->belongsTo('App\clients','client_name');
    }

    public function projectname(){
    	return $this->belongsTo('App\project','project_id');
    } 
}
