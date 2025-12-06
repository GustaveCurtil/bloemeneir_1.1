<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Order;
use App\Models\Client;
use Stripe\PaymentIntent;
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
            'email'      => 'required|email|max:255',
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

            'turnCardCodes' => 'array',
            'turnCardCodes.*' => 'string',

            'giftCardCodes' => 'array',
            'giftCardCodes.*' => 'string',

            'day' => 'required'
        ]);

        // 1️⃣ calculate real price
        // $total = $this->calculateTotal($validated);
        $total = 100;

        $client = Client::create([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'phone'      => $validated['phone'],
            'email'      => $validated['email'],
            'nieuwsbrief'=> $validated['nieuwsbrief'],
        ]);

        // 2️⃣ create draft order
        $order = Order::create([
            'client_id' => $client->id,   // or null, or $request->client_id
            'option1'   => $validated['boeket_A'],
            'option2'   => $validated['boeket_B'],
            'option3'   => $validated['boeket_C'],
            'day'       => $validated['day'],
            'payed'     => false, // default until payment succeeds
        ]);

        // 3️⃣ create paymentintent
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $intent = PaymentIntent::create([
            'amount' => $total * 100,
            'currency' => 'eur',
            'payment_method_types' => ['card', 'bancontact'],
        ]);

        // save intent id
        // $order->update(['payment_intent_id' => $intent->id]);

        // 4️⃣ show payment page
        return view('payment', [
            'clientSecret' => $intent->client_secret,
            'order' => $order
        ]);
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
