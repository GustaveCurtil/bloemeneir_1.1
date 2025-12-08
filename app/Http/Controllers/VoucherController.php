<?php

namespace App\Http\Controllers;

use App\Models\GiftVoucher;
use App\Models\TurnVoucher;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;

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

        // ❌ vouchers bestaan niet
        if (!$giftVoucher && !$turnVoucher) {
            return redirect()->route('afrekenen')
                ->withErrors(['code' => "De code '{$code}' is ongeldig."])
                ->withInput();
        }

        // ❌ De codes zijn nog niet betaald geweest
        if ($giftVoucher && !$giftVoucher->isPayed()) {
            return redirect()->route('afrekenen')
                ->withErrors(['code' => "De cadeaubon met code '{$code}' is nog niet betaald geweest."])
                ->withInput();
        }
    
        if ($turnVoucher && !$turnVoucher->isPayed()) {
            return redirect()->route('afrekenen')
                ->withErrors(['code' => "De 5-beurtenkaart code '{$code}' is nog niet betaald geweest."])
                ->withInput();
        }

        $now = Carbon::now()->addDays(2);

        if ($giftVoucher && $giftVoucher->valid_date < $now) {
            return redirect()->route('afrekenen')
                ->withErrors(['code' => "De cadeaubon met code '{$code}' is verlopen op {$giftVoucher->valid_date}."])
                ->withInput();
        }

        if ($turnVoucher && $turnVoucher->valid_date < $now) {
            return redirect()->route('afrekenen')
                ->withErrors(['code' => "De 5-beurtenkaart met code '{$code}' is verlopen op {$turnVoucher->valid_date}."])
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
        // Validate input
        $data = $request->validate([
            'code' => 'required|string',
        ]);
        
        // Retrieve existing codes from session
        $previousCodes = session('previousCodes', []);

        // Normalize input code to lowercase
        $currentCode = strtolower($data['code']);

        // Normalize previous codes to lowercase for comparison matching
        $previousCodesLower = array_map('strtolower', $previousCodes);

        // If the code exists in the array (case-insensitive)
        if (in_array($currentCode, $previousCodesLower)) {

            // Remove the matching code, case-insensitive
            $previousCodes = array_filter($previousCodes, function ($c) use ($currentCode) {
                return strtolower($c) !== $currentCode;
            });

            // Reindex to avoid numeric gaps
            $previousCodes = array_values($previousCodes);

            // Save back to session
            session(['previousCodes' => $previousCodes]);
        }

        return redirect()->route('afrekenen');
    }
}
