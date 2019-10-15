<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserResult extends Model
{
    //
    protected $fillable = [
        'session_id',
        'title_id',
        'alias',

        'answer',

        'p1',
        'p2',
        'p3',
        'p4',

        'name',
        'email',
        'access_id',
        'memo1',
    ];
}
