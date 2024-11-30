<?php

namespace App\Models\admin\discount;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'user_id',
        'discount',
        'title',
    ];

    public function user()
    {
        return $this->hasMany(related: User::class);
    }
}
