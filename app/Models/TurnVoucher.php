<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TurnVoucher extends Model
{
    protected $fillable = [
        'order_id',
        'name',
        'code',
        'option1',
        'option2',
        'option3',
        'option1_original',
        'option2_original',
        'option3_original',
        'valid_date',
    ];

    protected $appends = ['valid_till'];

    public function getValidTillAttribute()
    {
        return $this->created_at
            ->copy()
            ->addMonths(6)
            ->addDay()
            ->endOfDay()
            ->format('d/m/Y');
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
