<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RepContact extends Model
{
   protected $table = 'rep_contact_info';

    protected $fillable = [
    	'deviceId','repId','repStatus'
    		 ];
    
}
