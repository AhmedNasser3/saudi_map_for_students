<?php

namespace App\Models\admin\land;

use App\Models\admin\land\LandArea;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Land extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function landAreas()
    {
        return $this->hasMany(LandArea::class);
    }
}
