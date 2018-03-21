<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    protected $table = 'month';

    protected $fillable = ['id','month'];

    public function ScoreImage(){
		return $this->hasMany('App\ScoreCard','scorecardId');
	}
}
