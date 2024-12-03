<?php

namespace App\Models\frontend\messages;

use Illuminate\Database\Eloquent\Model;

class Send extends Model
{
    protected $fillable  = [
        'title',
        'message',
        'user_id',
        'read',
        'state',
    ];
}
