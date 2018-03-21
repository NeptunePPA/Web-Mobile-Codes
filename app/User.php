<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $fillable = [
        'name', 'email', 'organization', 'org_type', 'roll', 'projectname', 'status', 'is_delete', 'is_agree', 'password', 'mobile', 'title', 'profilePic'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /*get rolename*/
    public function role()
    {
        return $this->belongsTo('App\roll', 'roll');
    }

    /*get usersproject*/
    public function usersproject()
    {
        return $this->hasMany('App\userProjects', 'userId');
    }

    /*get userclient*/
    public function userclients()
    {
        return $this->hasMany('App\userClients', 'userId');
    }

    public function surveyuser()
    {
        return $this->hasMany('App\SurveyAnswer', 'user_id');
    }

    public function customcontact()
    {
        return $this->hasMany('App\customContact', 'order_email');
    }

    public function orders()
    {
        return $this->hasMany('App\order', 'orderby');
    }

    public function login()
    {
        return $this->hasMany('App\LoginUser', 'userId');
    }

    public function manufacture()
    {
        return $this->belongsTo('App\manufacturers', 'organization');
    }

    public static function manufaturename()
    {
        return static::leftjoin('manufacturers', 'manufacturers.id', '=', 'users.organization')
            ->select('users.*', 'manufacturers.manufacturer_name', 'users.organization as company');
    }

    public static function repcontact()
    {
        return static::leftjoin('manufacturers', 'manufacturers.id', '=', 'users.organization')
            ->leftjoin('rep_contact_info', 'rep_contact_info.repId', '=', 'users.id')
            ->leftjoin('user_clients', 'user_clients.userId', '=', 'users.id')
            ->leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
            ->leftjoin('clients', 'clients.id', '=', 'user_clients.clientId')
            ->select('users.*', 'manufacturers.manufacturer_name', 'user_clients.clientId', 'users.organization as company', 'clients.client_name', 'user_projects.projectId');
    }

    public function prname()
    {
        return $this->belongsTo('App\project', 'projectname');
    }

    public static function useranalytics()
    {

        return static::leftjoin('loginuser', 'loginuser.userId', '=', 'users.id')
            ->leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
            ->leftjoin('orders', 'orders.orderby', '=', 'users.id')
            ->leftjoin('user_clients', 'user_clients.userId', '=', 'users.id')
            ->leftjoin('projects','projects.id','=','user_projects.projectId')
            ->leftjoin('clients', 'clients.id', '=', 'user_clients.clientId')
            ->select('users.*', 'clients.client_name','projects.project_name')
            ->where('users.roll', '3')
            ->where('users.is_delete', '0');

    }


    public static function physician()
    {
        return static::leftjoin('user_clients', 'user_clients.userId', '=', 'users.id')
            ->select('users.*', 'user_clients.clientId');
    }

    public function itemfilemain()
    {
        return $this->belongsTo('App\ItemFileMain', 'repUser');
    }

    public function survey()
    {
        return $this->hasMany('App\physciansPreferenceAnswer', 'userId');
    }

    public static function userdata()
    {
        return static::leftjoin('roll', 'roll.id', '=', 'users.roll')
            ->leftjoin('orders', 'orders.orderby', '=', 'users.id')
            ->leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
            ->leftjoin('loginuser', 'loginuser.userId', '=', 'users.id')
            ->leftjoin('projects', 'projects.id', '=', 'user_projects.projectId')
            ->leftjoin('user_clients', 'user_clients.userId', '=', 'users.id')
            ->leftJoin('clients', 'clients.id', '=', 'user_clients.clientId')
            ->select('users.*', 'roll.roll_name', 'clients.client_name', 'projects.project_name')
            ->where('users.roll', '3')
            ->where('users.is_delete', '0')
            ->groupBY('users.id');
        }

}
