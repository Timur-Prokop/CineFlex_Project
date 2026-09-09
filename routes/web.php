<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/films', function () {
    return view('films');
})->name('films');

Route::get('/catalog', function () {
    return view('catalog');
})->name('catalog');

Route::get('/medewerkers', function () {
    return view('medewerkers');
})->name('medewerkers');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');
