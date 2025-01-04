<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;


Route::get('/', function () {
    return view('homepage');
});

Route::get('/mission', function () {
    return view('mission');
})->name('mission');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/create', function () {
    return view('dashboard');
})->name('create');
