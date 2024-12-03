<?php

namespace App\Models\admin\estate;

use App\Models\admin\land\LandArea;
use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    protected $fillable  = [ 'landArea_id', 'min_price', 'message'];
    public function landAreas()
    {
        return $this->belongsTo(LandArea::class);
    }
}
