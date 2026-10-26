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

                    <p>
                        <strong>( ! ) Let op! Reserveringen kunnen geannuleerd worden alleen maar een dag van tevoren.</strong>
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


{{-- Cancellation Seat Modal --}}
<div class="seat-modal" id="cancel-seat-modal">
    <div class="seat-modal__overlay" onclick="closeCancelSeatModal()"></div>

    <div class="seat-modal__content">
        <button type="button" class="seat-modal__close" onclick="closeCancelSeatModal()">×</button>

        <div class="seat-modal__header">
            <span style="color: #ff6972;">CINEFLEX ANNULERING</span>
            <h2>Selecteer te annuleren plaatsen</h2>
            <p id="cancel-screening-info"></p>
        </div>

        <div class="cinema-screen">SCHERM</div>

        <div class="seat-modal__seats" id="cancel-seat-container">
            @foreach($seats->groupBy('fk_auditory') as $auditoryId => $auditorySeats)
                <div class="auditory-seats" data-auditory="{{ $auditoryId }}">
                    @foreach($auditorySeats->groupBy('row') as $row => $rowSeats)
                        <div class="seat-row">
                            <span class="seat-row__name">{{ $row }}</span>

                            @foreach($rowSeats as $seat)
                                @php
                                    $hasAisleAfter = false;
                                    if ($auditoryId == 1) {
                                        if ($row === 'A' && in_array($seat->columm, [2, 9])) {
                                            $hasAisleAfter = true;
                                        } elseif ($row !== 'A' && in_array($seat->columm, [1, 9])) {
                                            $hasAisleAfter = true;
                                        }
                                    } elseif ($auditoryId == 2) {
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
                                    title="Rij {{ $row }}, Stoel {{ $seat->columm }}"
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
                <span class="seat-example" style="background: var(--cineflex-green); border-color: var(--cineflex-green);"></span>
                Jouw plaatsen
            </div>
            <div>
                <span class="seat-example" style="background: rgba(255, 75, 85, 0.3); border-color: #ff6972;"></span>
                Geselecteerd voor annulering
            </div>
            <div>
                <span class="seat-example seat-example--occupied"></span>
                Niet beschikbaar / Bezette stoel
            </div>
        </div>

        <div class="seat-modal__footer">
            <span id="cancel-selected-seat-count">0 plaatsen geselecteerd om te annuleren</span>
            <button hidden type="button" class="reservation-button__cancel" id="cancelProceedButton">
                Verder naar bevestiging
            </button>
        </div>
    </div>
</div>

{{-- Cancellation Confirmation Modal --}}
<div class="reservation-modal" id="cancel-confirm-modal">
    <div class="reservation-modal__overlay" onclick="closeCancelConfirmModal()"></div>

    <div class="reservation-modal__content">
        <button type="button" class="reservation-modal__close" onclick="closeCancelConfirmModal()">×</button>

        <div class="reservation-modal__header">
            <span style="color: #ff6972;">CINEFLEX ANNULERING</span>
            <h2>Annulering bevestigen</h2>
            <p>Weet je zeker dat je de geselecteerde plaatsen wilt annuleren?</p>
        </div>

        <div class="reservation-modal__details">
            <div class="reservation-modal__detail">
                <span>Voorstelling</span>
                <strong id="confirm-cancel-screening-info"></strong>
            </div>

            <div class="reservation-modal__detail">
                <span>Te annuleren plaatsen</span>
                <div class="reservation-modal__seats" id="confirm-cancel-seats"></div>
            </div>
        </div>

        <form method="POST" action="{{ route('reservations.destroy') }}" id="cancel-reservation-form">
            @csrf
            @method('DELETE')

            <input type="hidden" name="screening_id" id="cancel-screening-id">
            <div id="cancel-seat-inputs"></div>

            <div class="reservation-modal__actions">
                <button type="button" class="reservation-modal__cancel" onclick="closeCancelConfirmModal()">
                    Terug
                </button>
                <button type="submit" class="reservation-button__cancel" style="width: auto; flex: 1;">
                    Bevestig annulering
                </button>
            </div>
        </form>
    </div>
</div>

@php
    $formattedReservations = ($allReservations ?? $reservations ?? collect())->map(function ($r) {
        return [
            'seat' => $r->fk_seat,
            'screening' => $r->fk_screening,
            'user_id' => $r->fk_user ?? null,
            'reservation_id' => $r->id,
        ];
    })->values();
@endphp

<script>
    // All active reservations in system (to mark non-user seats as occupied)
    const allReservations = @json($formattedReservations);

    const cancelSeatModal = document.getElementById('cancel-seat-modal');
    const cancelScreeningInfo = document.getElementById('cancel-screening-info');
    const cancelSelectedSeatCount = document.getElementById('cancel-selected-seat-count');
    const cancelProceedButton = document.getElementById('cancelProceedButton');

    const cancelConfirmModal = document.getElementById('cancel-confirm-modal');
    const confirmCancelScreeningInfo = document.getElementById('confirm-cancel-screening-info');
    const confirmCancelScreeningId = document.getElementById('cancel-screening-id');
    const confirmCancelSeats = document.getElementById('confirm-cancel-seats');
    const cancelSeatInputs = document.getElementById('cancel-seat-inputs');

    let currentCancelScreeningId = null;
    let currentUserSeatIds = [];

    function openCancelSeatModal(screeningId, auditoryId, time, auditoryNumber, title, userSeatIdsJson) {
        currentCancelScreeningId = Number(screeningId);
        currentUserSeatIds = Array.isArray(userSeatIdsJson) ? userSeatIdsJson.map(Number) : JSON.parse(userSeatIdsJson).map(Number);

        cancelSeatModal.classList.add('seat-modal--active');
        cancelScreeningInfo.textContent = 'Zaal ' + auditoryNumber + ' · ' + time + ' · ' + title;

        // Show auditorium
        document.querySelectorAll('#cancel-seat-container .auditory-seats').forEach(a => a.style.display = 'none');
        const selectedAuditory = document.querySelector('#cancel-seat-container .auditory-seats[data-auditory="' + auditoryId + '"]');
        if (selectedAuditory) selectedAuditory.style.display = 'block';

        // Reset seats state
        document.querySelectorAll('#cancel-seat-container .seat').forEach(seat => {
            const seatId = Number(seat.dataset.seatId);

            seat.classList.remove('seat--selected', 'seat--occupied', 'seat--user-reserved');
            seat.style.background = '';
            seat.style.borderColor = '';

            if (currentUserSeatIds.includes(seatId)) {
                // Highlight user's seats as available to cancel
                seat.disabled = false;
                seat.classList.add('seat--user-reserved');
                seat.style.background = 'var(--cineflex-green)';
                seat.style.borderColor = 'var(--cineflex-green)';
                seat.style.color = '#041008';
            } else {
                // Disable all other seats
                seat.classList.add('seat--occupied');
                seat.disabled = true;
            }
        });

        updateCancelSeatsCount();
    }

    function closeCancelSeatModal() {
        cancelSeatModal.classList.remove('seat-modal--active');
    }

    // Handle clicking user seats to mark for cancellation
    document.querySelectorAll('#cancel-seat-container .seat').forEach(seat => {
        seat.addEventListener('click', function () {
            const seatId = Number(this.dataset.seatId);
            if (!currentUserSeatIds.includes(seatId)) return;

            this.classList.toggle('seat--selected');

            if (this.classList.contains('seat--selected')) {
                this.style.background = 'rgba(255, 75, 85, 0.3)';
                this.style.borderColor = '#ff6972';
                this.style.color = '#ffffff';
            } else {
                this.style.background = 'var(--cineflex-green)';
                this.style.borderColor = 'var(--cineflex-green)';
                this.style.color = '#041008';
            }

            updateCancelSeatsCount();
        });
    });

    function updateCancelSeatsCount() {
        const selectedSeats = document.querySelectorAll('#cancel-seat-container .seat--selected');
        const count = selectedSeats.length;

        cancelSelectedSeatCount.textContent = count + (count === 1 ? ' plaats geselecteerd om te annuleren' : ' plaatsen geselecteerd om te annuleren');
        cancelProceedButton.hidden = count === 0;
    }

    cancelProceedButton.addEventListener('click', function () {
        const selectedSeats = document.querySelectorAll('#cancel-seat-container .seat--selected');
        if (selectedSeats.length === 0) return;

        confirmCancelScreeningId.value = currentCancelScreeningId;
        confirmCancelScreeningInfo.textContent = cancelScreeningInfo.textContent;

        confirmCancelSeats.innerHTML = '';
        cancelSeatInputs.innerHTML = '';

        selectedSeats.forEach(seat => {
            const seatId = seat.dataset.seatId;
            const rowName = seat.dataset.seatRow;
            const columnName = seat.dataset.seatColumn;

            const tag = document.createElement('span');
            tag.classList.add('reservation-seat');
            tag.style.borderColor = '#ff6972';
            tag.style.color = '#ff6972';
            tag.style.background = 'rgba(255, 75, 85, 0.1)';
            tag.textContent = rowName + columnName;
            confirmCancelSeats.appendChild(tag);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'seat_ids[]';
            input.value = seatId;
            cancelSeatInputs.appendChild(input);
        });

        closeCancelSeatModal();
        cancelConfirmModal.classList.add('reservation-modal--active');
    });

    function closeCancelConfirmModal() {
        cancelConfirmModal.classList.remove('reservation-modal--active');
        cancelSeatModal.classList.add('seat-modal--active');
    }
</script>
