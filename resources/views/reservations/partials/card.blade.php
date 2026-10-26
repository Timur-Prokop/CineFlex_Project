@php
    $firstReservation = $reservations->first();
    $screening = $firstReservation->screening;
    $film = $screening->film;
    $auditory = $screening->auditory;
    $userSeatIds = $reservations->pluck('fk_seat')->values()->all();
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

                <h2>{{ $film->title }}</h2>
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

                <strong>{{ $screening->date_time->translatedFormat('D d M Y') }}</strong>
            </div>

            <div class="reservation-info">
                <span class="reservation-info__label">
                    Tijd
                </span>

                <strong>{{ $screening->date_time->format('H:i') }}</strong>
            </div>

            <div class="reservation-info">
                <span class="reservation-info__label">
                    Zaal
                </span>

                <strong>{{ $auditory->number }}</strong>
            </div>
        </div>

        <div class="reservation-card__seats">
            <div class="reservation-card__seats-header">
                <span>Plaatsen</span>

                <strong>
                    {{ $reservations->count() }} {{ $reservations->count() === 1 ? 'stoel' : 'stoelen' }}
                </strong>
            </div>

            <div class="reservation-seat-list">
                @foreach ($reservations->sortBy([ ['seat.row', 'asc'], ['seat.columm', 'asc'] ]) as $reservation)
                    <div class="reservation-seat">
                        <span class="reservation-seat__number">{{ $reservation->seat->row }}{{ $reservation->seat->columm }}</span>

                        @if ($reservation->seat->fk_type == 2)
                            <span class="reservation-seat__type">Duo</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div class="reservation-card__footer">
            <div>
                <span>Reserveringsnummer</span>
                <strong>#{{ $firstReservation->id }}</strong>
            </div>

            @if ($screening->date_time->isAfter(now()->addDay()))
                <button
                    type="button"
                    class="reservation-button__cancel"
                    onclick="openCancelSeatModal(
                        {{ $screening->id }},
                        {{ $auditory->id }},
                        '{{ $screening->date_time->format('H:i') }}',
                        '{{ $auditory->number }}',
                        '{{ addslashes($film->title) }}',
                        '{{ json_encode($userSeatIds) }}'
                    )"
                >
                    Annuleren
                </button>
            @endif
        </div>
    </div>
</article>
