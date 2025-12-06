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
}
