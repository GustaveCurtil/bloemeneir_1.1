<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'option1',
        'option2',
        'option3',
        'day',
        'payed',
    ];

    // Each order belongs to one client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
