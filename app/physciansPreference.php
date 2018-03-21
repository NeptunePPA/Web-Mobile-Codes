<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class physciansPreference extends Model
{
    protected $table = 'physciansPreference';
    protected $fillable = [
        'clientId', 'deviceId','question','check','flag'
    ];

    public function client(){

        return $this->belongsTo('App\clients','clientId');

    }

    public static function clientname(){
        return static::leftjoin('clients', 'clients.id', '=', 'physciansPreference.clientId')
            ->leftjoin('device','device.id','=','physciansPreference.deviceId')
            ->select('physciansPreference.*', 'clients.client_name', 'physciansPreference.clientId as client','device.device_name');
    }

}
