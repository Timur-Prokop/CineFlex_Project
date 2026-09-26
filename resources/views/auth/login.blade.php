@extends('layouts.layout')

@section('content')

    @vite(['resources/css/login.css', 'resources/js/login.js'])

    <div class="login-container">
        <div class="login-card">

            <h1>Zullen wij beginnen?</h1>

            <p class="login-subtitle">
                Log in om verder te gaan naar Cineflex.
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

            <form action="" method="POST">
                @csrf

                <div class="form-field">
                    <label for="email" class="form-label">
                        Email
                    </label>

                    <input
                        type="email"
                        id="login-email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-input"
                        autocomplete="email"
                        required
                    >
                </div>

                <div class="form-field">
                    <label for="password" class="form-label">
                        Password
                    </label>

                    <div class="password-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input"
                            autocomplete="current-password"
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

                <div class="remember-field">
                    <input
                        type="checkbox"
                        id="remember"
                        name="remember"
                    >

                    <label for="remember">
                        Remember me
                    </label>
                </div>

                <button
                    type="submit"
                    name="submit"
                    class="login-button"
                >
                    Login
                </button>
            </form>

            <hr>

            <div class="login-links">
                <p>
                    Geen profiel?
                    <a href="{{ route('register') }}" id="register-link">
                        Maak een nieuwe account
                    </a>
                </p>

                <a href="{{ route('password.reset') }}">
                    Wachtwoord vergeten?
                </a>
            </div>

        </div>
    </div>

@endsection
