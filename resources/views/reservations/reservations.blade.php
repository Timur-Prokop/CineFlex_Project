@extends('layouts.layout')

@section('content')

    @vite(['resources/css/reservations.css'])

    <main class="reservations-page">

        <div class="reservations-container">

            <header class="reservations-header">

                <div>
                    <span class="reservations-eyebrow">
                        CINEFLEX
                    </span>

                    <h1>Mijn reserveringen</h1>

                    <p>
                        Een overzicht van je gereserveerde plaatsen.
                    </p>
                </div>

            </header>


            @if (session('success'))
                <div class="reservation-alert reservation-alert--success">
                    {{ session('success') }}
                </div>
            @endif


            @if ($errors->any())
                <div class="reservation-alert reservation-alert--error">
                    {{ $errors->first() }}
                </div>
            @endif


            @if (
                    $upcomingReservationsByScreening->isEmpty() &&
                    $pastReservationsByScreening->isEmpty()
                )

                <section class="reservations-empty">
                    <div class="reservations-empty__icon">🎟</div>

                    <h2>Nog geen reserveringen</h2>

                    <p>Je hebt momenteel geen plaatsen gereserveerd.</p>

                    <a href="{{ route('films.index') }}" class="reservations-empty__button">
                        Bekijk films
                    </a>
                </section>

            @else

                {{-- Upcoming reservations --}}
                <section class="reservation-section">
                    <header class="reservation-section__header">
                        <div>
                            <span class="reservations-eyebrow">BINNENKORT</span>
                            <h2>Aankomende reserveringen</h2>
                            <p>Films die nog moeten beginnen of nog bezig zijn.</p>
                        </div>

                        <span class="reservation-section__count">
                {{ $upcomingReservationsByScreening->count() }}
            </span>
                    </header>

                    @if ($upcomingReservationsByScreening->isEmpty())
                        <p class="reservation-section__empty">
                            Je hebt geen aankomende reserveringen.
                        </p>
                    @else
                        <div class="reservations-list">
                            @foreach ($upcomingReservationsByScreening as $screeningId => $reservations)
                                @include('reservations.partials.card', [
                                    'reservations' => $reservations,
                                ])
                            @endforeach
                        </div>
                    @endif
                </section>


                {{-- Past reservations --}}
                <section class="reservation-section reservation-section--past">
                    <header class="reservation-section__header">
                        <div>
                            <span class="reservations-eyebrow">ARCHIEF</span>
                            <h2>Eerdere reserveringen</h2>
                            <p>Films waarvan de voorstelling is afgelopen.</p>
                        </div>

                        <span class="reservation-section__count">
                            {{ $pastReservationsByScreening->count() }}
                        </span>
                    </header>

                    @if ($pastReservationsByScreening->isEmpty())
                        <p class="reservation-section__empty">
                            Je hebt nog geen eerdere reserveringen.
                        </p>
                    @else
                        <div class="reservations-list">
                            @foreach ($pastReservationsByScreening as $screeningId => $reservations)
                                @include('reservations.partials.card', [
                                    'reservations' => $reservations,
                                ])
                            @endforeach
                        </div>
                    @endif
                </section>

            @endif

        </div>

    </main>

@endsection
