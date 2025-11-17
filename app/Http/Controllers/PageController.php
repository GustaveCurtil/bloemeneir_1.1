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

        $now = Carbon::now('Europe/Brussels');

        // Wednesday 18:00 of this week
        $wednesdayCutoff = $now->copy()->startOfWeek()->addDays(2)->setTime(18, 0, 0);

        // Determine start of the active week
        $weekStart = $now->copy()->startOfWeek();

        // If it’s after Wednesday 18:00, move to next week
        if ($now->gt($wednesdayCutoff)) {
            $weekStart->addWeek();
        }

        // Friday and Saturday of that (possibly next) week
        $firstFriday = $weekStart->copy()->addDays(4);   // Friday
        $firstSaturday = $firstFriday->copy()->addDay();  // Saturday
        \Log::info('Now: ' . $now);
        \Log::info('Cutoff: ' . $wednesdayCutoff);
        \Log::info('Friday: ' . $firstFriday);
        \Log::info('Saturday: ' . $firstSaturday);
        $dates = collect();
        $weeksChecked = 0;
        $neededDates = 6;
        $maxWeeksToCheck = 10; // veiligheidsstop om niet oneindig te loopen

        while ($dates->count() < $neededDates && $weeksChecked < $maxWeeksToCheck) {
            // bepaal de start van de week die we nu checken
            $currentWeekStart = $weekStart->copy()->addWeeks($weeksChecked);

            // Friday = maandag + 4 dagen
            $friday = $currentWeekStart->copy()->addDays(4);
            $saturday = $friday->copy()->addDay();

            // Holiday-check: zorg dat we de juiste kolom gebruiken (hier 'date')
            $weekIsBlocked = Holiday::whereBetween(
                'week',
                [
                    $currentWeekStart->copy()->startOfWeek(Carbon::MONDAY)->toDateString(),
                    $currentWeekStart->copy()->endOfWeek(Carbon::MONDAY)->toDateString()
                ]
            )->exists();

            if (! $weekIsBlocked) {
                $dates->push([
                    'date'      => $friday->toDateString(),
                    'formatted' => $friday->translatedFormat('j F'),
                    'day'       => $friday->translatedFormat('l'),
                ]);

                // check nogmaals of we na het pushen al genoeg hebben
                if ($dates->count() < $neededDates) {
                    $dates->push([
                        'date'      => $saturday->toDateString(),
                        'formatted' => $saturday->translatedFormat('j F'),
                        'day'       => $saturday->translatedFormat('l'),
                    ]);
                }
            }

            $weeksChecked++;
        }

        $data = $dates->sortBy('date')->values()->take($neededDates);

        return view('bestelling.winkelmand', compact('order', 'client', 'data'));
    }


    public function checkout(Request $request) 
    {
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
