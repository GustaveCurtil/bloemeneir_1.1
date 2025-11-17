<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function overzicht()
    {
        $beginoftheweek = Carbon::now()->startOfWeek();
        $bestellingen = Order::where('day', '>', $beginoftheweek)->get();

        $klanten = Client::all();

        return view('dashboard.dashboard', ['klanten' => $klanten, 'bestellingen' => $bestellingen]);
    }
}
