<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailTo extends Model
{
    protected $connection = 'mysql2';

    protected $table = 'mailto';

    protected $fillable = [
        'mailId','mail','status'
    ];
}
