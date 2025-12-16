<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Client;
use App\Models\TurnVoucher;
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

    public function afhaalmomenten()
    {
        return view('dashboard.afhaalmomenten');
    }

    public function bestellingen()
    {
        $beginoftheweek = Carbon::now()->startOfWeek();
        $bestellingen = Order::where('day', '>', $beginoftheweek)
            ->orderBy('takeaway_date')
            ->orderByDesc('created_at')
            ->get();
        return view('dashboard.bestellingen', ['bestellingen' => $bestellingen]);
    }

    public function bonnen()
    {
        return view('dashboard.bonnen');
    }

    public function kaarten()
    {
        $beurtenkaarten = TurnVoucher::all();
        $cadeaubonnen = TurnVoucher::all();
        return view('dashboard.kaarten', ['beurtenkaarten' => $beurtenkaarten, 'cadeaubonnen' => $cadeaubonnen]);
    }

    public function klanten()
    {
        $klanten = Client::all();
        return view('dashboard.klanten', ['klanten' => $klanten]);
    }

    public function development()
    {
        return view('dashboard.development');
    }
}
