<?php

namespace App\Models\admin\bid;

use App\Models\admin\land\LandArea;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = ['land_area_id', 'user_id', 'bid_amount', 'tax_end_time', 'tax', 'state'];

    protected $dates = ['tax_end_time']; // هذا يسمح للـ Laravel باستخدام Carbon مع الحقول

    public function landArea()
    {
        return $this->belongsTo(LandArea::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
