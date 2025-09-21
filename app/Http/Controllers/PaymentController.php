<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $products = [
        'option1' => ['name' => 'Schattige boeketten', 'price' => 3000], // €30
        'option2' => ['name' => 'Charmante boeketten', 'price' => 5000], // €50
        'option3' => ['name' => 'Magnifieke boeketten', 'price' => 6000], // €60
    ];

    public function orderForm()
    {
        return view('order');
    }

    public function processOrder(Request $request)
    {
        // Haal het aantal op
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

        return view('checkout', [
            'clientSecret' => $paymentIntent->client_secret,
            'items' => $items,
            'totalAmount' => $totalAmount,
            'userData' => $userData,
        ]);
    }

    public function success(Request $request)
    {
        $paymentIntentId = $request->query('payment_intent');

        if (!$paymentIntentId) {
            return "Geen betaling gevonden.";
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

        if ($paymentIntent->status === 'succeeded') {
            return "✅ Betaling succesvol! Bedankt voor je bestelling.";
        } elseif ($paymentIntent->status === 'processing') {
            return "⏳ Je betaling wordt nog verwerkt. Even geduld!";
        } elseif ($paymentIntent->status === 'requires_payment_method') {
            return "❌ Betaling mislukt of geannuleerd. Probeer opnieuw.";
        } else {
            return "⚠️ Onbekende status: {$paymentIntent->status}";
        }
    }

    public function failed()
    {

        return "Betaling onsuccesvol! Bedankt voor te proberen.";
    }
}
