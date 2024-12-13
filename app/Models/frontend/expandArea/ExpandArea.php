<?php

namespace App\Models\frontend\expandArea;

use Illuminate\Database\Eloquent\Model;

class ExpandArea extends Model
{
    protected $fillable = [
        'name',
        'number_products',
        'area',
        'bonus_area_price',
        'state',
    ];
}
