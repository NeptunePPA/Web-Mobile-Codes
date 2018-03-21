<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Serialnumber extends Model
{
    protected $table = 'serialnumber';

    protected $fillable = [
        'serialFile','clientId','deviceId'];

    public function client(){

        return $this->belongsTo('App\clients','clientId');

    }

    public function device(){
        return $this->belongsTo('App\device','deviceId');
    }
}
