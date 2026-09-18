@extends('layouts.layout')

@section('content')

    @vite(['resources/css/verification-change-email.css'])

    <div class="change-email-container">
        <div class="change-email-card">

            <div class="change-email-icon">
                ✉
            </div>

            <h1>Wijzig je e-mailadres</h1>

            <p class="change-email-subtitle">
                Heb je tijdens het registreren een verkeerd e-mailadres ingevuld?
                Vul hieronder het juiste e-mailadres in.
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

            <form method="POST" action="">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="email">Nieuw e-mailadres</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', auth()->user()->email) }}"
                        required
                        autocomplete="email"
                    >
                </div>

                <div class="form-group">
                    <label for="email_confirmation">
                        Bevestig e-mailadres
                    </label>

                    <input
                        type="email"
                        id="email_confirmation"
                        name="email_confirmation"
                        required
                        autocomplete="email"
                    >
                </div>

                <button type="submit" class="change-email-button">
                    E-mailadres wijzigen
                </button>
            </form>

            <div class="change-email-links">
                <a href="{{ route('verification.note') }}">
                    Terug naar verificatie
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="logout-button">
                        Uitloggen
                    </button>
                </form>
            </div>

        </div>
    </div>

@endsection
