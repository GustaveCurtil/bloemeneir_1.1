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

    public function isPayed(): bool
    {
        // If no order is linked, consider it "already paid"
        if (!$this->order) {
            return true;
        }

        return $this->order->payed;
    }      
}
