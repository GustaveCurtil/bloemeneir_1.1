<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class CheckClientSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Check if client exists in session
        if (!$request->session()->has('client')) {
            
            // 2. Check if device_id exists (e.g. cookie or request header)
            $deviceId = $request->cookie('device_id'); // or $request->input('device_id') depending on where you store it

            if ($deviceId) {
                // 3. Find or create client based on device_id
                $client = Client::where('device_id', $deviceId)->first();

                if ($client) {
                    // Store client in session
                    $request->session()->put('client', $client);
                } else {
                    Cookie::queue(Cookie::forget('device_id'));
                }
            }
        }

        return $next($request);
    }
}
