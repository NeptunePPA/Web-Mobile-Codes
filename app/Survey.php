<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Survey extends Model
{
    protected $table = 'survey';

    protected $fillable = [
    	'clientId','que_1','que_1_check','que_2','que_2_check','que_3','que_3_check','que_4','que_4_check','que_5','que_5_check','que_6','que_6_check','que_7','que_7_check','que_8','que_8_check','status','deviceId'
    	];

    public function client(){

	    return $this->belongsTo('App\clients','clientId');

	}

	public static function clientname(){
	  	return static::leftjoin('clients', 'clients.id', '=', 'survey.clientId')
	  			->leftjoin('device','device.id','=','survey.deviceId')
	            ->select('survey.*', 'clients.client_name', 'survey.clientId as client','device.device_name');
	}

	public function surveyanswer(){
		return $this->hasMany('App\SurveyAnswer','surveyId');
	}

	public function device(){

	    return $this->belongsTo('App\device','deviceId');

	}
}
