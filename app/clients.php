<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class clients extends Model
{

    protected $fillable = [
        'item_no', 'client_name', 'street_address', 'city', 'state', 'is_active', 'is_delete','image'
    ];

    protected $table = 'clients';

    /*get projectname*/
    public function userclients()
    {
        return $this->hasMany('App\userClients', 'clientId');
    }

    public function survey()
    {
        return $this->hasMany('App\physciansPreference', 'clientId');
    }

    public function serial()
    {
        return $this->hasMany('App\Serialnumber', 'clientId');
    }

    public function contact()
    {
        return $this->hasMany('App\customContact', 'clientId');
    }


    /*get statename*/
    public function statename()
    {
        return $this->belongsTo('App\state', 'state');
    }

    /*projectclients*/
    public function projectclients()
    {
        return $this->hasMany('App\project_clients', 'client_name');
    }

    /*itemfiles*/
    public function ItemFileMain()
    {
        return $this->hasMany('App\Itemfiles', 'clientId');
    }

    /*organization analytics*/
    public static function organizationanalytics()
    {

        return static::leftJoin('user_clients', 'user_clients.clientId', '=', 'clients.id')
            ->leftJoin('project_clients', 'project_clients.client_name', '=', 'clients.id')
            ->select('clients.*', DB::raw('count(user_clients.userId) as users'), DB::raw('count(project_clients.project_id) as projects'))
            ->groupBy('clients.id', '')->distinct();

    }

    /*orderclients*/
    public function clientorders()
    {

        return $this->hasMany('App\order', 'clientId');
    }

    public function itemfile()
    {

        return $this->hasMany('App\ItemFileMain', 'clientId');
    }

    public static function organizationanal()
    {

        return static::leftjoin('user_clients', 'user_clients.clientId', '=', 'clients.id')
            ->leftjoin('users', 'users.id', '=', 'user_clients.userId')
            ->leftjoin('loginuser', 'loginuser.userId', '=', 'users.id')
            ->select('clients.*', DB::raw('count(loginuser.userId) as login'));
    }

    public function physciansPreferenceAnswer()
    {
        return $this->hasMany('App\physciansPreferenceAnswer', 'clientId');
    }


}
