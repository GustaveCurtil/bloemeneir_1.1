<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
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
        $order = session('order');
        $client = session('client');
        if ($order && $order->payed) {
            $order =null;
        }
        Carbon::setLocale('nl');

        $now = Carbon::now();
        $startDate = Carbon::today();

        // Wednesday 18:00 of the current week
        $wednesdayCutoff = $now->copy()->startOfWeek()->addDays(2)->setTime(18, 0, 0);

        // --- Find this week's Friday ---
        $firstFriday = $now->copy()->startOfWeek()->addDays(4); // Monday + 4 = Friday
        if ($now->gt($firstFriday)) {
            // if today is already after Friday, jump to next week's Friday
            $firstFriday->addWeek();
        }
        $firstSaturday = $firstFriday->copy()->addDay();

        // --- Apply cutoff logic ---
        if ($now->gt($wednesdayCutoff)) {
            // after Wednesday 18:00 → skip this week’s Fri/Sat
            $firstFriday->addWeek();
            $firstSaturday->addWeek();
        }

        $dates = collect();
        $weeksChecked = 0;
        $neededDates = 6;

        while ($dates->count() < $neededDates && $weeksChecked < 10) {
            $friday = $startDate->copy()->next(Carbon::FRIDAY);
            $saturday = $friday->copy()->addDay(); // guaranteed to be the Saturday after

            $weekIsBlocked = Holiday::whereBetween(
                'week',
                [$friday->copy()->startOfWeek(), $friday->copy()->endOfWeek()]
            )->exists();

            if (!$weekIsBlocked) {
                $dates->push([
                    'date'      => $friday->toDateString(),
                    'formatted' => $friday->translatedFormat('j F'),
                    'day'       => $friday->translatedFormat('l'),
                ]);
                $dates->push([
                    'date'      => $saturday->toDateString(),
                    'formatted' => $saturday->translatedFormat('j F'),
                    'day'       => $saturday->translatedFormat('l'),
                ]);
            }

            $startDate->addWeek();
            $weeksChecked++;
        }

        $data = $dates->sortBy('date')->values()->take($neededDates);

        return view('boeket', compact('order', 'client', 'data'));
    }

    public function checkout(Request $request) {
        $client = Client::findOrFail($request->client_id);
        $order  = Order::findOrFail($request->order_id);
        if ($order->payed) {
            return redirect()->route('aanbod');
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


        return view('checkout', [
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
