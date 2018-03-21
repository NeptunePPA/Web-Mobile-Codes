<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SerialnumberDetail extends Model
{
    protected $table = 'serialdetail';

    protected $fillable = [
        'serialNumber','status','serialId','clientId','deviceId','discount','purchaseDate','expiryDate','purchaseType','swapType','ischanged'
        ];

    public function client(){

        return $this->belongsTo('App\clients','clientId');
    }

    public function devices()
    {
        return $this->belongsTo('App\device','deviceId');
    }
}
