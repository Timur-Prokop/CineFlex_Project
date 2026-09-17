<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'first_name' => ['required', 'string', 'max:255'],
                'prefix' => ['nullable', 'string', 'max:50'],
                'surname' => ['required', 'string', 'max:255'],

                'date_of_birth' => [
                    'required',
                    'date',
                    'before_or_equal:' . Carbon::now()->subYears(12)->toDateString(),
                    'after_or_equal:' . Carbon::now()->subYears(105)->toDateString(),
                ],

                'email' => ['required', 'email', 'unique:users,email'],

                'password' => [
                    'required',
                    'confirmed',
                    Password::min(8)
                        ->mixedCase()
                        ->numbers()
                        ->symbols(),
                ],
            ],
            [
                'first_name.required' => 'Vul je voornaam in.',
                'first_name.max' => 'Je voornaam is te lang.',

                'surname.required' => 'Vul je achternaam in.',
                'surname.max' => 'Je achternaam is te lang.',

                'date_of_birth.required' => 'Vul je geboortedatum in.',
                'date_of_birth.date' => 'Vul een geldige geboortedatum in.',
                'date_of_birth.before_or_equal' => 'Je moet minimaal 12 jaar oud zijn.',
                'date_of_birth.after_or_equal' => 'Je mag maximaal 100 jaar oud zijn.',

                'email.required' => 'Vul je e-mailadres in.',
                'email.email' => 'Vul een geldig e-mailadres in.',
                'email.unique' => 'Er bestaat al een account met dit e-mailadres.',

                'password.required' => 'Vul een wachtwoord in.',
                'password.confirmed' => 'De wachtwoorden komen niet overeen.',
            ]
        );

        $user = User::create([
            'first_name' => $validated['first_name'],
            'prefix' => $validated['prefix'],
            'surname' => $validated['surname'],
            'date_of_birth' => $validated['date_of_birth'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        event(new Registered($user));

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('verification.note');
    }
}
