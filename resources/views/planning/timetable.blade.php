@extends('layouts.layout')

@section('content')

    @vite('resources/css/timetable.css')

    <main class="schedule-page">

        <div class="schedule-container">

            <section class="schedule-header">

                <div class="planning-actions">

                    <button
                        type="button"
                        id="openPlanningButton"
                        class="new-planning-button"
                    >
                        <span>+</span>
                        Nieuwe voorstelling
                    </button>

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



                                    <div class="schedule-film__poster">


                                        @if($film->pic_path)

                                            <img
                                                src="{{ $film->pic_path }}"
                                                alt="{{ $film->title }}"
                                            >

                                        @else

                                            <div class="schedule-film__placeholder">
                                                CINEFLEX
                                            </div>

                                        @endif

                                    </div>


                                    <div class="schedule-film__info">

                                        <div class="schedule-film__main">

                                            <span class="schedule-film__label">
                                                NU TE ZIEN
                                            </span>


                                            <h2>
                                                {{ $film->title }}
                                            </h2>


                                            <div class="schedule-film__meta">


                                                <div class="meta-item">

                                                    <svg
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="1.8"
                                                    >
                                                        <circle
                                                            cx="12"
                                                            cy="12"
                                                            r="9"
                                                        />

                                                        <path
                                                            d="M12 7v5l3 2"
                                                        />
                                                    </svg>


                                                    <span>
                                                        {{ $film->duration }} min
                                                    </span>

                                                </div>



                                                <div class="meta-item">

                                                    <svg
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="1.8"
                                                    >
                                                        <path
                                                            d="M4 19v-6a8 8 0 0 1 16 0v6"
                                                        />

                                                        <path
                                                            d="M2 19h20"
                                                        />
                                                    </svg>


                                                    <span>
                                                        Zaal {{ $film->number }}
                                                    </span>

                                                </div>


                                                @if(isset($film->seats_quantity))

                                                    <div class="meta-item">

                                                        <svg
                                                            viewBox="0 0 24 24"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            stroke-width="1.8"
                                                        >
                                                            <path
                                                                d="M4 18v-2a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v2"
                                                            />

                                                            <circle
                                                                cx="12"
                                                                cy="7"
                                                                r="3"
                                                            />
                                                        </svg>


                                                        <span>
                                                            {{ $film->seats_quantity }}
                                                            plaatsen
                                                        </span>

                                                    </div>

                                                @endif

                                            </div>

                                        </div>

                                        <div class="schedule-film__time">

                                            <span>
                                                Start
                                            </span>


                                            <strong>
                                                {{
                                                    \Carbon\Carbon::parse(
                                                        $film->date_time
                                                    )->format('H:i')
                                                }}
                                            </strong>


                                            <small>
                                                Eindigt ±

                                                {{
                                                    \Carbon\Carbon::parse(
                                                        $film->date_time
                                                    )
                                                    ->addMinutes(
                                                        $film->duration
                                                    )
                                                    ->format('H:i')
                                                }}
                                            </small>

                                        </div>

                                    </div>


                                    <div class="schedule-film__action">

                                        <button
                                            type="button"
                                            class="schedule-reserve-button"
                                            data-url="{{ route('show.film', $film->id) }}"
                                        >
                                            Film bekijken
                                            <span>→</span>
                                        </button>

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


    {{-- =====================================================
        JAVASCRIPT
    ====================================================== --}}

    <script>

        const planningEditor =
            document.getElementById('planningEditor');

        const openPlanningButton =
            document.getElementById('openPlanningButton');

        const closePlanningButton =
            document.getElementById('closePlanningButton');

        const cancelPlanningButton =
            document.getElementById('cancelPlanningButton');


        openPlanningButton.addEventListener('click', function () {

            planningEditor.classList.add('is-open');

            planningEditor.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

        });


        closePlanningButton.addEventListener('click', function () {

            planningEditor.classList.remove('is-open');

        });


        cancelPlanningButton.addEventListener('click', function () {

            planningEditor.classList.remove('is-open');

        });


        const navigationButtons =
            document.querySelectorAll('[data-url]');


        navigationButtons.forEach(button => {

            button.addEventListener('click', function () {

                window.location.href = this.dataset.url;

            });

        });

    </script>

@endsection
