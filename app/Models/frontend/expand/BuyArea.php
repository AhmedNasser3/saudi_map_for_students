<?php

namespace App\Models\frontend\expand;

use Illuminate\Database\Eloquent\Model;
use App\Models\frontend\expandArea\ExpandArea;

class BuyArea extends Model
{
    protected $fillable = [
        'landArea_id',
        'bonus_area',
    ];
    public function productArea()
    {
        return $this->belongsTo(ExpandArea::class);
    }
}
