<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Client;
use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PageController extends Controller
{

 
    public function bestellen()
    {
        $order = session('order');
        $client = session('client');

        Carbon::setLocale('nl'); // dag- en maandnamen in NL

        $startDate = Carbon::today();
        $dates = collect();
        $weeksChecked = 0;
        $neededDates = 6;

        while ($dates->count() < $neededDates && $weeksChecked < 10) {
            $friday = $startDate->copy()->next(Carbon::FRIDAY);
            $saturday = $startDate->copy()->next(Carbon::SATURDAY);

            $weekIsBlocked = Holiday::whereBetween(
                'week',
                [$friday->copy()->startOfWeek(), $friday->copy()->endOfWeek()]
            )->exists();

            if (!$weekIsBlocked) {
                $dates->push([
                    'date'      => $friday->toDateString(),
                    'formatted' => $friday->translatedFormat('j F'), // 6 december
                    'day'       => $friday->translatedFormat('l'),   // vrijdag
                ]);
                $dates->push([
                    'date'      => $saturday->toDateString(),
                    'formatted' => $saturday->translatedFormat('j F'),
                    'day'       => $saturday->translatedFormat('l'), // zaterdag
                ]);
            }

            $startDate->addWeek();
            $weeksChecked++;
        }

        $data = $dates->take($neededDates);

        return view('boeket', compact('order', 'client', 'data'));
    }

    public function checkout(Request $request) {
        $client = Client::findOrFail($request->client_id);
        $order  = Order::findOrFail($request->order_id);

        // Convert the selected date to a Carbon instance
        $orderDate = Carbon::parse($order->day);

            // Set locale to Dutch
        Carbon::setLocale('nl');

        // Get weekday in Dutch
        $weekday = $orderDate->translatedFormat('l'); // "vrijdag", "maandag", etc.

        // Format the date as "26 september"
        $formattedDate = $orderDate->translatedFormat('d F'); // "26 september"


        return view('checkout', [
            'client' => $client,
            'order'  => $order,
            'dag'    => $weekday,
            'datum'  => $formattedDate,
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
