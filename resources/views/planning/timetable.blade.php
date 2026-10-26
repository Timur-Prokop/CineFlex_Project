@extends('layouts.layout')

@section('content')

    @vite('resources/css/timetable.css')

    <main class="schedule-page">

        <div class="schedule-container">

            @if(session('success'))
                <div class="planning-alert planning-alert--success">
                    <span class="planning-alert__icon">✓</span>

                    <div>
                        <strong>Gelukt</strong>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="planning-alert planning-alert--error">
                    <span class="planning-alert__icon">!</span>

                    <div>
                        <strong>Actie niet uitgevoerd</strong>
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <section class="schedule-header">

                <div class="planning-actions">
                    @can('can-access-worker-area')
                        <button
                            type="button"
                            id="openPlanningButton"
                            class="new-planning-button"
                            >
                            <span>+</span>
                            Nieuwe voorstelling
                        </button>
                    @endcan
                </div>


                <div
                    id="planningEditor"
                    class="planning-editor {{ $errors->any() ? 'is-open' : '' }}"
                >

                    <div class="planning-editor__header">

                        <div>

                            <span class="planning-editor__label">
                                CINEFLEX ADMIN
                            </span>

                            <h2>
                                Nieuwe voorstelling plannen
                            </h2>

                            <p>
                                Kies een film, zaal, datum en starttijd.
                            </p>

                        </div>


                        <button
                            type="button"
                            id="closePlanningButton"
                            class="planning-close-button"
                        >
                            ×
                        </button>

                    </div>


                    @if($errors->any())

                        <div class="planning-errors">

                            <div class="planning-errors__icon">
                                !
                            </div>


                            <div>

                                <strong>
                                    Voorstelling kan niet worden toegevoegd
                                </strong>

                                <ul>

                                    @foreach($errors->all() as $error)

                                        <li>
                                            {{ $error }}
                                        </li>

                                    @endforeach

                                </ul>

                            </div>

                        </div>

                    @endif


                    <form
                        action="{{ route('planning.create') }}"
                        method="POST"
                        class="planning-form"
                    >

                        @csrf


                        <div class="planning-grid">


                            <div class="planning-field">

                                <label for="film">
                                    Film
                                    <span>*</span>
                                </label>


                                <select
                                    id="film"
                                    name="fk_film"
                                    required
                                >

                                    <option
                                        value=""
                                        disabled
                                        {{ old('fk_film') ? '' : 'selected' }}
                                    >
                                        Kies een film
                                    </option>


                                    @foreach($allFilms as $film)

                                        <option
                                            value="{{ $film->id }}"
                                            data-duration="{{ $film->duration }}"
                                            @selected(old('fk_film') == $film->id)
                                        >
                                            {{ $film->title }}
                                            — {{ $film->duration }} min
                                        </option>

                                    @endforeach

                                </select>


                                @error('fk_film')

                                <span class="planning-field-error">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>


                            <div class="planning-field">

                                <label for="auditory">
                                    Zaal
                                    <span>*</span>
                                </label>


                                <select
                                    id="auditory"
                                    name="fk_auditory"
                                    required
                                >

                                    <option
                                        value=""
                                        disabled
                                        {{ old('fk_auditory') ? '' : 'selected' }}
                                    >
                                        Kies een zaal
                                    </option>


                                    @foreach($auditories as $auditory)

                                        <option
                                            value="{{ $auditory->id }}"
                                            @selected(
                                                old('fk_auditory') == $auditory->id
                                            )
                                        >
                                            Zaal {{ $auditory->number }}
                                            — {{ $auditory->seats_quantity }} plaatsen
                                        </option>

                                    @endforeach

                                </select>


                                @error('fk_auditory')

                                <span class="planning-field-error">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>


                            <div class="planning-field">

                                <label for="screening-date">
                                    Datum
                                    <span>*</span>
                                </label>


                                <input
                                    type="date"
                                    id="screening-date"
                                    name="date"
                                    value="{{ old('date') }}"
                                    min="{{now()}}"
                                    required
                                >


                                @error('date')

                                <span class="planning-field-error">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>


                            <div class="planning-field">

                                <label for="screening-time">
                                    Starttijd
                                    <span>*</span>
                                </label>


                                <input
                                    type="time"
                                    id="screening-time"
                                    name="time"
                                    value="{{ old('time') }}"
                                    required
                                >


                                @error('time')

                                <span class="planning-field-error">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>

                        </div>


                        <div class="planning-rules">

                            <div>

                                <span class="planning-rule-dot"></span>

                                <p>
                                    Voorstellingen kunnen vanaf
                                    <strong>14:00</strong>
                                    beginnen.
                                </p>

                            </div>


                            <div>

                                <span class="planning-rule-dot"></span>

                                <p>
                                    Een film moet uiterlijk om
                                    <strong>01:30</strong>
                                    afgelopen zijn.
                                </p>

                            </div>


                            <div>

                                <span class="planning-rule-dot"></span>

                                <p>
                                    Tussen twee films in dezelfde zaal moet minimaal
                                    <strong>30 minuten</strong>
                                    zitten.
                                </p>

                            </div>

                        </div>


                        <div class="planning-form__actions">

                            <button
                                type="button"
                                id="cancelPlanningButton"
                                class="planning-cancel-button"
                            >
                                Annuleren
                            </button>


                            <button
                                type="submit"
                                class="planning-save-button"
                            >
                                Voorstelling toevoegen
                                <span>→</span>
                            </button>

                        </div>

                    </form>

                </div>


                <span class="schedule-eyebrow">
                    CINEFLEX PROGRAMMA
                </span>


                <div class="schedule-header__row">

                    <div>

                        <h1>
                            Filmagenda
                        </h1>

                        <p>
                            Bekijk welke films draaien, hoe laat ze beginnen
                            en in welke zaal je terechtkunt.
                        </p>

                    </div>


                    <a
                        href="{{ route('films') }}"
                        class="schedule-films-link"
                    >
                        Alle films
                        <span>→</span>
                    </a>

                </div>

            </section>


            <section class="schedule-content">

                @php

                    $filmsByDate = $films->groupBy(function ($film) {

                        return \Carbon\Carbon::parse(
                            $film->date_time
                        )->format('Y-m-d');

                    });

                @endphp


                @forelse($filmsByDate as $date => $dayFilms)


                    <div class="schedule-day">


                        <div class="schedule-date">

                            <span class="schedule-date__day">
                                {{
                                    \Carbon\Carbon::parse($date)
                                        ->translatedFormat('l')
                                }}
                            </span>


                            <strong>
                                {{
                                    \Carbon\Carbon::parse($date)
                                        ->format('d')
                                }}
                            </strong>


                            <span>
                                {{
                                    \Carbon\Carbon::parse($date)
                                        ->translatedFormat('M')
                                }}
                            </span>

                        </div>


                        <div class="schedule-list">


                            @foreach($dayFilms as $film)

                                <article class="schedule-film">

                                    <a href="{{route('show.film', $film->title)}}" class="schedule-film__link">
                                        <div class="schedule-film__poster">
                                            @if($film->pic_path)
                                                <img src="{{ $film->pic_path }}" alt="{{ $film->title }}">
                                            @else
                                                <div class="schedule-film__placeholder">CINEFLEX</div>
                                            @endif
                                        </div>

                                        <div class="schedule-film__info">
                                            <div class="schedule-film__main">
                                                <span class="schedule-film__label">NU TE ZIEN</span>
                                                <h2>{{ $film->title }}</h2>

                                                <div class="schedule-film__meta">
                                                    <div class="meta-item">
                                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                            <circle cx="12" cy="12" r="9"/>
                                                            <path d="M12 7v5l3 2"/>
                                                        </svg>
                                                        <span>{{ $film->duration }} min</span>
                                                    </div>

                                                    <div class="meta-item">
                                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                            <path d="M4 19v-6a8 8 0 0 1 16 0v6"/>
                                                            <path d="M2 19h20"/>
                                                        </svg>
                                                        <span>Zaal {{ $film->number }}</span>
                                                    </div>

                                                    @if(isset($film->seats_quantity))
                                                        <div class="meta-item">
                                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                                <path d="M4 18v-2a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v2"/>
                                                                <circle cx="12" cy="7" r="3"/>
                                                            </svg>
                                                            <span>{{ $film->seats_quantity }} plaatsen</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="schedule-film__time">
                                                <span>Start</span>
                                                <strong>{{ \Carbon\Carbon::parse($film->date_time)->format('H:i') }}</strong>
                                                <small>Eindigt ± {{ \Carbon\Carbon::parse($film->date_time)->addMinutes($film->duration)->format('H:i') }}</small>
                                            </div>
                                        </div>
                                    </a>

                                    <div class="schedule-film__action">
                                        <button
                                            type="button"
                                            class="schedule-reserve-button"
                                            data-screening-id="{{ $film->screening_id }}"
                                            data-auditory-id="{{ $film->fk_auditory }}"
                                            data-time="{{ \Carbon\Carbon::parse($film->date_time)->format('H:i') }}"
                                            data-auditory-number="{{ $film->number }}"
                                            data-title="{{ $film->title }}"
                                        >
                                            Plaats reserveren
                                            <span>→</span>
                                        </button>

                                        @can('can-access-worker-area')
                                            <form
                                                action="{{ route('planning.destroy', $film->id) }}"
                                                method="POST"
                                                class="screening-delete-form"
                                                onsubmit="return confirm('Weet je zeker dat je deze voorstelling wilt verwijderen?');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="screening-delete-button">
                                                    <span aria-hidden="true">×</span>
                                                    Verwijder voorstelling
                                                </button>
                                            </form>
                                        @endcan
                                    </div>

                                </article>



                            @endforeach

                        </div>

                    </div>


                @empty


                    <div class="schedule-empty">

                        <span>
                            Geen voorstellingen
                        </span>


                        <h2>
                            Er staan momenteel geen films gepland.
                        </h2>


                        <p>
                            Bekijk later opnieuw het programma.
                        </p>

                    </div>


                @endforelse

            </section>

        </div>

    </main>




    <div class="seat-modal" id="seat-modal">
        <div class="seat-modal__overlay" onclick="closeSeatModal()"></div>

        <div class="seat-modal__content">
            <button type="button" class="seat-modal__close" onclick="closeSeatModal()">×</button>

            <div class="seat-modal__header">
                <span>CINEFLEX RESERVERING</span>
                <h2>Kies je plaatsen</h2>
                <p id="seat-screening-info"></p>
            </div>

            <div class="cinema-screen">SCHERM</div>

            <div class="seat-modal__seats" id="seat-container">
                @foreach($seats->groupBy('fk_auditory') as $auditoryId => $auditorySeats)
                    <div class="auditory-seats" data-auditory="{{ $auditoryId }}">
                        @foreach($auditorySeats->groupBy('row') as $row => $rowSeats)
                            <div class="seat-row">
                                <span class="seat-row__name">{{ $row }}</span>

                                @foreach($rowSeats as $seat)
                                    @php
                                        // Dynamic aisle gap detection based on hall geometry
                                        $hasAisleAfter = false;
                                        if ($auditoryId == 1) {
                                            // Zaal 1: Both Row A and Rows B-G place the 2nd aisle AFTER column 9
                                            if ($row === 'A' && in_array($seat->columm, [2, 9])) {
                                                $hasAisleAfter = true;
                                            } elseif ($row !== 'A' && in_array($seat->columm, [1, 9])) {
                                                $hasAisleAfter = true;
                                            }
                                        } elseif ($auditoryId == 2) {
                                            // Zaal 2: Gap after 2 & 8
                                            if (in_array($seat->columm, [2, 8])) {
                                                $hasAisleAfter = true;
                                            }
                                        }
                                    @endphp

                                    <button
                                        type="button"
                                        class="seat {{ $seat->fk_type == 2 ? 'seat--double' : 'seat--standard' }} {{ $hasAisleAfter ? 'seat--aisle-after' : '' }}"
                                        data-seat-id="{{ $seat->id }}"
                                        data-seat-type="{{ $seat->fk_type }}"
                                        data-seat-row="{{ $seat->row }}"
                                        data-seat-column="{{ $seat->columm }}"
                                        title="Rij {{ $row }}, Stoel {{ $seat->columm }} {{ $seat->fk_type == 2 ? '(Duo)' : '' }}"
                                    >
                                        {{ $seat->columm }}
                                    </button>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

            <div class="seat-legend">
                <div>
                    <span class="seat-example"></span>
                    Standaard
                </div>
                <div>
                    <span class="seat-example seat-example--double"></span>
                    Duo Stoel
                </div>
                <div>
                    <span class="seat-example seat-example--selected"></span>
                    Geselecteerd
                </div>
                <div>
                    <span class="seat-example seat-example--occupied"></span>
                    Bezet
                </div>
            </div>

            <div class="seat-modal__footer">
                <span id="selected-seat-count">0 plaatsen geselecteerd</span>
                <button hidden type="button" class="seat-reserve-button" id="proceedButton">
                    Verder
                </button>
            </div>
        </div>
    </div>

    {{-- Reservation confirmation modal --}}
    <div class="reservation-modal" id="reservation-modal">
        <div
            class="reservation-modal__overlay"
            onclick="closeReservationModal()"
        ></div>

        <div class="reservation-modal__content">

            <button
                type="button"
                class="reservation-modal__close"
                onclick="closeReservationModal()"
            >
                ×
            </button>

            <div class="reservation-modal__header">
                <span>CINEFLEX RESERVERING</span>

                <h2>Reservering bevestigen</h2>

                <p>
                    Controleer je geselecteerde plaatsen.
                </p>
            </div>

            <div class="reservation-modal__details">

                <div class="reservation-modal__detail">
                    <span>Voorstelling</span>
                    <strong id="reservation-screening-info"></strong>
                </div>

                <div class="reservation-modal__detail">
                    <span>Geselecteerde plaatsen</span>

                    <div
                        class="reservation-modal__seats"
                        id="reservation-selected-seats"
                    ></div>
                </div>

            </div>

            <form
                method="POST"
                action="{{ route('reservations.store') }}"
                id="reservation-form"
            >
                @csrf

                <input
                    type="hidden"
                    name="screening_id"
                    id="reservation-screening-id"
                >

                <div id="reservation-seat-inputs"></div>

                <div class="reservation-modal__actions">

                    <button
                        type="button"
                        class="reservation-modal__cancel"
                        onclick="closeReservationModal()"
                    >
                        Terug
                    </button>

                    <button
                        type="submit"
                        class="reservation-modal__confirm"
                    >
                        Bevestig reservering
                    </button>

                </div>
            </form>

        </div>
    </div>


    <script>
        // Reserved seats for each screening.
        const reservations = @json($reservations->map(function ($reservation) {
        return [
            'seat' => $reservation->fk_seat,
            'screening' => $reservation->fk_screening,
        ];
    }));

        // Planning editor elements.
        const planningEditor = document.getElementById('planningEditor');
        const openPlanningButton = document.getElementById('openPlanningButton');
        const closePlanningButton = document.getElementById('closePlanningButton');
        const cancelPlanningButton = document.getElementById('cancelPlanningButton');

        // Reservation modal elements.
        const seatModal = document.getElementById('seat-modal');
        const screeningInfo = document.getElementById('seat-screening-info');
        const selectedSeatCount = document.getElementById('selected-seat-count');
        const proceedButton = document.getElementById('proceedButton');

        const reservationModal = document.getElementById('reservation-modal');
        const reservationScreeningInfo = document.getElementById('reservation-screening-info');
        const reservationScreeningId = document.getElementById('reservation-screening-id');
        const reservationSelectedSeats = document.getElementById('reservation-selected-seats');
        const reservationSeatInputs = document.getElementById('reservation-seat-inputs');

        let currentScreeningId = null;

        /*
         * PLANNING EDITOR
         * These elements are only available to workers.
         * Check that they exist before attaching event listeners.
         */

        if (openPlanningButton && planningEditor) {
            openPlanningButton.addEventListener('click', function () {
                planningEditor.classList.add('is-open');

                planningEditor.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        }

        if (closePlanningButton && planningEditor) {
            closePlanningButton.addEventListener('click', function () {
                planningEditor.classList.remove('is-open');
            });
        }

        if (cancelPlanningButton && planningEditor) {
            cancelPlanningButton.addEventListener('click', function () {
                planningEditor.classList.remove('is-open');
            });
        }

        document.querySelectorAll('[data-url]').forEach(button => {
            button.addEventListener('click', function () {
                window.location.href = this.dataset.url;
            });
        });

        /*
         * OPEN SEAT MODAL
         */

        function openSeatModal(screeningId, auditoryId, time, auditoryNumber, title) {
            currentScreeningId = Number(screeningId);

            seatModal.classList.add('seat-modal--active');

            screeningInfo.textContent =
                'Zaal ' + auditoryNumber + ' · ' + time + ' · ' + title;

            // Show only the auditorium for this screening.
            document.querySelectorAll('.auditory-seats').forEach(auditory => {
                auditory.style.display = 'none';
            });

            const selectedAuditory = document.querySelector(
                '.auditory-seats[data-auditory="' + auditoryId + '"]'
            );

            if (!selectedAuditory) {
                console.error('Auditorium not found:', auditoryId);
                return;
            }

            selectedAuditory.style.display = 'block';

            // Reset the previous selection and occupied-seat styling.
            document.querySelectorAll('.seat').forEach(seat => {
                seat.classList.remove('seat--selected', 'seat--occupied');
                seat.disabled = false;
            });

            // Mark seats reserved for this specific screening as occupied.
            reservations.forEach(reservation => {
                if (Number(reservation.screening) !== currentScreeningId) {
                    return;
                }

                const seat = document.querySelector(
                    '.seat[data-seat-id="' + reservation.seat + '"]'
                );

                if (seat) {
                    seat.classList.add('seat--occupied');
                    seat.disabled = true;
                }
            });

            updateSelectedSeats();
        }

        function closeSeatModal() {
            seatModal.classList.remove('seat-modal--active');
        }

        /*
         * CONNECT "PLAATS RESERVEREN" BUTTONS
         * This listener is registered only once.
         */

        document.querySelectorAll('.schedule-reserve-button').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();

                openSeatModal(
                    this.dataset.screeningId,
                    this.dataset.auditoryId,
                    this.dataset.time,
                    this.dataset.auditoryNumber,
                    this.dataset.title
                );
            });
        });

        /*
         * SELECT SEATS
         */

        document.querySelectorAll('.seat').forEach(seat => {
            seat.addEventListener('click', function () {
                if (this.classList.contains('seat--occupied')) {
                    return;
                }

                this.classList.toggle('seat--selected');

                updateSelectedSeats();
            });
        });

        function updateSelectedSeats() {
            const selectedSeats = document.querySelectorAll('.seat--selected');
            let totalCapacity = 0;

            selectedSeats.forEach(seat => {
                const type = Number(seat.dataset.seatType);

                totalCapacity += type === 2 ? 2 : 1;
            });

            selectedSeatCount.textContent =
                totalCapacity +
                (totalCapacity === 1
                    ? ' plaats geselecteerd'
                    : ' plaatsen geselecteerd');

            proceedButton.hidden = totalCapacity === 0;
        }

        function getSelectedSeatIds() {
            return Array.from(document.querySelectorAll('.seat--selected'))
                .map(seat => Number(seat.dataset.seatId));
        }

        /*
         * MOVE TO CONFIRMATION MODAL
         */

        proceedButton.addEventListener('click', function () {
            const selectedSeatIds = getSelectedSeatIds();

            if (selectedSeatIds.length === 0 || currentScreeningId === null) {
                return;
            }

            reservationScreeningId.value = currentScreeningId;

            reservationScreeningInfo.textContent = screeningInfo.textContent;

            reservationSelectedSeats.innerHTML = '';
            reservationSeatInputs.innerHTML = '';

            selectedSeatIds.forEach(seatId => {
                const seat = document.querySelector(
                    '.seat[data-seat-id="' + seatId + '"]'
                );

                if (!seat) {
                    return;
                }

                // Display the actual seat label, such as A5.
                const seatElement = document.createElement('span');

                seatElement.classList.add('reservation-seat');
                seatElement.textContent =
                    seat.dataset.seatRow + seat.dataset.seatColumn;

                reservationSelectedSeats.appendChild(seatElement);

                // Submit the database seat ID to Laravel.
                const input = document.createElement('input');

                input.type = 'hidden';
                input.name = 'seat_ids[]';
                input.value = seatId;

                reservationSeatInputs.appendChild(input);
            });

            closeSeatModal();

            reservationModal.classList.add('reservation-modal--active');
        });

        function closeReservationModal() {
            reservationModal.classList.remove('reservation-modal--active');
            seatModal.classList.add('seat-modal--active');
        }
    </script>

@endsection
