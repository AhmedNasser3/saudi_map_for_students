<?php

namespace App\Models\admin\addition;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Addition extends Model
{
    protected $fillable = [
        'user_id',
        'addition',
        'title',
    ];

    public function user()
    {
        return $this->hasMany(related: User::class);
    }
}
