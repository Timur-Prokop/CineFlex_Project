<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerificationController extends Controller
{
    public function show() {
        return view('auth.verification-note');
    }

    public function sendLink(Request $request) {
        $user = $request->user();

        $user->sendEmailVerificationNotification();

        //can be $request->user()->sendEmailVerificationNotification()

        return back()->with('status', 'verification-link-sent');
    }

    public function resendLink(Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-resent');
    }

    public function edit() {
        return view('auth.verification-change-email');
    }

    public function update(Request $request) {
        $validated = $request->validate(
            [
                'email' => [
                    'required',
                    'email',
                    'confirmed',
                    'unique:users,email',
                ],
            ],
            [
                'email.required' => 'Vul je e-mailadres in.',
                'email.email' => 'Vul een geldig e-mailadres in.',
                'email.confirmed' => 'De e-mailadressen komen niet overeen.',
                'email.unique' => 'Er bestaat al een account met dit e-mailadres.',
            ]
        );

        $user = $request->user();

        $user->email = $validated['email'];
        $user->email_verified_at = null;
        $user->save();

        $user->sendEmailVerificationNotification();

        return redirect()
            ->route('verification.note');
    }

    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        $request->fulfill();

        $request->session()->flash('verification_completed', true);

        return redirect()->route('account.is.verified');
    }


}
