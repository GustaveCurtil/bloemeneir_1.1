<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('constructie');
});

Route::get('/landing', function () {
    return view('landing');
})->name('landing');

Route::get('/sfeer', function () {
    return view('over');
})->name('over');

Route::get('/bestellen', function () {
    return view('aanbod');
})->name('aanbod');

Route::get('/info', function () {
    return view('contact');
})->name('contact');
