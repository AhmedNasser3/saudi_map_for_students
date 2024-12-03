<?php

namespace App\Models\admin\land;

use App\Models\User;
use App\Models\admin\bid\Bid;
use App\Models\admin\tax\Tax;
use App\Models\admin\land\Land;
use App\Models\admin\estate\Estate;
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
        'land_deed',
        'show_to_estate',
        'img',
        'add_balance_to_seller',
    ];
    public function land()
    {
        return $this->belongsTo(Land::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class, 'land_area_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($landArea) {
            if (empty($landArea->land_deed)) {
                $landArea->land_deed = $landArea->land->id.'0' . mt_rand(10000000, max: 99999999);
            }
        });
    }
    public function taxD()
    {
        return $this->hasMany(Tax::class, 'landArea_id');
    }


}
