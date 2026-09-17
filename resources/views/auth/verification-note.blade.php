@extends('layouts.layout')

@section('content')

    @vite(['resources/css/verification-note.css'])

    <div class="verification-container">
        <div class="verification-card">

            <div class="verification-icon">
                ✉
            </div>

            <h1>Verifieer je e-mailadres</h1>

            <p class="verification-subtitle">
                @if (session('status') === 'verification-link-sent')
                    We hebben een verificatielink naar <strong> {{ auth()->user()->email }}</strong> gestuurd.
                @elseif(session('status') === 'verification-link-resent')
                    Een nieuwe verificatielink is naar je e-mailadres gestuurd.
                @endif
                    Klik op de link in de e-mail om je account te activeren.
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

            <div class="verification-email">
                {{ auth()->user()->email }}
            </div>

            <form method="POST" action="{{ route('resend.verification.link') }}">
                @csrf

                <button
                    type="submit"
                    class="verification-button"
                >
                    Verificatie-e-mail opnieuw versturen
                </button>
            </form>

            <hr>

            <div class="verification-links">
                <p>
                    Verkeerd e-mailadres?
                    <a href="{{ route('verification.edit.mail') }}">
                        E-mailadres wijzigen
                    </a>
                </p>

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
