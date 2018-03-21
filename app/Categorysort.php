<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorysort extends Model
{
    protected $table = 'category_sort';

    protected $fillable = [
    	'sort_number','client_name','category_name'
    	];
}
