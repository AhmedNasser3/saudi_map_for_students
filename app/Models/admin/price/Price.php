<?php

namespace App\Models\admin\price;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = [
        'tax_price',
        'fine_price',
        'bid_price',
        'message_price',
    ];
}
