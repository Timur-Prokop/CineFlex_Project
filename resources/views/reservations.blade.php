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


            @if ($reservationsByScreening->isEmpty())

                <section class="reservations-empty">

                    <div class="reservations-empty__icon">
                        🎟
                    </div>

                    <h2>Nog geen reserveringen</h2>

                    <p>
                        Je hebt momenteel geen plaatsen gereserveerd.
                    </p>

                    <a
                        href="{{ route('films.index') }}"
                        class="reservations-empty__button"
                    >
                        Bekijk films
                    </a>

                </section>

            @else

                <section class="reservations-list">

                    @foreach ($reservationsByScreening as $screeningId => $reservations)

                        @php
                            $firstReservation = $reservations->first();
                            $screening = $firstReservation->screening;
                            $film = $screening->film;
                            $auditory = $screening->auditory;
                        @endphp

                        <article class="reservation-card">

                            <div class="reservation-card__poster">

                                @if ($film->pic_path)

                                    <img
                                        src="{{ $film->pic_path }}"
                                        alt="{{ $film->title }}"
                                    >

                                @else

                                    <div class="reservation-card__poster-empty">
                                        CINEFLEX
                                    </div>

                                @endif

                            </div>


                            <div class="reservation-card__body">

                                <div class="reservation-card__top">

                                    <div>

                                        <span class="reservation-card__label">
                                            RESERVERING
                                        </span>

                                        <h2>
                                            {{ $film->title }}
                                        </h2>

                                    </div>

                                    <span class="reservation-card__status">
                                        Gereserveerd
                                    </span>

                                </div>


                                <div class="reservation-card__info">

                                    <div class="reservation-info">

                                        <span class="reservation-info__label">
                                            Datum
                                        </span>

                                        <strong>
                                            {{ $screening->date_time->translatedFormat('D d M Y') }}
                                        </strong>

                                    </div>


                                    <div class="reservation-info">

                                        <span class="reservation-info__label">
                                            Tijd
                                        </span>

                                        <strong>
                                            {{ $screening->date_time->format('H:i') }}
                                        </strong>

                                    </div>


                                    <div class="reservation-info">

                                        <span class="reservation-info__label">
                                            Zaal
                                        </span>

                                        <strong>
                                            {{ $auditory->number }}
                                        </strong>

                                    </div>

                                </div>


                                <div class="reservation-card__seats">

                                    <div class="reservation-card__seats-header">
                                        <span>
                                            Plaatsen
                                        </span>

                                        <strong>
                                            {{ $reservations->count() }}
                                            {{ $reservations->count() === 1 ? 'stoel' : 'stoelen' }}
                                        </strong>
                                    </div>


                                    <div class="reservation-seat-list">

                                        @foreach ($reservations->sortBy([
                                            ['seat.row', 'asc'],
                                            ['seat.columm', 'asc'],
                                        ]) as $reservation)

                                            <div class="reservation-seat">

                                                <span class="reservation-seat__row">
                                                    {{ $reservation->seat->row }}
                                                </span>

                                                <span class="reservation-seat__number">
                                                    {{ $reservation->seat->columm }}
                                                </span>

                                                @if ($reservation->seat->fk_type == 2)
                                                    <span class="reservation-seat__type">
                                                        Duo
                                                    </span>
                                                @endif

                                            </div>

                                        @endforeach

                                    </div>

                                </div>


                                <div class="reservation-card__footer">

                                    <span>
                                        Reserveringsnummer
                                    </span>

                                    <strong>
                                        #{{ $firstReservation->id }}
                                    </strong>

                                    {{-- Future cancellation button goes here --}}
                                    {{--
                                    <form
                                        method="POST"
                                        action="{{ route('reservations.destroy', $firstReservation->id) }}"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit">
                                            Annuleren
                                        </button>
                                    </form>
                                    --}}

                                </div>

                            </div>

                        </article>

                    @endforeach

                </section>

            @endif

        </div>

    </main>

@endsection
