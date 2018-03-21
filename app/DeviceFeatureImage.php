<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceFeatureImage extends Model
{
    protected $table = 'device_feature_image';

    protected $fillable = [
        'exclusiveimage','longevityimage','shockimage','sizeimage','researchimage','websiteimage','urlimage','overallimage','performanceImage'
    ];
}
