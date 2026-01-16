<?php

use App\Http\Controllers\ContactFormController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
});

Route::get('/contact', function () {
    return view('contact_form');
});

Route::post('/contact/submit', [ContactFormController::class, 'store']);
