<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class device extends Model
{
    protected $table = 'device';

    protected $fillable = [
    	'level_name','project_name','category_name','manufacturer_name','device_name','model_name','device_image','rep_email','status','exclusive','exclusive_check','longevity','longevity_check','shock','shock_check','size','size_check','research','research_check','website_page','website_page_check','url','overall_value','overall_value_check','is_delete',
    	'exclusive_side','longevity_side','shock_side','size_side','research_side','websitepage_side','url_side','overall_value_side','performance','research_email'
        ];

    public function projects()
    {
        return $this->belongsTo('App\project','project_name');
    }

    public function categories()
    {
        return $this->belongsTo('App\category','category_name');
    }


    public function manufacturer()
   	{
   		return $this->belongsTo('App\manufacturers','manufacturer_name');
   	}

    public function orders()
    {
      return $this->hasMany('App\order','deviceId');
    }

    public function clientprice()
    {
        return $this->hasMany('App\client_price','device_id');
    }



     public static function client(){
        return static::leftjoin('project_clients','project_clients.project_id','=','device.project_name')
                     ->select('device.*','project_clients.client_name');
    }

    public function serial()
    {
        return $this->hasMany('App\Serialnumber','deviceId');
    }

    public function physciansPreferenceAnswer()
    {
        return $this->hasMany('App\physciansPreferenceAnswer','deviceId');
    }

}
