<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\DashboardController;

// Route::get('/', function () {
//     return view('landing');
// })->name('landing');

Route::get('/', function () {
    return view('over');
})->name('over');

Route::get('/winkel', function () {
    return view('winkel');
})->name('winkel');

Route::get('/info', function () {
    return view('contact');
})->name('contact');

Route::get('/gdpr', function () {
    return view('gdpr');
})->name('gdpr');

Route::get('/winkel/winkelmandje', [PageController::class, 'bestellen'])->name('shopping-basket');
Route::get('/winkel/afrekenen', [PageController::class, 'afrekenen'])->name('afrekenen');

Route::get('/checkout', [PageController::class, 'checkout'])->name('checkout');

Route::get('/overzicht', [DashboardController::class, 'overzicht'])->name('overzicht');
Route::post('/login', [LoginController::class, 'login'])->name('login');
// Route::get('/maak', [LoginController::class, 'createUser']);

Route::post('/order', [OrderController::class, 'store'])->name('order');
Route::post('/check-code', [VoucherController::class, 'checkCode'])->name('check-code');
Route::post('/delete-code', [VoucherController::class, 'deleteCode'])->name('delete-code');

Route::post('/betalen', [OrderController::class, 'pay'])->name('checkout.pay');


Route::get('/order', [PaymentController::class, 'orderForm']);
// Route::post('/order', [PaymentController::class, 'processOrder'])->name('order');
Route::get('/success', [PaymentController::class, 'success'])->name('checkout.success');

Route::get('/session-test', function (Illuminate\Http\Request $request) {
    $request->session()->put('foo', 'bar');
    dd($request->session()->get('foo'));
});

