<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMail extends Model
{
    protected $connection = 'mysql2';

    protected $table = 'users';

    protected $fillable = [
        'name','email','phoneNumber','status','password'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
