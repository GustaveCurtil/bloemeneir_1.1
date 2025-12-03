<?php

namespace App\Http\Controllers;

use App\Models\GiftVoucher;
use App\Models\TurnVoucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    // $turnFlowers = ['ROOS','IRIS','TULP','LELIE','PIOEN','ANIJS','AKELEI','NARCIS','FRESIA','GERBERA','JASMIJN','LAVENDEL','ORCHIS','MAGNOLIA','HYACINT','CAMELIA','ZINNIA'];
    // $giftFlowers = ['CHRYSANT','HORTENSIA','PASSIEBLOEM','ZONNEBLOEM','ANJERBLOEM','MAGNOLIA','HYACINT','ORCHIDEE'];

    public function checkCode(Request $request)
    {
        // Valideer input
        $data = $request->validate([
            'code' => 'required|string',
        ]);

        $code = $data['code'];
        
        $giftVoucher = GiftVoucher::where('code', $code)->first();
        $turnVoucher = TurnVoucher::where('code', $code)->first();

        // ❌ No matching vouchers
        if (!$giftVoucher && !$turnVoucher) {
            return redirect()->route('afrekenen')
                ->withErrors(['code' => "De code '{$code}' is ongeldig."])
                ->withInput();
        }

        // Load used codes
        $previousCodes = session('previousCodes', []);

        // ❌ Already used
        if (in_array($code, $previousCodes)) {
            return redirect()->route('afrekenen')
                ->withErrors(['code' => "De code '{$code}' is reeds gebruikt."])
                ->withInput();
        }

        // Store new used code
        $previousCodes[] = $code;

        // $amountA = session('amountA', 0);
        // $amountB = session('amountB', 0);
        // $amountC = session('amountC', 0);
        // $amountGift = session('amountGift', 0);

        // // Only add if voucher exists
        // if ($turnVoucher) {
        //     $amountA += $turnVoucher->option1 ?? 0;
        //     $amountB += $turnVoucher->option2 ?? 0;
        //     $amountC += $turnVoucher->option3 ?? 0;
        // }

        // if ($giftVoucher) {
        //     $amountGift += $giftVoucher->amount ?? 0;
        // }

        session([
            // 'amountA' => $amountA,
            // 'amountB' => $amountB,
            // 'amountC' => $amountC,
            // 'amountGift' => $amountGift,
            'previousCodes' => $previousCodes, 
        ]);

        return redirect()->route('afrekenen');
    }
}
