<?php

namespace App\Models\admin\tax;

use App\Models\admin\land\LandArea;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $fillable = [
        'landArea_id',
        'taxDays',
    ];

    public function landArea()
    {
        return $this->belongsTo(LandArea::class);
    }
}
