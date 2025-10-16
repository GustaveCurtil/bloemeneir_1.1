<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function overzicht()
    {
        if (!Session::has('user')) {
            return redirect()->route('login.form');
        }

        return view('dashboard', ['user' => Session::get('user')]);
    }
}
