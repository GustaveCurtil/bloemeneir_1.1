<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Client;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function checkout(Request $request) {
        $client = Client::findOrFail($request->client_id);
        $order  = Order::findOrFail($request->order_id);

        return view('checkout', [
            'client' => $client,
            'order'  => $order,
        ]);
    }
}
