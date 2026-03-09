<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\GiftVoucher;
use App\Models\Order;
use App\Models\TurnVoucher;
use Carbon\Carbon;
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
        $bonnen = GiftVoucher::all();
        return view('dashboard.bonnen', ['bonnen' => $bonnen]);
    }

    public function kaarten()
    {
        $beurtenkaarten = TurnVoucher::whereHas('order', function ($query) {
     $query->where('payed', true);
})->get();
        return view('dashboard.kaarten', ['kaarten' => $beurtenkaarten]);
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
