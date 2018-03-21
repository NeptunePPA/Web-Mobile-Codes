<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import_app extends Model
{
    protected $table = 'import_app_value';

    protected $fillable = [
        'category_name','project_name','category_avg_app','client_name','device_level','year'
    ];

    public function category()
    {
        return $this->belongsTo('App\category', 'category_name');
    }
    public function project()
    {
        return $this->belongsTo('App\project', 'project_name');
    }

    public function client()
    {
        return $this->belongsTo('App\clients', 'client_name');
    }


}
