@extends('layouts.layout')

@section('content')

    @vite(['resources/css/film.css'])

    <main class="film-detail-page">

        <section class="film-banner">
            <div class="film-banner__wrapper">
                @if ($film->page_pic_path)
                    <img
                        src="{{ $film->page_pic_path }}"
                        alt="{{ $film->title }}"
                        class="film-banner__img"
                    >
                @endif
                <div class="film-banner__overlay"></div>
            </div>
        </section>

        <div class="page-container film-container">

            <aside class="film-sidebar">
                <div class="film-sidebar__poster-wrapper">
                    @if ($film->pic_path)
                        <img
                            src="{{ $film->pic_path }}"
                            alt="{{ $film->title }}"
                            class="film-sidebar__poster"
                        >
                    @else
                        <div class="film-sidebar__no-image">
                            Geen afbeelding
                        </div>
                    @endif
                </div>

                <h2 class="film-sidebar__name">
                    {{ $film->title }}
                </h2>

                @if ($film->genres->isNotEmpty())
                    <div class="film-sidebar__genres">
                        {{ $film->genres->pluck('genre')->implode(' / ') }}
                    </div>
                @endif

                @can('can-access-worker-area')
                    <div class="film-sidebar__actions">
                        <a
                            href="{{ route('films.edit', $film->id) }}"
                            class="film-btn--edit"
                        >
                            Bewerken
                        </a>

                        <form
                            action="{{ route('films.delete', $film->id) }}"
                            method="POST"
                            class="film-delete-form"
                            id="delete-film-form"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="button"
                                class="film-btn--delete"
                                onclick="openDeleteModal()"
                            >
                                Verwijderen
                            </button>
                        </form>
                    </div>
                @endcan
            </aside>

            <section class="film-main">

                <header class="film-main__header">
                    <h1 class="film-main__title">
                        {{ $film->title }}
                    </h1>

                    <div class="film-main__kijkwijzers">
                        @if ($film->ageGroup && $film->ageGroup->pic_path)
                            <img
                                src="{{ $film->ageGroup->pic_path }}"
                                alt="{{ $film->ageGroup->age }}"
                                title="Leeftijd: {{ $film->ageGroup->age }}"
                                class="kijkwijzer-icon"
                            >
                        @endif

                        @if ($film->warnings->isNotEmpty())
                            @foreach ($film->warnings as $warning)
                                <img
                                    src="{{ $warning->pic_path }}"
                                    alt="{{ $warning->name }}"
                                    title="{{ $warning->name }}"
                                    class="kijkwijzer-icon"
                                >
                            @endforeach
                        @endif
                    </div>
                </header>

                <hr class="film-main__divider">

                <div class="film-main__description">
                    <p>{{ $film->description }}</p>
                </div>

                <section class="film-screenings" id="screenings">
                    <div class="film-screenings__header">
                        <span class="section-label">VOORSTELLINGEN</span>
                        <h2>Kies een datum &amp; tijd</h2>
                    </div>

                    @if (!empty($screeningsByDate) && count($screeningsByDate) > 0)
                        <div class="film-screenings__dates">
                            @foreach ($screeningsByDate as $date => $sessions)
                                @php
                                    $carbonDate = \Carbon\Carbon::parse($date);
                                @endphp

                                <button
                                    type="button"
                                    class="film-date-tab {{ $loop->first ? 'film-date-tab--active' : '' }}"
                                    onclick="switchDatePanel('date-{{ $loop->index }}', this)"
                                >
                                    <span class="film-date-tab__label">
                                        @if ($carbonDate->isToday())
                                            Vandaag
                                        @elseif ($carbonDate->isTomorrow())
                                            Morgen
                                        @else
                                            {{ $carbonDate->translatedFormat('D d M') }}
                                        @endif
                                    </span>
                                    <span class="film-date-tab__date">
                                        {{ $carbonDate->format('d-m-Y') }}
                                    </span>
                                </button>
                            @endforeach
                        </div>

                        <div class="film-screenings__panels">
                            @foreach ($screeningsByDate as $date => $sessions)
                                <div
                                    class="film-date-panel {{ $loop->first ? 'film-date-panel--active' : '' }}"
                                    id="date-{{ $loop->index }}"
                                >
                                    <div class="film-screenings__list">
                                        @foreach ($sessions as $screening)
                                            <button
                                                type="button"
                                                class="screening-item"
                                                onclick="openSeatModal(
                                                    {{ $screening->id }},
                                                    {{ $screening->fk_auditory }},
                                                    '{{ $screening->date_time->format('H:i') }}',
                                                    '{{ $screening->auditory->number }}'
                                                )"
                                            >
                                                <span class="screening-item__time">
                                                    {{ $screening->date_time->format('H:i') }}
                                                </span>

                                                <span class="screening-item__details">
                                                    <span class="screening-item__auditory">
                                                        Zaal {{ $screening->auditory->number }}
                                                    </span>
                                                    <span class="screening-item__duration">
                                                        {{ $film->duration }} min
                                                    </span>
                                                </span>

                                                <span class="screening-item__action">
                                                    Selecteer stoel →
                                                </span>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="film-screenings__empty">
                            <p>Er zijn momenteel geen voorstellingen gepland voor deze film.</p>
                        </div>
                    @endif
                </section>

            </section>

        </div>

    </main>

    {{-- Delete confirmation modal --}}
    <div class="delete-modal" id="delete-modal">
        <div class="delete-modal__overlay" onclick="closeDeleteModal()"></div>
        <div class="delete-modal__content">
            <h2>Film verwijderen?</h2>
            <p>
                Weet je zeker dat je <strong>{{ $film->title }}</strong> wilt verwijderen?
            </p>

            <div class="delete-modal__actions">
                <button type="button" class="delete-modal__cancel" onclick="closeDeleteModal()">
                    Annuleren
                </button>
                <button type="button" class="delete-modal__confirm" onclick="confirmDelete()">
                    Ja, verwijderen
                </button>
            </div>
        </div>
    </div>

    {{-- Seat reservation modal --}}
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

    <script>
        const reservations = @json($reservations->map(function ($reservation) {
            return [
                'seat' => $reservation->fk_seat,
                'screening' => $reservation->fk_screening,
            ];
        }));

        const seatModal = document.getElementById('seat-modal');
        const screeningInfo = document.getElementById('seat-screening-info');
        const selectedSeatCount = document.getElementById('selected-seat-count');
        const proceedButton = document.getElementById('proceedButton');

        let currentScreeningId = null;

        function switchDatePanel(panelId, tabButton) {
            document.querySelectorAll('.film-date-panel').forEach(p => p.classList.remove('film-date-panel--active'));
            document.querySelectorAll('.film-date-tab').forEach(t => t.classList.remove('film-date-tab--active'));

            document.getElementById(panelId).classList.add('film-date-panel--active');
            tabButton.classList.add('film-date-tab--active');
        }

        function openDeleteModal() {
            document.getElementById('delete-modal').classList.add('delete-modal--active');
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.remove('delete-modal--active');
        }

        function confirmDelete() {
            const form = document.getElementById('delete-film-form');
            if (form) form.requestSubmit();
        }

        function openSeatModal(screeningId, auditoryId, time, auditoryNumber) {
            currentScreeningId = screeningId;
            seatModal.classList.add('seat-modal--active');
            screeningInfo.textContent = 'Zaal ' + auditoryNumber + ' · ' + time;

            document.querySelectorAll('.auditory-seats').forEach(a => a.style.display = 'none');

            const selectedAuditory = document.querySelector('.auditory-seats[data-auditory="' + auditoryId + '"]');
            if (selectedAuditory) {
                selectedAuditory.style.display = 'block';
            }

            document.querySelectorAll('.seat').forEach(seat => {
                seat.classList.remove('seat--selected', 'seat--occupied');
                seat.disabled = false;
            });

            reservations.forEach(reservation => {
                if (Number(reservation.screening) === Number(screeningId)) {
                    const seat = document.querySelector('.seat[data-seat-id="' + reservation.seat + '"]');
                    if (seat) {
                        seat.classList.add('seat--occupied');
                        seat.disabled = true;
                    }
                }
            });

            updateSelectedSeats();
        }

        function closeSeatModal() {
            seatModal.classList.remove('seat-modal--active');
        }

        document.querySelectorAll('.seat').forEach(seat => {
            seat.addEventListener('click', function () {
                if (this.classList.contains('seat--occupied')) return;
                this.classList.toggle('seat--selected');
                updateSelectedSeats();
            });
        });

        function updateSelectedSeats() {
            const selectedSeats = document.querySelectorAll('.seat--selected');
            let totalCapacity = 0;

            selectedSeats.forEach(seat => {
                const type = Number(seat.getAttribute('data-seat-type'));
                totalCapacity += (type === 2 ? 2 : 1);
            });

            selectedSeatCount.textContent = totalCapacity + (totalCapacity === 1 ? ' plaats geselecteerd' : ' plaatsen geselecteerd');

            proceedButton.hidden = totalCapacity < 1;
        }

    </script>

@endsection
