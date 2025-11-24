<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Date;
use App\Models\Order;
use App\Models\Client;
use App\Models\Holiday;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{

    public function bestellen()
    {
       $now = Carbon::now();

        $data = Date::where('is_public', true)
                ->whereDate('takeaway_date', '>=', $now)
                ->where(function ($query) use ($now) {
                    // Include items with no last_order_date/time or not yet passed
                    $query->whereNull('last_order_date')
                            ->orWhereNull('last_order_time')
                            ->orWhereRaw("STR_TO_DATE(CONCAT(last_order_date, ' ', last_order_time), '%Y-%m-%d %H:%i:%s') >= ?", [$now]);
                })
                ->orderBy('takeaway_date', 'asc')
                ->get()
                ->map(function ($item) {
            // Format the date in Dutch
            $formattedDate = \Carbon\Carbon::parse($item->takeaway_date)
                                ->translatedFormat('l d F');

            // Format times without leading zeros
            $startTime = \Carbon\Carbon::parse($item->takeaway_start_time)->format('G\u');
            $endTime   = \Carbon\Carbon::parse($item->takeaway_end_time)->format('G\u');

            // Combine into final string
            $item->formatted = $formattedDate . " ({$startTime} - {$endTime})";

            return $item;
        });

        return view('bestelling.winkelmand', compact('data'));
    }

    public function afrekenen() {
        return view('bestelling.afrekenen');
    }


    public function checkout(Request $request) 
    {
        $client = Client::findOrFail($request->client_id);
        $order  = Order::findOrFail($request->order_id);
        if ($order->payed) {
            return redirect()->route('winkel');
        }
        // Convert the selected date to a Carbon instance
        $orderDate = Carbon::parse($order->day);

            // Set locale to Dutch
        Carbon::setLocale('nl');

        // Get weekday in Dutch
        $weekday = $orderDate->translatedFormat('l'); // "vrijdag", "maandag", etc.

        // Format the date as "26 september"
        $formattedDate = $orderDate->translatedFormat('d F'); // "26 september"


        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Calculate total amount
        $totalAmount = (29 * $order->option1) + (39 * $order->option2) + (49 * $order->option3);

        if ($totalAmount === 0) {
            return back()->withErrors('Je moet minstens één boeket kiezen.');
        }

        // Create a PaymentIntent
        $paymentIntent = PaymentIntent::create([
            'amount' => $totalAmount * 100, // in cents
            'currency' => 'eur',
            'payment_method_types' => ['bancontact'],
            'description' => 'Boeket bestelling: ' .
                            implode(', ', array_filter([
                                $order->option1 ? "Schattig x{$order->option1}" : null,
                                $order->option2 ? "Charmant x{$order->option2}" : null,
                                $order->option3 ? "Magnifiek x{$order->option3}" : null,
                            ])),
            'metadata' => [
                'client_id' => $client->id,
                'order_id' => $order->id,
            ],
        ]);

        $clientSecret = $paymentIntent->client_secret;


        return view('bestelling.checkout', [
            'client' => $client,
            'order'  => $order,
            'dag'    => $weekday,
            'datum'  => $formattedDate,
            'clientSecret' => $clientSecret,
        ]);
    }


    public function backToForm(Request $request)
    {

        session([
            'order' => $request->order,   // or $order model/array
            'client' => $request->client, // or $client model/array
        ]);

        return redirect()->route('boeketten.bestellen');
    }
}
