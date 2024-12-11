<?php

namespace App\Models\frontend\parents;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    protected $fillable = ['parent_id', 'child_id'];

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function child()
    {
        return $this->belongsTo(User::class, 'child_id');
    }
}
