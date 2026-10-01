@extends('layouts.layout')

@section('content')

    @vite([
        'resources/css/reset-password.css',
        'resources/js/reset-password.js'
    ])

    <div class="reset-container">
        <div class="reset-card">

            <div class="reset-header">
                <span class="reset-eyebrow">CINEFLEX</span>

                <h1>Nieuw wachtwoord</h1>

                <p class="reset-subtitle">
                    Kies een nieuw wachtwoord voor je account.
                </p>
            </div>

            @if ($errors->any())
                <div class="form-errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('password.update') }}"
                class="reset-form"
            >
                @csrf

                <input
                    type="hidden"
                    name="token"
                    value="{{ $token }}"
                >

                <div class="form-field">
                    <label
                        for="email"
                        class="form-label"
                    >
                        E-mailadres
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', request()->email) }}"
                        class="form-input"
                        placeholder="jouw@email.nl"
                        autocomplete="email"
                        required
                    >
                </div>

                <div class="form-field">
                    <label
                        for="password"
                        class="form-label"
                    >
                        Nieuw wachtwoord
                    </label>

                    <div class="password-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input"
                            placeholder="Voer je nieuwe wachtwoord in"
                            autocomplete="new-password"
                            required
                        >

                        <button
                            type="button"
                            id="toggle-password"
                            class="password-toggle"
                            aria-label="Show password"
                        >
                            Show
                        </button>
                    </div>
                </div>

                <div class="form-field">
                    <label
                        for="password_confirmation"
                        class="form-label"
                    >
                        Bevestig wachtwoord
                    </label>

                    <div class="password-wrapper">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-input"
                            placeholder="Herhaal je nieuwe wachtwoord"
                            autocomplete="new-password"
                            required
                        >

                        <button
                            type="button"
                            id="toggle-password-confirmation"
                            class="password-toggle"
                            aria-label="Show password"
                        >
                            Show
                        </button>
                    </div>
                </div>

                <button
                    type="submit"
                    class="reset-button"
                >
                    Wachtwoord wijzigen
                </button>
            </form>

            <hr>

            <div class="reset-links">
                <a href="{{ route('login') }}">
                    ← Terug naar login
                </a>
            </div>

        </div>
    </div>

@endsection
