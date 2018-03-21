<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginUser extends Model
{
   protected $fillable = [
      		'userId'
     ];

     protected $table='loginuser';

      public function loginuser(){
        return $this->belongsTo('App\User','userId');
    }

}
