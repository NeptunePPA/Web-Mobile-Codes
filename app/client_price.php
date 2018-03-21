<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class client_price extends Model
{
    protected $table = 'client_price';

    public function devices()
    {
        return $this->belongsTo('App\device','device_id');
    }
}
