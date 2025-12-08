<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftVoucher extends Model
{
   protected $fillable = [
        'order_id',
        'code',
        'amount',
        'original_amount',
        'valid_date'
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }       
}
