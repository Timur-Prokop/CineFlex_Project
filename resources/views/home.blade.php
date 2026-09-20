@extends('layouts.layout')

@section('content')

    @vite('resources/css/home.css')

    <main class="home-page">

        <section class="home-hero">

            <div class="home-container">

                <div class="hero-grid">

                    <div class="hero-content">

                        <div class="hero-label">
                            <span></span>
                            JOUW BIOSCOOP
                        </div>

                        <h1>
                            Films die je
                            <span>bijblijven.</span>
                        </h1>

                        <p class="hero-description">
                            Ontdek de nieuwste films, bekijk wat er draait
                            en reserveer eenvoudig jouw plek bij CINEFLEX.
                        </p>


                        <div class="hero-actions">

                            <a href="{{ route('films') }}" class="hero-btn-primary">
                                Bekijk films

                                <span>→</span>
                            </a>

                            <a href="#" class="hero-btn-secondary">
                                Bekijk trailers
                            </a>

                        </div>


                        <div class="hero-info">

                            <div>
                                <strong>Altijd</strong>
                                <span>de nieuwste films</span>
                            </div>

                            <div class="hero-info-line"></div>

                            <div>
                                <strong>Snel</strong>
                                <span>online reserveren</span>
                            </div>

                            <div class="hero-info-line"></div>

                            <div>
                                <strong>Comfort</strong>
                                <span>voor iedere bezoeker</span>
                            </div>

                        </div>

                    </div>



                    <div class="hero-visual">

                        <div class="hero-glow"></div>

                        <div class="hero-poster hero-poster--left">
                            <div class="poster-gradient"></div>

                            <div class="poster-content">
                                <span>CINEFLEX</span>
                                <strong>NEW STORIES</strong>
                            </div>
                        </div>


                        <div class="hero-poster hero-poster--main">

                            <div class="poster-light"></div>

                            <div class="cinema-screen">
                                <div class="cinema-play">
                                    ▶
                                </div>
                            </div>

                            <div class="poster-main-content">
                                <span>NU TE ZIEN</span>

                                <h3>
                                    Ontdek jouw
                                    volgende film
                                </h3>
                            </div>

                        </div>


                        <div class="hero-poster hero-poster--right">
                            <div class="poster-gradient-purple"></div>

                            <div class="poster-content">
                                <span>CINEMA</span>
                                <strong>BIG MOMENTS</strong>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </section>

        <section class="home-features">

            <div class="home-container">

                <div class="feature-grid">

                    <article class="feature-item">

                        <div class="feature-icon">
                            <svg
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.7"
                            >
                                <path d="M3 7h18v10H3z"/>
                                <path d="M7 7v10"/>
                                <path d="M17 7v10"/>
                            </svg>
                        </div>

                        <div>
                            <h3>Nieuwe films</h3>
                            <p>
                                Bekijk wat er momenteel draait.
                            </p>
                        </div>

                    </article>


                    <article class="feature-item">

                        <div class="feature-icon">
                            <svg
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.7"
                            >
                                <path d="M5 3h14v18H5z"/>
                                <path d="M8 7h8"/>
                                <path d="M8 11h8"/>
                            </svg>
                        </div>

                        <div>
                            <h3>Eenvoudig reserveren</h3>
                            <p>
                                Binnen een paar klikken geregeld.
                            </p>
                        </div>

                    </article>


                    <article class="feature-item">

                        <div class="feature-icon">
                            <svg
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.7"
                            >
                                <path d="M4 18v-5a8 8 0 0 1 16 0v5"/>
                                <path d="M2 18h20"/>
                            </svg>
                        </div>

                        <div>
                            <h3>Comfortabel kijken</h3>
                            <p>
                                Geniet van film zoals het hoort.
                            </p>
                        </div>

                    </article>

                </div>

            </div>

        </section>


        <section class="home-films">

            <div class="home-container">

                <div class="section-header">

                    <div>
                    <span class="section-label">
                        NU TE ZIEN
                    </span>

                        <h2>
                            Populaire films
                        </h2>
                    </div>


                    <a href="{{ route('films') }}" class="section-link">
                        Alle films
                        <span>→</span>
                    </a>

                </div>


                <div class="home-film-grid">

                    @foreach($films->take(4) as $film)

                        <article class="home-film-card">

                            <div class="home-film-image">

                                @if($film->pic_path)

                                    <img
                                        src="{{ $film->pic_path }}"
                                        alt="{{ $film->title }}"
                                    >

                                @endif


                                <div class="home-film-overlay">

                                    <a
                                        href="#"
                                        class="home-film-button"
                                    >
                                        Bekijk film
                                        <span>→</span>
                                    </a>

                                </div>

                            </div>


                            <div class="home-film-info">

                                <h3>
                                    {{ $film->title }}
                                </h3>

                                <span>
                                {{ $film->duration }} min
                            </span>

                            </div>

                        </article>

                    @endforeach

                </div>

            </div>

        </section>



        <section class="experience-section">

            <div class="home-container">

                <div class="experience-box">

                    <div class="experience-content">

                    <span class="section-label">
                        MEER DAN EEN FILM
                    </span>

                        <h2>
                            Even weg uit
                            de werkelijkheid.
                        </h2>

                        <p>
                            Grote verhalen, goed geluid en een zaal waarin
                            je even helemaal kunt verdwijnen.
                        </p>


                        <a href="{{ route('films') }}" class="experience-link">
                            Ontdek het programma
                            <span>→</span>
                        </a>

                    </div>


                    <div class="experience-visual">

                        <div class="screen">

                            <div class="screen-glow"></div>

                            <span>
                            CINEFLEX
                        </span>

                        </div>


                        <div class="seat-row seat-row-one">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>

                        <div class="seat-row seat-row-two">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>

                    </div>

                </div>

            </div>

        </section>



        <section class="home-cta">

            <div class="home-container">

                <div class="home-cta-inner">

                    <div>

                    <span>
                        VANAVOND NAAR DE FILM?
                    </span>

                        <h2>
                            Bekijk wat er draait.
                        </h2>

                    </div>


                    <a href="{{ route('films') }}">
                        Bekijk films
                        <span>→</span>
                    </a>

                </div>

            </div>

        </section>

    </main>

@endsection
