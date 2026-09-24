@extends('layouts.layout')

@section('content')
@vite(['/resources/css/films.css', '/resources/js/films.js'])
    <main class="films-page">
{{--        <section class="films-hero">--}}
{{--            <div class="page-container">--}}
{{--                <div class="films-hero__content">--}}
{{--                    <span class="section-label">CINEFLEX FILMS</span>--}}

{{--                    <h1>--}}
{{--                        Ontdek jouw volgende--}}
{{--                        <span>favoriete film</span>--}}
{{--                    </h1>--}}

{{--                    <p>--}}
{{--                        Bekijk alle films die momenteel bij CINEFLEX beschikbaar zijn.--}}
{{--                        Van actie en avontuur tot drama en familie.--}}
{{--                    </p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </section>--}}


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

                        <select class="film-filter" id="film-filter">
                            <option value="">Alle films</option>
                            <option value="small">Tot 90 min</option>
                            <option value="medium">90 - 120 min</option>
                            <option value="huge">120+ min</option>
                        </select>
                    </div>
                </div>


                <div class="films-grid">

                    @foreach ($films as $film)

                        <article
                            class="film-card"
                            data-title="{{ strtolower($film->title) }}"
                            data-duration=" {{ $film->duration }} ">
                            <a href="{{route('show.film', $film->title)}}" class="film-card__poster">
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
                                    @can('can-access-client-area')
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
                                    @endcan
                                </div>

                                <div class="film-card__duration">
                                    {{ $film->duration }} min
                                </div>
                            </a>


                            <div class="film-card__content">
                                <div class="film-card__top">
                                    <h3>{{ $film->title }}</h3>

                                    <img class="group_age_pic" src=" {{ $film->age_group_pic }}" alt="" title="{{ $film->age_group }} jaar">

                                </div>
                                @can('can-access-worker-area')
                                    <button
                                        class="film-edit-button"
                                        data-url = "{{ route('films.edit', $film->id) }}">
                                        Wijzigen
                                    </button>

                                    <form
                                        action="{{ route('films.delete', $film->id) }}"
                                        method="POST"
                                        class="film-delete-form"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="film-delete-button"
                                        >
                                            Verwijderen
                                        </button>
                                    </form>
                                @endcan

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

    </script>

@endsection
