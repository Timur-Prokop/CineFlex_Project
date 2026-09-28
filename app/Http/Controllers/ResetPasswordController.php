<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function create () {
        return view('auth.reset-password');
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

        return back()->with('status', __($status));
    }
}
