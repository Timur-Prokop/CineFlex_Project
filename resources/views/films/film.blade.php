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


                <a
                    href="#screenings"
                    class="film-btn film-btn--reserve"
                >
                    Reserveren
                </a>

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
                    <p>
                        {{ $film->description }}
                    </p>
                </div>


                <section
                    class="film-screenings"
                    id="screenings"
                >

                    <div class="film-screenings__header">

                        <span class="section-label">
                            VOORSTELLINGEN
                        </span>

                        <h2>
                            Kies een datum &amp; tijd
                        </h2>

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

                                            <a
                                                href="#"
                                                class="screening-item"
                                            >

                                                <div class="screening-item__time">
                                                    {{ $screening->date_time->format('H:i') }}
                                                </div>


                                                <div class="screening-item__details">

                                                    <span class="screening-item__auditory">
                                                        Zaal {{ $screening->auditory->number }}
                                                    </span>

                                                    <span class="screening-item__duration">
                                                        {{ $film->duration }} min
                                                    </span>

                                                </div>


                                                <div class="screening-item__action">
                                                    Selecteer stoel →
                                                </div>

                                            </a>

                                        @endforeach

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="film-screenings__empty">

                            <p>
                                Er zijn momenteel geen voorstellingen gepland voor deze film.
                            </p>

                        </div>

                    @endif

                </section>

            </section>

        </div>

    </main>


    <script>
        function switchDatePanel(panelId, tabButton) {
            document.querySelectorAll('.film-date-panel').forEach(function (panel) {
                panel.classList.remove('film-date-panel--active');
            });

            document.querySelectorAll('.film-date-tab').forEach(function (tab) {
                tab.classList.remove('film-date-tab--active');
            });

            document.getElementById(panelId).classList.add('film-date-panel--active');
            tabButton.classList.add('film-date-tab--active');
        }
    </script>

@endsection
