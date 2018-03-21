<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScoreCard extends Model
{
    protected $table = 'scorecards';
    protected $fillable = [
        'userId', 'year','monthId'
    ];

    public function ScoreImage(){
		return $this->hasMany('App\ScoreCardImage','scorecardId');
	}

	 public function months(){

	    return $this->belongsTo('App\Month','monthId');

	}

	public static function month(){
	  	return static::leftjoin('month', 'month.id', '=', 'scorecards.monthId')
	            ->select('scorecards.*', 'month.month', 'scorecards.monthId as months');
	}
}
