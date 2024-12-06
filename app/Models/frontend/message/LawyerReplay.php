<?php

namespace App\Models\frontend\message;

use Illuminate\Database\Eloquent\Model;

class LawyerReplay extends Model
{
    protected $fillable = [
        'send_id',
        'text',
    ];
}
