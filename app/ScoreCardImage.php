<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScoreCardImage extends Model
{
    protected $table = 'scorecard_images';
    protected $fillable = [
        'scorecardId', 'scorecardImage'
    ];

    public function scorecard()
    {
    	return $this->belongsTo('App\ScoreCard','scorecardId');
    }

}
