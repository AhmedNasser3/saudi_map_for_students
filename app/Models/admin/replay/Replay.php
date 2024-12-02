<?php

namespace App\Models\admin\replay;

use Illuminate\Database\Eloquent\Model;

class Replay extends Model
{
    protected $fillable = [
        'send_id',
        'text',
    ];
}
