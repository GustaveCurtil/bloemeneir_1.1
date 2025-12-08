<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Date;
use App\Models\Order;
use App\Models\Client;
use Stripe\PaymentIntent;
use App\Models\GiftVoucher;
use App\Models\TurnVoucher;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;

class OrderController extends Controller
{

    public function pay(Request $request) {
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone'      => 'nullable|max:20',
            'email'      => 'required|email|max:255|confirmed',
            'nieuwsbrief'=> 'nullable|boolean',

            'boeket_A' => 'required|integer|min:0',
            'boeket_B' => 'required|integer|min:0',
            'boeket_C' => 'required|integer|min:0',
            'kaart_A' => 'required|integer|min:0',
            'kaart_B' => 'required|integer|min:0',
            'kaart_C' => 'required|integer|min:0',
            'inzetten_A' => 'required|boolean',
            'inzetten_B' => 'required|boolean',
            'inzetten_C' => 'required|boolean',
            'cadeau' => 'required|integer|min:0',
            'totaal' => 'required|integer|min:0',

            'turnCardCodes' => 'array',
            'turnCardCodes.*' => 'string',

            'giftCardCodes' => 'array',
            'giftCardCodes.*' => 'string',

            'day' => 'required'
        ]);


        // STAP 1 : BEREKEN TOTAALBEDRAG
    
        //zoek de kortingskaarten en -bonnen op
        $turnCards = TurnVoucher::whereIn('code', $validated['turnCardCodes'] ?? [])->get();
        $giftCards = GiftVoucher::whereIn('code', $validated['giftCardCodes'] ?? [])->get();

        $totals = $this->berekenTotaal($validated, $turnCards, $giftCards);
        $subTotal = $totals["subtotal"];
        $total = $totals["total"];

        // even checken of de berekening van de totale prijs overeenkomt met de frontend berekening ---> want da's dus wel belangrijk
        if ((float)$total !== (float)$validated['totaal']) {
            // wat kan ik doen als ze niet gelijk zijn? Een melding met de vraag om print screens te nemen en deze door te sturen naar gustave.curtil@tutanota.com...
            dd("Het back-end totaal van: " .$total . " is niet hetzelfde als het front-end totaal van: " . $validated['totaal'] .". Dit is lastig. Als je dit ziet, zou je aub een print screen kunnen nemen van deze pagina en de vorige en deze doorsturen naar gustave.curtil@tutanota.com aub? Dan kan ik dit probleem asap oplossen. Dank u! xx");
        } 


        // STAP 2: CONTROLEER OF DATA KLOPT

        $now = Carbon::now();
        $date = Date::where('takeaway_date', $validated['day'])
                    ->where(function ($query) use ($now) {
                        $query->where('last_order_date', '>', $now->toDateString())
                            ->orWhere(function ($q) use ($now) {
                                $q->where('last_order_date', $now->toDateString())
                                    ->where('last_order_time', '>=', $now->toTimeString());
                            });
                    })
                    ->first();

        if (!$date || !$date->takeaway_date || !$date->takeaway_start_time || !$date->takeaway_end_time) {
            abort(403, 'Datum werd niet teruggevonden. Wil je aub contact opnemen met gustave.curtil@tutanota.com met een printscreen van het voorgaande scherm?');
        }

        $takeaway_date = $date->takeaway_date;
        $takeaway_start_time = $date->takeaway_start_time;
        $takeaway_end_time = $date->takeaway_end_time;


        // STAP 3: ZOEK OF MAAK KLANT AAN

        $clientId = $request->session()->get('client_id');

        if ($clientId) {
            $client = Client::find($clientId);
        }

        if (isset($client)) {

            // Indien e-mailadres gewijzigd is, maak een nieuwe client aan gewoon
            if ($client->email !== $validated['email']) {
                $client = Client::create([
                    'first_name' => $validated['first_name'],
                    'last_name'  => $validated['last_name'],
                    'phone'      => $validated['phone'],
                    'email'      => $validated['email'],
                    'nieuwsbrief'=> $validated['nieuwsbrief'] ?? 0,
                    'device_id'  => uniqid()
                ]);

            // Zelfde e-mailadress? De andere dingen even updaten. 
            } else {
                $client->update([
                    'first_name' => $validated['first_name'],
                    'last_name'  => $validated['last_name'],
                    'phone'      => $validated['phone'],
                    'nieuwsbrief'=> $validated['nieuwsbrief'] ?? 0,
                ]);
            }
        } else {
            // indien e-mail adres al bestaat, update die klant
            // indien nieuw e-mail adres, maak nieuwe klant aan
            $client = Client::firstOrCreate(
                ['email' => $validated['email']],
                [
                    'first_name' => $validated['first_name'],
                    'last_name'  => $validated['last_name'],
                    'phone'      => $validated['phone'],
                    'nieuwsbrief'=> $validated['nieuwsbrief'] ?? 0,
                    'device_id'  => uniqid()
                ]
            );
        }

        $request->session()->put('client_id', $client->id);


        // STAP 4: ZOEK OF MAAK BESTELLING AAN
        // (die ook gelinkt moet zijn met de huidige client, anders verwijder bestelling en maak nieuwe aan)
        
        $orderId = $request->session()->get('order_id');
        $order = $orderId ? Order::find($orderId) : null;

        // Check bestaande order
        if ($order) {
            if ($order->payed) {
                abort(403, 'Bestelling al betaald. Wil je aub contact opnemen met gustave.curtil@tutanota.com met een printscreen van het voorgaande scherm aub?');
            }
            if ($order->client_id !== $client->id) {
                abort(403, 'Deze bestelling hoort bij een andere klant.  Wil je aub contact opnemen met gustave.curtil@tutanota.com met een printscreen van het voorgaande scherm aub?');
            }

            // Update bestaande order
            $order->update([
                'day'                   => $validated['day'],
                'total_price'           => $subTotal,
                'total_discount'        => $total,
                'option1'               => $validated['boeket_A'],
                'option2'               => $validated['boeket_B'],
                'option3'               => $validated['boeket_C'],
                'takeaway_date'         => $takeaway_date,
                'takeaway_start_time'   => $takeaway_start_time,
                'takeaway_end_time'     => $takeaway_end_time,
            ]);

        } else {
            // Maak nieuwe order
            $order = Order::create([
                'client_id'             => $client->id,
                'day'                   => $validated['day'],
                'total_price'           => $subTotal,
                'total_discount'        => $total,
                'option1'               => $validated['boeket_A'],
                'option2'               => $validated['boeket_B'],
                'option3'               => $validated['boeket_C'],
                'payed'                 => false,
                'takeaway_date'         => $takeaway_date,
                'takeaway_start_time'   => $takeaway_start_time,
                'takeaway_end_time'      => $takeaway_end_time,
            ]);
        }

        $request->session()->put('order_id', $order->id);


        // STAP 5: maak of update een NIEUW cadeaubon 
        
        $giftCard = $order->setGiftVoucher($validated['cadeau']);


        // STAP 5: maak of update NIEUWE 5-BEURTENKAARTEN

        $turnCardsA = $order->setTurnVouchers($validated['kaart_A'], 'schattig');
        $turnCardsB = $order->setTurnVouchers($validated['kaart_B'], 'charmant');
        $turnCardsC = $order->setTurnVouchers($validated['kaart_C'], 'magnifiek');


        // STAP 6: METADATA PREPAREREN;
        
        $turnCardIds = $turnCards->pluck('id')->toArray();
        $giftCardIds = $giftCards->pluck('id')->toArray();


        // STAP 7: HOP NAAR STRIPE

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $customer = \Stripe\Customer::create([
            'name' => $validated['first_name'] . " " . $validated['last_name'],
            'email' => $validated['email'],
        ]);

        // Create Stripe Checkout Session
        $session = Session::create([
            'payment_method_types' => ['bancontact', 'card'], // Bancontact enabled
            'mode' => 'payment',

            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $total * 100,
                    'product_data' => [
                        'name' => 'Bloemen & kaarten order #' . $order->id,
                    ],
                ],
            ]],

            'metadata' => [
                'clientId'      => $client->id,
                'orderId'       => $order->id,
                'turnCardIds'   => $turnCardIds,
                'giftCardIds'   => $giftCardIds
            ],

            'customer' => $customer->id,

            'success_url' => url('/success?session_id={CHECKOUT_SESSION_ID}&order=' . $order->id),
            'cancel_url' => route('afrekenen'), 
        ]);

        // Redirect instantly to Stripe payment page
        return redirect($session->url);
    }

    private function genereerGiftCode()
    {
        do {
            $flower = collect(config('flowers.gift_flowers'))->random();
            $code   = $flower . sprintf('%04d', random_int(0, 9999));
        } while (GiftVoucher::where('code', $code)->exists());

        return $code;
    }

    public function berekenTotaal($validated, $turnCards, $giftCards) {

        $kaartAbeurten = 0;
        $kaartBbeurten = 0;
        $kaartCbeurten = 0;

        $kortingAbeurten = 0;
        $kortingBbeurten = 0;
        $kortingCbeurten = 0;

        foreach ($turnCards as $card) {
            $kortingAbeurten += (int) $card->option1;
            $kortingBbeurten += (int) $card->option2;
            $kortingCbeurten += (int) $card->option3;
        }

        $cadeauKorting = 0;

        foreach ($giftCards as $card) {
            $cadeauKorting += (int) $card->amount;
        }

        $kaartAaantal = $validated['kaart_A'];
        $kaartBaantal = $validated['kaart_B'];
        $kaartCaantal = $validated['kaart_C'];

        //eerst berekenen hoeveel boeketten moeten aangerekend worden nadat de beurten van de kaarten zijn afgetrokken
        $boeketAaantal = $validated['boeket_A'];
        $boeketBaantal = $validated['boeket_B'];
        $boeketCaantal = $validated['boeket_C'];

        $cadeau = $validated['cadeau'];

        if ($validated['inzetten_A']) {
            $kaartAbeurten += $kaartAaantal * 5;
        }

        if ($validated['inzetten_B']) {
            $kaartBbeurten += $kaartBaantal * 5;
        }

        if ($validated['inzetten_C']) {
            $kaartCbeurten += $kaartCaantal * 5;
        }

        if ($kortingAbeurten > 0 && $boeketAaantal > 0) {
            $af_te_trekken = min($kortingAbeurten, $boeketAaantal);
            $kortingAbeurten   -= $af_te_trekken;
            $boeketAaantal   -= $af_te_trekken;
        }
        if ($kortingBbeurten > 0 && $boeketBaantal > 0) {
            $af_te_trekken = min($kortingBbeurten, $boeketBaantal);
            $kortingBbeurten   -= $af_te_trekken;
            $boeketBaantal   -= $af_te_trekken;
        }
        if ($kortingCbeurten > 0 && $boeketCaantal > 0) {
            $af_te_trekken = min($kortingCbeurten, $boeketCaantal);
            $kortingCbeurten   -= $af_te_trekken;
            $boeketCaantal   -= $af_te_trekken;
        }

        if ($kaartAbeurten > 0 && $boeketAaantal > 0) {
            $af_te_trekken = min($kaartAbeurten, $boeketAaantal);
            $kaartAbeurten   -= $af_te_trekken;
            $boeketAaantal   -= $af_te_trekken;
        }
        if ($kaartBbeurten > 0 && $boeketBaantal > 0) {
            $af_te_trekken = min($kaartBbeurten, $boeketBaantal);
            $kaartBbeurten   -= $af_te_trekken;
            $boeketBaantal   -= $af_te_trekken;
        }
        if ($kaartCbeurten > 0 && $boeketCaantal > 0) {
            $af_te_trekken = min($kaartCbeurten, $boeketCaantal);
            $kaartCbeurten   -= $af_te_trekken;
            $boeketCaantal   -= $af_te_trekken;
        }

        $boeketAtotaal = $boeketAaantal *  config('prijzen.boeketten.schattig');
        $boeketBtotaal = $boeketBaantal *  config('prijzen.boeketten.charmant');
        $boeketCtotaal = $boeketCaantal *  config('prijzen.boeketten.magnifiek');

        $kaartAtotaal = $kaartAaantal *  config('prijzen.5-beurtenkaarten.schattig');
        $kaartBtotaal = $kaartBaantal *  config('prijzen.5-beurtenkaarten.charmant');
        $kaartCtotaal = $kaartCaantal *  config('prijzen.5-beurtenkaarten.magnifiek');

        $subtotal = $kaartAtotaal 
                + $kaartBtotaal 
                + $kaartCtotaal 
                + $boeketAtotaal 
                + $boeketBtotaal 
                + $boeketCtotaal 
                + $cadeau;   // total BEFORE korting

        $af_te_trekken_korting = min($subtotal, $cadeauKorting);
        $total = $subtotal - $af_te_trekken_korting;

        $cadeauKorting -= $af_te_trekken_korting;

        return [
            'kaartAbeurten' => $kaartAbeurten,
            'kaartBbeurten' => $kaartBbeurten,
            'kaartCbeurten' => $kaartCbeurten,
            'kortingAbeurten' => $kortingAbeurten,
            'kortingBbeurten' => $kortingBbeurten,
            'kortingCbeurten' => $kortingCbeurten,
        
            'subtotal' => $subtotal,   // before korting
            'total'    => $total,      // after korting
        ];
    }

    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone'      => 'nullable|max:20',
            'email'      => 'required|email|max:255',
            'nieuwsbrief'=> 'nullable|boolean',
            'option1'    => 'nullable|integer|min:0',
            'option2'    => 'nullable|integer|min:0',
            'option3'    => 'nullable|integer|min:0',
            'day'        => 'required|date'
        ], [
            'day.required' => 'Selecteer een moment waarop je jouw bestelling kan komen ophalen.',
            'day.date' => 'Selecteer een moment waarop je jouw bestelling kan komen ophalen.',
        ]);

        $validated['nieuwsbrief'] = $request->has('nieuwsbrief') ? 1 : 0;

        $validated['option1'] = $validated['option1'] ?? 0;
        $validated['option2'] = $validated['option2'] ?? 0;
        $validated['option3'] = $validated['option3'] ?? 0;

        if (
            ($request->input('option1') == 0 || $request->input('option1') === null) &&
            ($request->input('option2') == 0 || $request->input('option2') === null) &&
            ($request->input('option3') == 0 || $request->input('option3') === null)
        ) {
            return back()
                ->withErrors(['options' => 'Je hebt nog geen bestelling gemaakt.'])
                ->withInput();
        }

        $sessionClient = $request->session()->get('client');
        $sessionOrder = $request->session()->get('order');

        if ($sessionClient) {
            // 🔹 Case 1: Session client exists
            $sessionClient = Client::find($sessionClient->id);

            if ($sessionClient && $sessionClient->email === $validated['email']) {
                // ✅ Same email → update existing client
                $sessionClient->update([
                    'first_name' => $validated['first_name'],
                    'last_name' => $validated['last_name'],
                    'phone'      => $validated['phone'],
                    'nieuwsbrief'=> $validated['nieuwsbrief'],
                ]);
                $client = $sessionClient;

            } else {
                // 🚨 Email changed
                $existingClient = Client::where('email', $validated['email'])->first();

                if ($existingClient) {
                    // ✅ Extra safety: check phone
                    if (
                        $validated['phone'] &&
                        $existingClient->phone &&
                        $existingClient->phone === $validated['phone']
                    ) {
                        // Phone matches → reuse existing client
                        $existingClient->update([
                            'device_id'  => uniqid(),
                            'first_name' => $validated['first_name'],
                            'last_name' => $validated['last_name'],
                            'nieuwsbrief'=> $validated['nieuwsbrief']
                        ]);
                        $client = $existingClient;
                    } else {
                        // 🚨 Phone mismatch or missing → create new client
                        $client = Client::create([
                            'first_name' => $validated['first_name'],
                            'last_name'  => $validated['last_name'],
                            'phone'      => $validated['phone'],
                            'email'      => $validated['email'],
                            'nieuwsbrief'=> $validated['nieuwsbrief'],
                            'device_id'  => uniqid(),
                        ]);
                    }
                } else {
                    // ✅ No client with that email → create new one
                    $client = Client::create([
                        'first_name' => $validated['first_name'],
                        'last_name'  => $validated['last_name'],
                        'phone'      => $validated['phone'],
                        'email'      => $validated['email'],
                        'nieuwsbrief'=> $validated['nieuwsbrief'],
                        'device_id'  => uniqid(),
                    ]);
                }
            }

        } else {
            // 🔹 Case 2: No session client
            $existingClient = Client::where('email', $validated['email'])->first();

            if (!$existingClient) {
                // 2.1 Email does not exist → create new client
                $client = Client::create([
                    'first_name' => $validated['first_name'],
                    'last_name'  => $validated['last_name'],
                    'phone'      => $validated['phone'],
                    'email'      => $validated['email'],
                    'nieuwsbrief' => $validated['nieuwsbrief'],
                    'device_id'  => uniqid(),
                ]);

            } else {
                // 2.2 Email exists → check phone
                if (
                    $validated['phone'] &&
                    $existingClient->phone &&
                    $existingClient->phone === $validated['phone']
                ) {
                    // ✅ Safe reuse → update client
                    $existingClient->update([
                        'first_name' => $validated['first_name'],
                        'last_name' => $validated['last_name'],
                        'device_id'  => uniqid(),
                    ]);
                    $client = $existingClient;
                } else {
                    // 🚨 Phone mismatch/missing → create new client (duplicate email allowed)
                    $client = Client::create([
                        'first_name' => $validated['first_name'],
                        'last_name'  => $validated['last_name'],
                        'phone'      => $validated['phone'],
                        'email'      => $validated['email'],
                        'nieuwsbrief'=> $validated['nieuwsbrief'],
                        'device_id'  => uniqid(),
                    ]);
                }
            }
        }

        // ✅ Always refresh cookie with latest device_id
        Cookie::queue(cookie('device_id', $client->device_id, 60 * 24 * 365));

        if ($sessionOrder) {
            // Fetch the order from DB
            $order = Order::find($sessionOrder->id);

            if ($order) {
                // Update the existing order
                $order->update([
                    'option1' => $validated['option1'],
                    'option2' => $validated['option2'],
                    'option3' => $validated['option3'],
                    'day'     => $validated['day'],
                    'payed'   => false
                ]);
            } else {
                // Session has invalid order id → create new order
                $order = Order::create([
                    'client_id' => $client->id,
                    'option1'   => $validated['option1'],
                    'option2'   => $validated['option2'],
                    'option3'   => $validated['option3'],
                    'day'       => $validated['day'],
                    'payed'   => false
                ]);
            }
        } else {
            // No session order → create new
            $order = Order::create([
                'client_id' => $client->id,
                'option1'   => $validated['option1'],
                'option2'   => $validated['option2'],
                'option3'   => $validated['option3'],
                'day'       => $validated['day'],
                'payed'     => false
            ]);
        }


        // ✅ Update session
        session([
            'order'  => $order,
            'client' => $client,
        ]);

        return redirect()->route('checkout', [
            'client_id' => $client->id,
            'order_id'  => $order->id,
        ]);
    }
}
