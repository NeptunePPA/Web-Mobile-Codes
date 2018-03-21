<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailList extends Model
{
    protected $connection = 'mysql2';

    protected $table = 'maillist';

    protected $fillable = [
        'from','subject','message','status','isDelete'
    ];
}
