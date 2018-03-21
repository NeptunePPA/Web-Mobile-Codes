<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceRequest extends Model
{
    protected $table = 'device_request';

    protected $fillable = [
        'projectName','categoryName','deviceName','message','userId'
    ];
}
