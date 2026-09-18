@extends('layouts.layout')

@section('content')

    @vite(['resources/css/verification-is-completed.css'])

    <div class="verification-complete-container">
        <div class="verification-complete-card">

            <div class="verification-complete-icon">
                ✓
            </div>

            <h1>E-mailadres geverifieerd!</h1>

            <p class="verification-complete-subtitle">
                Je e-mailadres is succesvol geverifieerd.
                Je account is nu volledig geactiveerd.
            </p>

            <a
                href="{{ route('films') }}"
                class="verification-complete-button"
            >
                Naar films
            </a>

        </div>
    </div>

@endsection
