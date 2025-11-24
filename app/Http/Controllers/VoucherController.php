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

        return view('winkel', [
            'giftVoucher' => $giftVoucher,
            'turnVoucher' => $turnVoucher,
            'code' => $code,
        ]);
    }
}
