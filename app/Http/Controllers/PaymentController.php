<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Order;
use App\Models\Client;
use Stripe\PaymentIntent;
use App\Models\GiftVoucher;
use App\Models\TurnVoucher;
use App\Mail\OrderConfirmed;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\MailPetrannesophie;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{

    public function success(Request $request)
    {
        //// --------------------------------------------------------------------------
        //// DEEL 1
        //// --------------------------------------------------------------------------
        
        // STAP 1.1: COLLECTEREN VAN STRIPE GEGEVENS

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $sessionId = $request->query('session_id');
        if (!$sessionId) {
            return "Geen betaling gevonden (geen session_id).";
        }
        $session = \Stripe\Checkout\Session::retrieve($sessionId);
        $paymentIntentId = $session->payment_intent;

        $metadata = $session->metadata;
    
        if ((int) $metadata->total !== 0) {
            if (!$paymentIntentId) {
                return "Geen payment intent ID gevonden.";
            }
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

            if ($paymentIntent->status !== 'succeeded') {
                dd('status: "' . $paymentIntent->status . '" => Excuseer voor deze foutmelding: gelieve contact op te nemen met gustave.curtil@tutanota.com om dit probleem op te lossen.');
            }
        }
        

        $clientId = $session->metadata->clientId ?? null;
        $orderId  = $session->metadata->orderId ?? null;

        if (!$clientId || !$orderId) {
            return "Geen klant- of bestelgegevens gevonden.";
        }

        $client = Client::find($clientId);
        $order = Order::find($orderId);


        // STAP 1.2: BESTAANDE 5-BEURTENKAARTEN OPHALEN
        
        $turnVoucherIds = $metadata['turnVoucherIds'];
        $turnVoucherIdsArray = array_map('intval', explode(',', $turnVoucherIds));

        $schattigOldVouchers = TurnVoucher::whereIn('id', $turnVoucherIdsArray)
        ->where('name', 'schattig')
        ->orderBy('valid_date', 'asc') // zodat eerst de kaarten worden opgebruikt die nog het minst lang geldig zijn.
        ->get();
        $charmantOldVouchers = TurnVoucher::whereIn('id', $turnVoucherIdsArray)
        ->where('name', 'charmant')
        ->orderBy('valid_date', 'asc')
        ->get();
        $magnifiekOldVouchers = TurnVoucher::whereIn('id', $turnVoucherIdsArray)
        ->where('name', 'magnifiek')
        ->orderBy('valid_date', 'asc')
        ->get();


        // STAP 1.3: NIEUWE 5-BEURTENKAARTEN OPHALEN

        $schattigNewVoucherIds = $metadata['turnCardAIds'];
        $schattigNewVoucherIdsArray = array_map('intval', explode(',', $schattigNewVoucherIds));

        $charmantNewVoucherIds = $metadata['turnCardBIds'];
        $charmantNewVoucherIdsArray = array_map('intval', explode(',', $charmantNewVoucherIds));

        $magnifiekNewVoucherIds = $metadata['turnCardCIds'];
        $magnifiekNewVoucherIdsArray = array_map('intval', explode(',', $magnifiekNewVoucherIds));

        $schattigNewVouchers = TurnVoucher::whereIn('id', $schattigNewVoucherIdsArray)
        ->where('name', 'schattig')
        ->orderBy('valid_date', 'asc')
        ->get();
        $charmantNewVouchers = TurnVoucher::whereIn('id', $charmantNewVoucherIdsArray)
        ->where('name', 'charmant')
        ->orderBy('valid_date', 'asc')
        ->get();
        $magnifiekNewVouchers = TurnVoucher::whereIn('id', $magnifiekNewVoucherIdsArray)
        ->where('name', 'magnifiek')
        ->orderBy('valid_date', 'asc')
        ->get();


        // STAP 1.4: BESTAANDE CADEAUBONNEN OPHALEN

        $giftVoucherIds = $metadata['giftVoucherIds'];
        $giftVoucherIdsArray = array_map('intval', explode(',', $giftVoucherIds));
        $giftOldVouchers = GiftVoucher::whereIn('id', $giftVoucherIdsArray)
        ->orderBy('valid_date', 'asc')
        ->get();


        // STAP 1.5 DATUMS GOEDZETTEN

        $orderDate = Carbon::parse($order->takeaway_date);
        Carbon::setLocale('nl');
        $dag = $orderDate->translatedFormat('l'); // "vrijdag", "maandag", etc.
        $datum = $orderDate->translatedFormat('d F'); // "26 september"

        $time_start = Carbon::parse($order->takeaway_start_time);

        if ($time_start->minute === 0) {
            $formattedStart = $time_start->format('H') . 'u';
        } else {
            $formattedStart = $time_start->format('H') . 'u' . $time_start->format('i');
        }
        $time_end = Carbon::parse($order->takeaway_end_time);

        if ($time_end->minute === 0) {
            $formattedEnd = $time_end->format('H') . 'u';
        } else {
            $formattedEnd = $time_end->format('H') . 'u' . $time_end->format('i');
        }
        $uren = $formattedStart . " tot " . $formattedEnd;

        //// --------------------------------------------------------------------------
        //// DEEL 2: CHECK EERST OF ORDER AL IS BETAALD GEWEEST (incl mail gestuurd dan)
        //// --------------------------------------------------------------------------

        // STAP 2.1: INDIEN ALREEDS BETAALD, HERLEID NAAR SUCCES-PAGINA

        if ($order->payed) {
            return view('bestelling.succes', [
                'client' => $client,
                'dag' => $dag,
                'datum' => $datum,
                'uren' => $uren,
                'order' => $order,
                'schattigNewVouchers' => $schattigNewVouchers,
                'charmantNewVouchers' => $charmantNewVouchers,
                'magnifiekNewVouchers' => $magnifiekNewVouchers,
                'schattigOldVouchers' => $schattigOldVouchers,
                'charmantOldVouchers' => $charmantOldVouchers,
                'magnifiekOldVouchers' => $magnifiekOldVouchers,
                'giftNewVoucher' => $order->giftVoucher,
                'giftOldVouchers' => $giftOldVouchers,
            ]);
        }


        // STAP 2.2: INDIEN NIET BETAALD: PAS KORTINGEN TOE OP NIEUWE EN BESTAANDE KAATEN EN BONNEN

        // op bestaande 5-beurtenkaarten
        if ($schattigOldVouchers->isNotEmpty()) {
            $restKortingAbeurten = (int) $metadata['restKortingAbeurten'];
            $this->deductFromTurnVoucher($schattigOldVouchers, $restKortingAbeurten, $order);
        }
        if ($charmantOldVouchers->isNotEmpty()) {
            $restKortingBbeurten = (int) $metadata['restKortingBbeurten'];
            $this->deductFromTurnVoucher($charmantOldVouchers, $restKortingBbeurten, $order);
        }
        if ($magnifiekOldVouchers->isNotEmpty()) {
            $restKortingCbeurten = (int) $metadata['restKortingCbeurten'];
            $this->deductFromTurnVoucher($magnifiekOldVouchers, $restKortingCbeurten, $order);
        }

        // op nieuwe 5-beurtenkaarten

        if ($schattigNewVouchers->isNotEmpty()) {
            $restNewKortingAbeurten = (int) $metadata['restKaartAbeurten'];
            $this->deductFromTurnVoucher($schattigNewVouchers, $restNewKortingAbeurten, $order);
        }
        if ($charmantNewVouchers->isNotEmpty()) {
            $restNewKortingBbeurten = (int) $metadata['restKaartBbeurten'];
            $this->deductFromTurnVoucher($charmantNewVouchers, $restNewKortingBbeurten, $order);
        }
        if ($magnifiekNewVouchers->isNotEmpty()) {
            $restNewKortingCbeurten = (int) $metadata['restKaartCbeurten'];
            $this->deductFromTurnVoucher($magnifiekNewVouchers, $restNewKortingCbeurten, $order);
        }
        
        // op bestaande cadeaubonnen

        $restCadeauBon = $metadata['restKortingCadeau'];

        $this->deductFromGiftVoucher($giftOldVouchers, $restCadeauBon, $order);


        //STAP 2.3: KEUR BETALING GOED EN STUUR MAIL

        $order->payed = true;
        $order->save();

        Mail::to($order->client->email)->send(new OrderConfirmed(
            $order,
            $dag,
            $datum,
            $uren,
            $schattigNewVouchers,
            $charmantNewVouchers,
            $magnifiekNewVouchers,
            $schattigOldVouchers,
            $charmantOldVouchers,
            $magnifiekOldVouchers,
            $order->giftVoucher,
            $giftOldVouchers
        ));

        Mail::to('gustave.curtil@tutanota.com')
        // ->cc([
        //     'annesophie@fullscalearchitecten.be',
        //     'info@bloemenier.be',
        // ])
        ->send(new MailPetrannesophie($order, $dag, $datum, $uren));


        //STAP 2.4: vergeet de gegevens van de bestelling en breng ons naar succespagina

        $request->session()->forget('order_id');
        $request->session()->forget('previousCodes');

        return view('bestelling.succes', [
            'client' => $client,
            'dag' => $dag,
            'datum' => $datum,
            'uren' => $uren,
            'order' => $order,
            'schattigNewVouchers' => $schattigNewVouchers,
            'charmantNewVouchers' => $charmantNewVouchers,
            'magnifiekNewVouchers' => $magnifiekNewVouchers,
            'schattigOldVouchers' => $schattigOldVouchers,
            'charmantOldVouchers' => $charmantOldVouchers,
            'magnifiekOldVouchers' => $magnifiekOldVouchers,
            'giftNewVoucher' => $order->giftVoucher,
            'giftOldVouchers' => $giftOldVouchers,
        ]);
    }
    
    public function deductFromTurnVoucher($vouchers , $restBeurten, $order) {

        $optionColumn = [
            'schattig'   => 'option1',
            'charmant'   => 'option2',
            'magnifiek'  => 'option3',
        ];

        // Step 1: Calculate total of all optionX's
        $totalOptionX = $vouchers->sum(function($voucher) use ($optionColumn) {
            $column = $optionColumn[$voucher->name] ?? null;

            if (!$column) {
                abort(403, "Voucher met naam '{$voucher->name}' is ongeldig. Kan niet bepalen welke optie moet afgetrokken worden.");
            }

            return (int)$voucher->$column;
        });

        // Step 2: Determine how much we need to reduce
        $reductionAmount = $totalOptionX - $restBeurten;
        if ($reductionAmount < 0) {
            abort(403, 'Voor de één of de andere reden heb je nu minder beurten over dan voorheen de betaling! Dit zou absoluut niet mogen kunnen. Wilt u aub contact opnemen met gustave.curtil@tutanota.com, dan bekijken we samen hoe we dit kunnen oplossen');
        }

        if ($reductionAmount === 0) {
            // No reduction needed, total is already less than or equal to restKortingAbeurten
            return;
        }

        // Step 3: Reduce option1's starting from the oldest
        foreach ($vouchers as $voucher) {
            $column = $optionColumn[$voucher->name];
            $optionAmount = (int)$voucher->$column;

            if ($reductionAmount < 0) {
                abort(403, 'VOor de één of de andere reden heb je nu minder beurten over dan voorheen de betaling! Dit zou absoluut niet mogen kunnen. Wilt u aub contact opnemen met gustave.curtil@tutanota.com, dan bekijken we samen hoe we dit kunnen oplossen');
            }

            if ($reductionAmount === 0) {
                break; // done reducing
            }

            if ($optionAmount >= $reductionAmount) {
                // Reduce this voucher partially
                $deducted = $reductionAmount;
                $voucher->$column = $optionAmount - $reductionAmount;
                $voucher->save();
                $reductionAmount = 0;
                $order->turnVouchersUsed()->attach($voucher->id, [
                    'amount_used' => $deducted,
                ]);
                break;
            } else {
                // Deplete this voucher completely
                $deducted = $optionAmount;
                $voucher->$column = 0;
                $voucher->save();
                $reductionAmount -= $optionAmount;
    
                $order->turnVouchersUsed()->attach($voucher->id, [
                    'amount_used' => $deducted,
                ]);
            }
        }
    }

    public function deductFromGiftVoucher($vouchers, $restBon, $order) {

        // Step 1: Calculate total of all optionX's
        $totalBonnen = $vouchers->sum('amount');

        // Step 2: Determine how much we need to reduce
        $reductionAmount = $totalBonnen - $restBon;

        if ($reductionAmount < 0) {
            abort(403, 'Voor de één of de andere reden heb je nu minder beurten over dan voorheen de betaling! Dit zou absoluut niet mogen kunnen. Wilt u aub contact opnemen met gustave.curtil@tutanota.com, dan bekijken we samen hoe we dit kunnen oplossen');
        }

        if ($reductionAmount === 0) {
            // No reduction needed, total is already less than or equal to restKortingAbeurten
            return;
        }

        // Step 3: Reduce option1's starting from the oldest
        foreach ($vouchers as $voucher) {

            $voucherAmount = (int)$voucher->amount;

            if ($reductionAmount < 0) {
                abort(403, 'VOor de één of de andere reden heb je nu minder beurten over dan voorheen de betaling! Dit zou absoluut niet mogen kunnen. Wilt u aub contact opnemen met gustave.curtil@tutanota.com, dan bekijken we samen hoe we dit kunnen oplossen');
            }

            if ($reductionAmount === 0) {
                break; // done reducing
            }

            if ($voucherAmount >= $reductionAmount) {
                // Reduce this voucher partially
                $deducted = $reductionAmount;
                $voucher->amount = $voucherAmount - $reductionAmount;
                $voucher->save();
                $reductionAmount = 0;
                break;
            } else {
                // Deplete this voucher completely
                $deducted = $voucherAmount;
                $voucher->amount = 0;
                $voucher->save();
                $reductionAmount -= $voucherAmount;
            }

            $order->giftVouchersUsed()->attach($voucher->id, [
                'amount_used' => $deducted
            ]);
        }
    }

    // protected $products = [
    //     'option1' => ['name' => 'Schattige boeketten', 'price' => 2900], 
    //     'option2' => ['name' => 'Charmante boeketten', 'price' => 3900],
    //     'option3' => ['name' => 'Magnifieke boeketten', 'price' => 4900],
    // ];


    // public function processOrder(Request $request)
    // {
    //     $quantities = [
    //         'option1' => (int) $request->input('option1', 0),
    //         'option2' => (int) $request->input('option2', 0),
    //         'option3' => (int) $request->input('option3', 0),
    //     ];

    //     $userData = [
    //         'first_name' => $request->first_name,
    //         'last_name' => $request->last_name,
    //         'phone' => $request->phone,
    //         'email' => $request->email,
    //     ];

    //     $items = [];
    //     $totalAmount = 0;

    //     foreach ($this->products as $key => $product) {
    //         if ($quantities[$key] > 0) {
    //             $items[] = [
    //                 'name' => $product['name'],
    //                 'quantity' => $quantities[$key],
    //                 'unit_price' => $product['price'],
    //             ];
    //             $totalAmount += $product['price'] * $quantities[$key];
    //         }
    //     }

    //     if ($totalAmount === 0) {
    //         return back()->withErrors('Je moet minstens één boeket kiezen.');
    //     }

    //     Stripe::setApiKey(env('STRIPE_SECRET'));

    //     $paymentIntent = PaymentIntent::create([
    //         'amount' => $totalAmount,
    //         'currency' => 'eur',
    //         'payment_method_types' => ['bancontact'],
    //         'description' => 'Boeket bestelling: ' . implode(', ', array_map(fn($i) => $i['name'].' x'.$i['quantity'], $items)),
    //         'metadata' => [
    //             'first_name' => $request->input('first_name'),
    //             'phone' => $request->input('phone'),
    //             'email' => $request->input('email'),
    //             'pickup_day' => $request->input('day'),
    //         ],
    //     ]);

    //     return view('bestelling.checkout', [
    //         'clientSecret' => $paymentIntent->client_secret,
    //         'items' => $items,
    //         'totalAmount' => $totalAmount,
    //         'userData' => $userData,
    //     ]);

    // }



    // public function success(Request $request)
    // {
    //     $paymentIntentId = $request->query('payment_intent');

    //     if (!$paymentIntentId) {

    //         return "Geen betaling gevonden.";

    //     }

    //     \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    //     $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

    //     $clientId = $paymentIntent->metadata->client_id ?? null;
    //     $orderId  = $paymentIntent->metadata->order_id ?? null;

    //     if (!$clientId || !$orderId) {
    //         return "Geen klant- of bestelgegevens gevonden.";
    //     }

    //     // Fetch client and order
    //     $client = \App\Models\Client::find($clientId);
    //     $order  = \App\Models\Order::find($orderId);
    
    //     if ($paymentIntent->status === 'succeeded') {
            
    //             $orderDate = Carbon::parse($order->day);
    //             Carbon::setLocale('nl');
    //             $dag = $orderDate->translatedFormat('l'); // "vrijdag", "maandag", etc.
    //             $datum = $orderDate->translatedFormat('d F'); // "26 september"

    //         if (!$order->payed) {

    //             $order->payed = true;

    //             // $order->stripe_payment_intent_id = $paymentIntent->id;
    //             $order->save(); 
    //             Mail::to($client->email)->send(new OrderConfirmed($order, $dag, $datum));
    //             Mail::to('info@bloemenier.be')
    //                 // ->cc([
    //                 //     'annesophie@fullscalearchitecten.be',
    //                 //     'gustave.curtil@tutanota.com',
    //                 // ])
    //                 ->send(new MailPetrannesophie($order, $dag, $datum));
    //         }

    //         $request->session()->forget('order');

    //         return view('bestelling.succes', [
    //             'client' => $client,
    //             'dag' => $dag,
    //             'datum' => $datum
    //         ]);

    //     } elseif ($paymentIntent->status === 'processing') {

    //         return "⏳ Je betaling wordt nog verwerkt. Even geduld!";

    //     } elseif ($paymentIntent->status === 'requires_payment_method') {

    //         return redirect()->route('checkout', [
    //             'client_id' => $order->client_id,
    //             'order_id' => $order->id
    //         ])->with('message', 'Betaling mislukt of geannuleerd.');

    //     } else {

    //         return "⚠️ Onbekende status: {$paymentIntent->status}";
    //     }
    // }
}
