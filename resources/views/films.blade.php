@extends('layouts.layout')

@section('content')
@vite('/resources/css/films.css')
    <main class="films-page">
        <section class="films-hero">
            <div class="page-container">
                <div class="films-hero__content">
                    <span class="section-label">CINEFLEX FILMS</span>

                    <h1>
                        Ontdek jouw volgende
                        <span>favoriete film</span>
                    </h1>

                    <p>
                        Bekijk alle films die momenteel bij CINEFLEX beschikbaar zijn.
                        Van actie en avontuur tot drama en familie.
                    </p>
                </div>
            </div>
        </section>


        <section class="films-section">
            <div class="page-container">
                <div class="films-section__header">
                    <div>
                        <span class="section-label">NU TE ZIEN</span>
                        <h2>Alle films</h2>
                    </div>

                    <div class="films-tools">

                        <div class="film-search">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="20"
                                height="20"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg>

                            <input
                                type="text"
                                id="filmSearch"
                                placeholder="Zoek een film..."
                            >
                        </div>

                        <select class="film-filter">
                            <option value="">Alle films</option>
                            <option value="short">Tot 90 min</option>
                            <option value="medium">90 - 120 min</option>
                            <option value="long">120+ min</option>
                        </select>
                    </div>
                </div>


                <div class="films-grid">

                    @foreach ($films as $film)

                        <article
                            class="film-card"
                            data-title="{{ strtolower($film->title) }}">

                            <a href="#" class="film-card__poster">
                                @if ($film->pic_path)
                                    <img
                                        src="{{ asset($film->pic_path) }}"
                                        alt="{{ $film->title }}">
                                @else
                                    <div class="film-card__no-image">
                                        Geen afbeelding
                                    </div>
                                @endif

                                <div class="film-card__overlay">
                                    <div class="film-card__play">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="22"
                                            height="22"
                                            viewBox="0 0 24 24"
                                            fill="currentColor"
                                        >
                                            <path d="M4 5a2 2 0 0 0-2 2v2.5a2.5 2.5 0 0 1 0 5V17a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2.5a2.5 2.5 0 0 1 0-5V7a2 2 0 0 0-2-2H4zm9 2v2h-2V7h2zm0 4v2h-2v-2h2zm0 4v2h-2v-2h2z"></path>
                                        </svg>
                                    </div>

                                    <span>Reserveren</span>
                                </div>

                                <div class="film-card__duration">
                                    {{ $film->duration }} min
                                </div>
                            </a>


                            <div class="film-card__content">
                                <div class="film-card__top">
                                    <h3>{{ $film->title }}</h3>

                                    <button
                                        class="film-card__favorite"
                                        type="button"
                                        aria-label="Voeg toe aan favorieten"
                                    >
                                        ♡
                                    </button>
                                </div>

                                @if ($film->description)
                                    <p>
                                        {{ Str::limit($film->description, 100) }}
                                    </p>
                                @endif

                                <div class="film-card__bottom">

                                <span class="film-card__age">
                                    {{ $film->fk_id_age_group }}+
                                </span>

                                    <a href="#" class="film-card__link">
                                        Meer info

                                        <span>→</span>
                                    </a>

                                </div>
                            </div>
                        </article>

                    @endforeach

                </div>


                @if ($films->isEmpty())
                    <div class="films-empty">
                        <h3>Geen films gevonden</h3>
                        <p>Er zijn momenteel geen films beschikbaar.</p>
                    </div>
                @endif

            </div>
        </section>


    </main>


    <script>
        const searchInput = document.getElementById('filmSearch');
        const filmCards = document.querySelectorAll('.film-card');

        searchInput.addEventListener('input', function () {

            const searchValue = this.value.toLowerCase();

            filmCards.forEach(card => {

                const title = card.dataset.title;

                if (title.includes(searchValue)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }

            });

        });
    </script>

@endsection
