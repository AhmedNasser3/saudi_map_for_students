<?php

namespace App\Models;

use App\Models\CityArea;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name'];

    public function areas()
    {
        return $this->hasMany(CityArea::class);
    }

    public function getTotalMetersAttribute()
    {
        return $this->areas()->sum('meters');
    }
}
