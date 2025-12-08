<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Order;
use App\Models\Client;
use Stripe\PaymentIntent;
use App\Mail\OrderConfirmed;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\MailPetrannesophie;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    protected $products = [
        'option1' => ['name' => 'Schattige boeketten', 'price' => 2900], 
        'option2' => ['name' => 'Charmante boeketten', 'price' => 3900],
        'option3' => ['name' => 'Magnifieke boeketten', 'price' => 4900],
    ];


    public function processOrder(Request $request)
    {
        $quantities = [
            'option1' => (int) $request->input('option1', 0),
            'option2' => (int) $request->input('option2', 0),
            'option3' => (int) $request->input('option3', 0),
        ];

        $userData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
        ];

        $items = [];
        $totalAmount = 0;

        foreach ($this->products as $key => $product) {
            if ($quantities[$key] > 0) {
                $items[] = [
                    'name' => $product['name'],
                    'quantity' => $quantities[$key],
                    'unit_price' => $product['price'],
                ];
                $totalAmount += $product['price'] * $quantities[$key];
            }
        }

        if ($totalAmount === 0) {
            return back()->withErrors('Je moet minstens één boeket kiezen.');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $paymentIntent = PaymentIntent::create([
            'amount' => $totalAmount,
            'currency' => 'eur',
            'payment_method_types' => ['bancontact'],
            'description' => 'Boeket bestelling: ' . implode(', ', array_map(fn($i) => $i['name'].' x'.$i['quantity'], $items)),
            'metadata' => [
                'first_name' => $request->input('first_name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'pickup_day' => $request->input('day'),
            ],
        ]);

        return view('bestelling.checkout', [
            'clientSecret' => $paymentIntent->client_secret,
            'items' => $items,
            'totalAmount' => $totalAmount,
            'userData' => $userData,
        ]);

    }


    public function success(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            return "Geen betaling gevonden (geen session_id).";
        }

        // 1. Retrieve the checkout session
        $session = \Stripe\Checkout\Session::retrieve($sessionId);

        // 2. Extract payment_intent ID from the session
        $paymentIntentId = $session->payment_intent;
        if (!$paymentIntentId) {
            return "Geen payment intent ID gevonden.";
        }

        // 3. Retrieve the actual PaymentIntent object
        $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

        if ($paymentIntent->status !== 'succeeded') {
            dd($paymentIntent->status);
        }

        $clientId = $session->metadata->clientId ?? null;
        $orderId  = $session->metadata->orderId ?? null;

        if (!$clientId || !$orderId) {
            return "Geen klant- of bestelgegevens gevonden.";
        }

        $client = Client::find($clientId);
        $order = Order::find($orderId);
        
        //1.bekijk alle boeketten

        //2.bekijk de cadeaubon: genereer code en maak aan.

        //3.bekijk alle oude 5 beurtenkaarten en bereken hoeveel er overblijven
        $previousCodes= [];

        //4.bekijk alle nieuwe 5 beurtenkaarten: genereen code, maak aan

        //5.bekijk alle oude cadeaubonnne en bereken hoevel er overblijven



        $orderDate = Carbon::parse($order->day);
        Carbon::setLocale('nl');
        $weekday = $orderDate->translatedFormat('l'); // "vrijdag", "maandag", etc.
        $formattedDate = $orderDate->translatedFormat('d F'); // "26 september"

        return view('bestelling.succes', [
            'paymentIntent' => $paymentIntent,
            'status' => $paymentIntent->status,
            'client' => $client,
            'dag' => $weekday,
            'datum' => $formattedDate
        ]);
    }
    
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
    //             $weekday = $orderDate->translatedFormat('l'); // "vrijdag", "maandag", etc.
    //             $formattedDate = $orderDate->translatedFormat('d F'); // "26 september"

    //         if (!$order->payed) {

    //             $order->payed = true;

    //             // $order->stripe_payment_intent_id = $paymentIntent->id;
    //             $order->save(); 
    //             Mail::to($client->email)->send(new OrderConfirmed($order, $weekday, $formattedDate));
    //             Mail::to('info@bloemenier.be')
    //                 // ->cc([
    //                 //     'annesophie@fullscalearchitecten.be',
    //                 //     'gustave.curtil@tutanota.com',
    //                 // ])
    //                 ->send(new MailPetrannesophie($order, $weekday, $formattedDate));
    //         }

    //         $request->session()->forget('order');

    //         return view('bestelling.succes', [
    //             'client' => $client,
    //             'dag' => $weekday,
    //             'datum' => $formattedDate
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
