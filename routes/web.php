<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('constructie');
});

Route::get('/landing', function () {
    return view('landing');
})->name('landing');

Route::get('/sfeer', function () {
    return view('over');
})->name('over');

Route::get('/boeketten', function () {
    return view('aanbod');
})->name('aanbod');

Route::get('/info', function () {
    return view('contact');
})->name('contact');

Route::get('/boeketten/bestellen', function () {
    return view('boeket');
});

Route::post('/orders', [OrderController::class, 'store'])->name('order');
