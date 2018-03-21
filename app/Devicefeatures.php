<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Devicefeatures extends Model
{
    protected $table = 'device_features';

    protected $fillable = [
    	'device_id','client_name','longevity_check','shock_check','size_check','research_check','siteinfo_check','overall_value_check','longevity_delta_check','shock_delta_check','size_delta_check',
        'research_delta_check','site_info_delta_check','overall_value_delta_check','longevity_highlight','shock_highlight','size_highlight','research_highlight','siteinfo_highlight','overall_value_highlight'
    ];
}
