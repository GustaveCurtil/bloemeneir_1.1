<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GiftVoucher extends Model
{
   protected $fillable = [
        'order_id',
        'code',
        'amount',
        'original_amount',
        'valid_date'
    ];


    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    } 

    public function ordersThatUsedThisGiftVouchers(): BelongsToMany 
    {
        return $this->belongsToMany(Order::class, 'order_gift_voucher')
            ->withPivot('amount_used')
            ->withTimestamps();
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
