<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class physciansPreferenceAnswer extends Model
{
    protected $table = 'physciansPreferenceAnswer';
    protected $fillable = [
        'clientId', 'deviceId','userId','question','answer','check','flag','preId'
    ];

    public function doctor(){
        return $this->belongsTo('App\User','userId');
    }

    public function clientName(){
        return $this->belongsTo('App\clients','clientId');
    }

    public function devicedata(){
        return $this->belongsTo('App\device','deviceId');
    }

    public static function surveyData(){
        return static::leftjoin('device','device.id','=','physciansPreferenceAnswer.deviceId')
            ->leftjoin('physciansPreference','physciansPreference.id','=','physciansPreferenceAnswer.preId')
            ->select('physciansPreferenceAnswer.*',DB::raw('sum(physciansPreferenceAnswer.answer = "True") as queanswer_yes'),DB::raw('sum(physciansPreferenceAnswer.answer = "False") as queanswer_no'),'device.category_name','physciansPreference.question as que')
            ->groupBy('physciansPreferenceAnswer.deviceId', 'physciansPreferenceAnswer.userId', 'physciansPreferenceAnswer.preId');
    }

    public static function searchsurvey(){
        return static::leftjoin('device','device.id','=','physciansPreferenceAnswer.deviceId')
            ->leftjoin('clients','clients.id','=','physciansPreferenceAnswer.clientId')
            ->leftjoin('users','users.id','=','physciansPreferenceAnswer.userId')
            ->leftjoin('projects','projects.id','=','device.project_name')
            ->leftjoin('category','category.id','=','device.category_name')
            ->leftjoin('manufacturers','manufacturers.id','=','device.manufacturer_name')
//            ->leftjoin('physciansPreference','physciansPreference.id','=','physciansPreferenceAnswer.preId')
            ->select('physciansPreferenceAnswer.*',DB::raw('sum(physciansPreferenceAnswer.answer = "True") as queanswer_yes'),DB::raw('sum(physciansPreferenceAnswer.answer = "False") as queanswer_no')
                ,'device.category_name','clients.client_name','users.name','projects.project_name','category.category_name','manufacturers.manufacturer_name','device.device_name','device.level_name')
            ->groupBy('physciansPreferenceAnswer.deviceId','physciansPreferenceAnswer.question', 'physciansPreferenceAnswer.userId');

    }

}
