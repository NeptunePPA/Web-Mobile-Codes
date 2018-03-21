<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itemfiles extends Model
{
    protected $table = 'item_files';

    protected $fillable = [
    	'clientId','itemFile','projectId','createDate','updateDate'];

    /*client name*/
    public function clientname(){
      return $this->belongsTo('App\clients','clientId');
    }

    public function projectname(){
        return $this->belongsTo('App\project','projectId');
    }


}
