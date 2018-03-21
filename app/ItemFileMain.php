<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemFileMain extends Model
{
    protected $table = 'item_file_main';

    protected $fillable = [
        'repcaseID', 'produceDate', 'clientId', 'physician', 'projectId','repUser','phyEmail'];

    public function itemfile()
    {
        return $this->hasMany('App\ItemFileEntry', 'itemMainId');
    }

    public function client()
    {

        return $this->belongsTo('App\clients', 'clientId');

    }

    public function projectname()
    {
        return $this->belongsTo('App\project', 'projectId');
    }

    public function users(){
        return $this->belongsTo('App\User','repUser');
    }
}
