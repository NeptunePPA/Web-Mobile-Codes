<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemfileDetails extends Model
{
    protected $table = 'item_files_details';

    protected $fillable = [
    	'company','category','supplyItem','mfgPartNumber','hospitalNumber','doctors','fileId','clientId','projectId','email'];

    /*client name*/
    public function clientname(){
      return $this->belongsTo('App\clients','clientId');
    }

    public function itemmain()
    {
    	return $this->hasMany('App\ItemFileEntry','supplyItem');
    }
}
