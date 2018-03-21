<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class project extends Model
{
    protected $fillable = [
      		'project_name','is_delete'
     ];

     protected $table='projects';

     /*get projectname*/
    public function userproject(){
        return $this->hasMany('App\userProjects','projectId');
    }

    /*get projectclients*/
    public function projectclients(){
    	return $this->hasMany('App\project_clients','project_id');
    }

    /*get single projectname*/
    public function username(){
        return $this->hasMany('App\User','projectname');
    }

    public function projectitemfile(){
        return $this->hasMany('App\Itemfiles','projectId');
    }

    public function itemfilename()
    {
        return $this->belongsTo('App\ItemFileMain','projectId');
    }

    public function deviceProject(){
        return $this->hasMany('App\device','project_name');
    }
}
