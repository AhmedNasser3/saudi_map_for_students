<?php

namespace App\Models\frontend\message;

use Illuminate\Database\Eloquent\Model;

class LawyerSend extends Model
{
    protected $fillable  = [
        'title',
        'message',
        'user_id',
        'read',
        'state',
    ];
}
