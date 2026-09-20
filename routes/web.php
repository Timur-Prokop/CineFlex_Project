<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;


//HOMeeee
//HOMeeee

Route::get('/', [HomeController::class, 'index'])
    ->name('home');


Route::get('/catalog', function () {
    return view('catalog');
})->name('catalog');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');


// login

Route::get('/login', [LoginController::class, 'show'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth')->post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

// register

Route::get('/register', [RegisterController::class, 'show'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'store']);

Route::get('reset-password', [PasswordController::class, 'show'])
    ->name('reset.password');

// email verification

Route::post('/verification/send-verification-link', [VerificationController::class, 'sendLink'])
    ->name('send.verification.link');

Route::post('/verification/resend-verification-link', [VerificationController::class, 'resendLink'])
    ->name('resend.verification.link');

Route::get('/verification/note', [VerificationController::class, 'show'])
    ->name('verification.note');

Route::get('/verification/edit-your-email', [VerificationController::class, 'edit'])
    ->name('verification.edit.mail');

Route::put('/verification/edit-your-email', [VerificationController::class, 'update'])
    ->name('verification.update.mail');

Route::get('/verification/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware('signed')
    ->name('verification.verify');

Route::get('/verification/success', function () {
    if (! session('verification_completed')) {
        abort(403);
    }

    return view('auth.verification-is-completed');
})->middleware('auth')->name('account.is.verified');

//profile

Route::get('/profile', [ProfileController::class, 'show'])
    ->middleware('auth')->name('profile');

// medewerkers

Route::get('/medewerkers', [EmployeeController::class, 'index'])
    ->name('medewerkers.index');

// only for manager
Route::middleware(['auth', 'can:access-manager-area'])->group(function () {

    Route::post('/medewerkers', [EmployeeController::class, 'store'])
        ->name('medewerkers.store');

    Route::put('/medewerkers/{id}', [EmployeeController::class, 'update'])
        ->name('medewerkers.update');

    Route::delete('/medewerkers/{id}', [EmployeeController::class, 'destroy'])
        ->name('medewerkers.destroy');


});

//  films

Route::get('/films', [FilmController::class, 'index'])
    ->name('films');

Route::get('films/add', [FilmController::class, 'new'])
    ->name('show.add.film');

Route::post('films/add', [FilmController::class, 'create']);

Route::get('/films/{film}/edit', [FilmController::class, 'edit'])
    ->name('films.edit');

Route::post('/films/{film}/update', [FilmController::class, 'update'])
    ->name('films.update');

Route::delete('/films/{film}', [FilmController::class, 'destroy'])
    ->name('films.delete');
