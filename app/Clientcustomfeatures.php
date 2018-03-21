<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientcustomfeatures extends Model
{
    protected $table = 'client_custom_field';

    protected $fillable = [
    	'device_id','client_name','c_id','field_check','fileld_delta_check','fileld_highlight'];
}
