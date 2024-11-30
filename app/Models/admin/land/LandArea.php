<?php

namespace App\Models\admin\land;

use App\Models\admin\bid\Bid;
use App\Models\admin\land\Land;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LandArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'land_id',
        'area',
        'starting_price',
        'auction_end_time',
        'user_id',
        'final_price',
        'day',
        'duration',
        'highest_bidder_id',
        'highest_bid',
        'tax',
        'start_time',
        'show',
        'tax_end_time',
        'state',
        'img',
    ];
    public function land()
    {
        return $this->belongsTo(Land::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class, 'land_area_id');
    }

}
