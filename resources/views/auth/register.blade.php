@extends('layouts.layout')

@section('content')

    @vite(['resources/css/register.css', 'resources/js/register.js'])

    <div class="register-container">
        <div class="register-card">

            <h1>Maak je account</h1>

            <p class="register-subtitle">
                Maak een account aan en ontdek Cineflex.
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

                <div class="name-row">

                    <div class="form-field">
                        <label for="first_name" class="form-label">
                            Voornaam
                        </label>

                        <input
                            type="text"
                            id="first_name"
                            name="first_name"
                            value="{{ old('first_name') }}"
                            class="form-input"
                            autocomplete="given-name"
                            required
                        >
                    </div>

                    <div class="form-field prefix-field">
                        <label for="prefix" class="form-label">
                            Tussenvoegsel
                        </label>

                        <input
                            type="text"
                            id="prefix"
                            name="prefix"
                            value="{{ old('prefix') }}"
                            class="form-input"
                            autocomplete="additional-name"
                            placeholder="bijv. van"
                        >
                    </div>

                </div>

                <div class="form-field">
                    <label for="surname" class="form-label">
                        Achternaam
                    </label>

                    <input
                        type="text"
                        id="surname"
                        name="surname"
                        value="{{ old('surname') }}"
                        class="form-input"
                        autocomplete="family-name"
                        required
                    >
                </div>

                <div class="form-field">
                    <label for="date_of_birth" class="form-label">
                        Geboortedatum
                    </label>

                    <input
                        type="date"
                        id="date_of_birth"
                        name="date_of_birth"
                        value="{{ old('date_of_birth') }}"
                        class="form-input"
                        min="{{ now()->subYears(100)->format('Y-m-d') }}"
                        max="{{ now()->subYears(12)->format('Y-m-d') }}"
                        autocomplete="bday"
                        required
                    >
                </div>

                <div class="form-field">
                    <label for="email" class="form-label">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-input"
                        autocomplete="email"
                        required
                    >
                </div>

                <div class="form-field">
                    <label for="password" class="form-label">
                        Wachtwoord
                    </label>

                    <div class="password-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input"
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
                    <label for="password_confirmation" class="form-label">
                        Bevestig wachtwoord
                    </label>

                    <div class="password-wrapper">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-input"
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
                    name="submit"
                    class="register-button"
                >
                    Account aanmaken
                </button>

            </form>

            <hr>

            <div class="register-links">
                <p>
                    Heb je al een account?
                    <a href="{{ route('login') }}">
                        Log in
                    </a>
                </p>
            </div>

        </div>
    </div>

@endsection
