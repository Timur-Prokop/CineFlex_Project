<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\RegisterController;
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






// login

Route::get('/login', [LoginController::class, 'show'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth')->post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

Route::get('/register', [RegisterController::class, 'show'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'register']);

Route::get('reset-password', [PasswordController::class, 'show'])
    ->name('reset.password');



//  films

Route::get('/films', [FilmController::class, 'index'])
    ->name('films');

Route::get('/films/add', [FilmController::class, 'create'])
    ->name('film_create');

