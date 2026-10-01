@extends('layouts.layout')

@section('content')

    @vite(['resources/css/forgot-password.css', 'resources/js/forgot-password.js'])

    <div class="reset-container">
        <div class="reset-card">

            <h1>Wachtwoord vergeten?</h1>

            <p class="reset-subtitle">
                Geen probleem. Vul je emailadres in en we sturen je een
                link waarmee je je wachtwoord opnieuw kunt instellen.
            </p>

            @if ($errors->any())
                <div class="form-errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="form-success">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{route('password.forgot')}}" method="POST">
                @csrf

                <div class="form-field">
                    <label for="email" class="form-label">
                        Email
                    </label>

                    <input
                        type="email"
                        id="password-reset-email"
                        name="email"
                        value="{{ old('email', request('email')) }}"
                        class="form-input"
                        autocomplete="email"
                        placeholder="jouw@email.nl"
                        required
                        autofocus
                    >
                </div>

                <button
                    type="submit"
                    class="reset-button"
                >
                    Stuur reset link
                </button>
            </form>

            <hr>

            <div class="reset-links">
                <a href="{{ route('login') }}" id="login-link">
                    ← Terug naar login
                </a>

                <p>
                    Nog geen account?
                    <a href="{{ route('register') }}" id="register-link">
                        Maak een account
                    </a>
                </p>
            </div>

        </div>
    </div>

@endsection
