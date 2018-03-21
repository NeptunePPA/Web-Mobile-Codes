<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $table = 'category';

    public function devicecategory()
    {
        return $this->hasMany('App\device','category_name');
    }
}
