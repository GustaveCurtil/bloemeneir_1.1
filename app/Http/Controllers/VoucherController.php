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

        session([
            'previousCodes' => $previousCodes, 
        ]);

        return redirect()->route('afrekenen');
    }

    public function deleteCode(Request $request)
    {

    }
}
