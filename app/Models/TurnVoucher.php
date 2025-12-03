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
}
