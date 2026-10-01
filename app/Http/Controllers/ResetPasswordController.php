<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use function Illuminate\Events\queueable;

class ResetPasswordController extends Controller
{
    public function create () {
        return view('auth.forgot-password');
    }

    public function store (Request $request) {
        $validated = $request->validate(
            [
                'email' => 'required|email|exists:users,email',
            ],
            [
                'email.required' => 'Vul je e-mailadres in.',
                'email.email' => 'Vul een geldig e-mailadres in.',
                'email.exists' => 'Er bestaat geen account met dit e-mailadres.',
            ]
        );

        $status = Password::sendResetLink([
            'email' => $validated['email'],
        ]);

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        return back()->withErrors([
            'email' => __($status),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'token' => [
                'required',
            ],

            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'confirmed',
                \Illuminate\Validation\Rules\Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            [
                'token.required' => 'Token bestaat niet.',

                'email.required' => 'Vul het e-mailadres in.',
                'email.email' => 'Onjuiste e-mailadres format',

                'password.required' => 'Vul het wachtwoord in.',
                'password.confirmed' => 'De wachtwoorden komen niet overeen.',
            ]
        ]);

        $status = Password::reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),

            function ($user, $password) {

                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()
                ->route('login')
                ->with('status', 'Je wachtwoord is succesvol gewijzigd.');
        }

        return back()->withErrors([
            'email' => __($status),
        ]);
    }
}
