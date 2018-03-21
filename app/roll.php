<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class roll extends Model
{
	 protected $fillable = [
      		'roll_name','is_delete'
     ];

     protected $table='roll';


     public function users(){

     	return $this->hasMany('App\User','roll');

     }
}
