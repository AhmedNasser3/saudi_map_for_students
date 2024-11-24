<?php

namespace App\Models;

use App\Models\City;
use Illuminate\Database\Eloquent\Model;

class CityArea extends Model
{
    protected $fillable = ['city_id', 'meters'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
