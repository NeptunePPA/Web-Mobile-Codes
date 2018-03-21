<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userProjects extends Model
{
     protected $fillable = [
      		'userId','projectId'
     ];

     protected $table='user_projects';

     /*get projectname*/
    public function projectname(){
        return $this->belongsTo('App\project','projectId');
    }

    /*get usersproject*/
    public function users(){
    	return $this->belongsTo('App\User','userId');
    }
    

}
