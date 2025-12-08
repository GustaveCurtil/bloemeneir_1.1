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
        'total_price',
        'total_discount',
        'takeaway_date',
        'takeaway_start_time',
        'takeaway_end_time',
    ];

    // Each order belongs to one client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function giftVoucher()
    {
        return $this->hasOne(GiftVoucher::class);
    }

    public function turnVouchers()
    {
        return $this->hasMany(TurnVoucher::class)
                    ->withTimestamps();
    }

    public function setGiftVoucher(int $amount): ?GiftVoucher
    {
        if ($amount === 0) {
            optional($this->giftVoucher)->delete();
            return null;
        }

        $giftVoucher = $this->giftVoucher;

        if ($giftVoucher) {
            // Update bestaande voucher
            $giftVoucher->update([
                'amount' => $amount,
                'original_amount' => $amount,
                'valid_date' => now()->addMonthsNoOverflow(6)->addDay(),
            ]);
        } else {
            // Maak nieuwe voucher
            $giftVoucher = GiftVoucher::create([
                'order_id' => $this->id,
                'amount' => $amount,
                'original_amount' => $amount,
                'code' => $this->genereerGiftCode(),
                'valid_date' => now()->addMonthsNoOverflow(6)->addDay(),
            ]);
        }

        return $giftVoucher;
    }

    private function genereerGiftCode(): string
    {
        do {
            $flower = collect(config('flowers.gift_flowers'))->random();
            $code   = $flower . sprintf('%04d', random_int(0, 9999));
        } while (GiftVoucher::where('code', $code)->exists());

        return $code;
    }

}
