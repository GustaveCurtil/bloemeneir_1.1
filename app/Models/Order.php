<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function giftVoucherUsed(): BelongsToMany
    {
        return $this->belongsToMany(GiftVoucher::class, 'order_gift_voucher')
            ->withPivot('amount_used')
            ->withTimestamps();
    }

    public function turnVouchersUsed(): BelongsToMany
    {
        return $this->belongsToMany(TurnVoucher::class, 'order_turn_voucher')
            ->withPivot('amount_used')
            ->withTimestamps();
    }

    public function turnVouchers()
    {
        return $this->hasMany(TurnVoucher::class);
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

    public function schattigeVouchers()
    {
        return $this->hasMany(TurnVoucher::class)
                    ->where('name', 'schattig');
    }

    public function charmanteVouchers()
    {
        return $this->hasMany(TurnVoucher::class)
                    ->where('name', 'charmant');
    }

    public function magnifiekeVouchers()
    {
        return $this->hasMany(TurnVoucher::class)
                    ->where('name', 'magnifiek');
    }


    public function setTurnVouchers(int $amount, $name)
    {
        // zoek naar bestaande vouchers van de juiste categorie
        switch ($name) {
            case 'schattig':
                $existing = $this->schattigeVouchers;
                $column_name = 'option1';
                break;
            case 'charmant':
                $existing = $this->charmanteVouchers;
                $column_name = 'option2';
                break;
            case 'magnifiek':
                $existing = $this->magnifiekeVouchers;
                $column_name = 'option3';
                break;
            default:
                return collect();
        }

        $existing->each->delete();

        if ($amount === 0) {
            return collect();
        }

        $vouchers = [];
        for ($i = 0; $i < $amount; $i++) {
            $vouchers[] = $this->turnVouchers()->create([
                'name'                      => $name,
                'code'                      => $this->genereerTurnCode(),
                $column_name                => 5,
                $column_name . '_original'  => 5,
                'valid_date'                => now()->addMonthsNoOverflow(6)->addDay()
            ]);
        }

        return collect($vouchers);
    }

    private function genereerTurnCode(): string
    {
        do {
            $flower = collect(config('flowers.turn_flowers'))->random();
            $code   = $flower . sprintf('%04d', random_int(0, 9999));
        } while (TurnVoucher::where('code', $code)->exists());

        return $code;
    }

}
