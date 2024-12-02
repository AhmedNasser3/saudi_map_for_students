<?php

namespace App\Models\frontend\messages;

use Illuminate\Database\Eloquent\Model;

class Sent extends Model
{
    protected $fillable = ['send_id', 'text'];

}
