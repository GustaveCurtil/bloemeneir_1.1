<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;

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

Route::get('/boeketten/bestellen', [PageController::class, 'bestellen'])->name('checkout.backToForm');

Route::get('/checkout', [PageController::class, 'checkout'])->name('checkout');

Route::post('/order', [OrderController::class, 'store'])->name('order');




Route::get('/order', [PaymentController::class, 'orderForm']);
// Route::post('/order', [PaymentController::class, 'processOrder'])->name('order');
Route::get('/success', [PaymentController::class, 'success'])->name('checkout.success');
