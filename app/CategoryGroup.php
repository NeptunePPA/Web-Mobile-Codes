<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryGroup extends Model
{
    protected $fillable = [
        'project_id','category_group_name','category_id'
    ];

    protected $table='category_group';

    public function category()
    {
        return $this->belongsTo('App\category', 'category_id');
    }
    public function project()
    {
        return $this->belongsTo('App\project', 'project_id');
    }
}
