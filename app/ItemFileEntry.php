<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemFileEntry extends Model
{
    protected $table = 'item_file_entry';

    protected $fillable = [
    	'repcaseID','supplyItem','hospitalPart','mfgPartNumber','quantity','purchaseType','serialNumber','poNumber','itemMainId','status','orderId','oldOrderStatus','category','manufacturer','swapDate','projectId','swapId','oldId',
        'swappedId','completeNew','newSwapDate','swapType','dataId','isImplanted','scenario','cco_check','repless_check'];

    	public function itemfilename()
    	{
    		return $this->belongsTo('App\ItemFileMain','itemMainId');
    	}

    	public function itemdetails(){
      		return $this->belongsTo('App\ItemfileDetails','supplyItem');
    	}

        public static function itemdata(){
             return static::leftjoin('item_file_main', 'item_file_main.id', '=', 'item_file_entry.itemMainId')
                ->leftjoin('clients','clients.id','=','item_file_main.clientId')
                ->leftjoin('projects','projects.id','=','item_file_main.projectId')
                ->leftjoin('user_clients','user_clients.clientId','=','item_file_main.clientId')
                 ->leftjoin('users','users.id','=','item_file_main.repUser')
                ->select('item_file_entry.*', 'item_file_main.produceDate as produceDate','item_file_main.physician as physician','item_file_main.projectId as projectId','clients.client_name as client_name','projects.project_name as project_name','users.name as repUser');
        }
}
