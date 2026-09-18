@extends('layouts.layout')

@section('content')

    ```
    @vite(['resources/css/profile.css'])

    <div class="profile-container">

        <div class="profile-card">

            <div class="profile-avatar">
                {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
            </div>

            <h1>
                {{ auth()->user()->first_name }}
                {{ auth()->user()->prefix }}
                {{ auth()->user()->surname }}
            </h1>

            <p class="profile-subtitle">
                Mijn profiel
            </p>

            <div class="profile-info">

                <div class="profile-row">
                    <span class="profile-label">Voornaam</span>
                    <span class="profile-value">
                    {{ auth()->user()->first_name }}
                </span>
                </div>

                <div class="profile-row">
                    <span class="profile-label">Achternaam</span>
                    <span class="profile-value">
                    {{ auth()->user()->prefix }}
                        {{ auth()->user()->surname }}
                </span>
                </div>

                <div class="profile-row">
                    <span class="profile-label">Geboortedatum</span>
                    <span class="profile-value">
                    {{ auth()->user()->date_of_birth->format('d-m-Y') }}
                </span>
                </div>

                <div class="profile-row">
                    <span class="profile-label">E-mailadres</span>
                    <span class="profile-value">
                    {{ auth()->user()->email }}
                </span>
                </div>

            </div>

            <div class="profile-actions">

                <a
                    href="#"
                    class="profile-button profile-button-primary"
                >
                    Profiel bewerken
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="profile-button profile-button-logout"
                    >
                        Uitloggen
                    </button>
                </form>

            </div>

        </div>

    </div>
    ```

@endsection
