<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class SurveyAnswer extends Model
{
     protected $table = 'survey_answer';

    protected $fillable = [
    	'user_id','surveyId','que_1','que_1_check','que_1_answer','que_2','que_2_check','que_2_answer','que_3','que_3_check','que_3_answer','que_4','que_4_check','que_4_answer','que_5','que_5_check','que_5_answer','que_6','que_6_check','que_6_answer','que_7','que_7_check','que_7_answer','que_8','que_8_check','que_8_answer','deviceId','flag'
    	];

    public function survey()
    {
    	return $this->belongsTo('App\Survey','surveyId');
    }

    public function user()
    {
    	return $this->belongsTo('App\User','user_id');
    }

    public static function username(){
        return static::leftjoin('users', 'users.id', '=', 'survey_answer.user_id')
        ->select('survey_answer.*', 'users.name', 'survey_answer.user_id as user');
    }

    public function device(){

        return $this->belongsTo('App\device','deviceId');

    }

    public static function analytics(){
        return static::leftjoin('survey','survey.id','=','survey_answer.surveyId')
                    ->leftjoin('clients','clients.id','=','survey.clientId')
                    ->leftjoin('device','device.id','=','survey.deviceId')
                    ->select('survey.*',DB::raw('count(survey_answer.surveyId) as surveyorder'),'clients.client_name','device.device_name');
    }
}
