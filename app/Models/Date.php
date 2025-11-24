<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    protected $fillable = [
        'last_order_date',
        'last_order_time',
        'takeaway_date',
        'takeaway_start_time',
        'takeaway_end_time',
        'is_public',
        'emoji',
    ];
}
