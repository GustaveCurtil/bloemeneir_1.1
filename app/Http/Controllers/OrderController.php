<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Client;
use Illuminate\Http\Request;

class OrderController extends Controller
{
public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'phone' => 'required|max:20',
            'email' => 'required|email|max:255',
            'option1' => 'nullable|integer|min:0',
            'option2' => 'nullable|integer|min:0',
            'option3' => 'nullable|integer|min:0',
        ]);

        $validated['option1'] = $validated['option1'] ?? 0;
        $validated['option2'] = $validated['option2'] ?? 0;
        $validated['option3'] = $validated['option3'] ?? 0;

        // Create or find the client (based on email to avoid duplicates)
        $client = Client::firstOrCreate(
            ['email' => $validated['email']],
            [
                'first_name' => $validated['first_name'],
                'last_name' => '', // you could split naam if you want
                'phone' => $validated['phone'],
                'device_id' => uniqid(), // or something meaningful
            ]
        );

        // Create the order
        $order = Order::create([
            'client_id' => $client->id,
            'option1'   => $validated['option1'] ?? 0,
            'option2'   => $validated['option2'] ?? 0,
            'option3'   => $validated['option3'] ?? 0,
            'wich_friday' => now()->toDateString(), // or let user pick
        ]);

        return redirect()->route('checkout', [
            'client_id' => $client->id,
            'order_id'  => $order->id,
        ]);
    }
}
