<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
 public function login(Request $request)
    {
        $request->validate([
            'naam' => 'required',
            'wachtwoord' => 'required',
        ]);

        // Define allowed users (hardcoded)
        $users = [
            'anne-sophie' => 'tampopo',  // username => password
            'petra'  => 'tampopo',
        ];

        $naam = $request->input('naam');
        $wachtwoord = $request->input('wachtwoord');

        if (Auth::attempt(['name' => $naam, 'password' => $wachtwoord])) {
            return redirect()->route('overzicht');
        }

        return back()->withErrors(['login' => 'Naam of wachtwoord is onjuist.']);
    }

    // public function createUser() {
    //     User::create([
    //         'name' => 'anne-sophie',
    //         'password' => bcrypt('tampopo'),
    //         'role' => 'patron'
    //     ]);
    // }
}
