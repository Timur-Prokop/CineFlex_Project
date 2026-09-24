@extends('layouts.layout')

@section('content')

    @vite('resources/css/add_film.css', 'resources/js/films.js')

    <div class="add-film-page">

        <div class="add-film-container">

            <div class="add-film-header">
                <div>

                <span class="add-film-label">
                    CINEFLEX ADMIN
                </span>

                    <h1>Film bewerken</h1>

                    <p>
                        Pas de informatie van
                        <strong>{{ $film->title }}</strong>
                        aan.
                    </p>

                </div>
            </div>


            <form
                class="add-film-form"
                action="{{ route('films.update', $film->id) }}"
                method="POST"
            >

                @csrf



                <div class="form-section">

                    <div class="form-section-title">

                        <span>01</span>

                        <div>
                            <h2>Algemene informatie</h2>
                            <p>Bewerk de basisinformatie van de film.</p>
                        </div>

                    </div>


                    <div class="form-grid">


                        {{-- TITEL --}}

                        <div class="form-group form-group-wide">

                            <label for="title">
                                Titel
                                <span>*</span>
                            </label>

                            <input
                                type="text"
                                id="title"
                                name="title"
                                value="{{ old('title', $film->title) }}"
                                required
                            >

                        </div>



                        <div class="form-group">

                            <label for="duration">
                                Duur
                                <span>*</span>
                            </label>

                            <div class="input-with-text">

                                <input
                                    type="number"
                                    id="duration"
                                    name="duration"
                                    value="{{ old('duration', $film->duration) }}"
                                    min="25"
                                    max="400"
                                    required
                                >

                                <span>min</span>

                            </div>

                        </div>



                        <div class="form-group">

                            <label for="age-group">
                                Leeftijdsgroep
                                <span>*</span>
                            </label>

                            <select
                                id="age-group"
                                name="fk_id_age_group"
                                required
                            >

                                @foreach($age_groups as $age_group)

                                    <option
                                        value="{{ $age_group->id }}"
                                        @selected(
                                            old(
                                                'fk_id_age_group',
                                                $film->fk_id_age_group
                                            ) == $age_group->id
                                        )
                                    >
                                        {{ $age_group->age }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>



                    <div class="form-group kijkwijzer-group">

                        <div class="kijkwijzer-header">

                            <div>

                                <label>
                                    Kijkwijzers
                                    <span>*</span>
                                </label>

                                <p>
                                    Kies één of meerdere waarschuwingen
                                    die bij deze film horen.
                                </p>

                            </div>

                        </div>


                        <div class="kijkwijzer-grid">

                            @foreach($warnings as $warning)

                                <label class="kijkwijzer-card">

                                    <input
                                        type="checkbox"
                                        name="warnings[]"
                                        value="{{ $warning->id }}"

                                        @checked(
                                            $filmWarnings->contains($warning->id)
                                        )
                                    >


                                    <div class="kijkwijzer-card__content">

                                        <div class="kijkwijzer-card__icon">

                                            @if($warning->pic_path)

                                                <img
                                                    src="{{ $warning->pic_path }}"
                                                    alt="{{ $warning->name }}"
                                                >

                                            @endif

                                        </div>


                                        <div class="kijkwijzer-card__text">

                                            <strong>
                                                {{
                                                    ucfirst(
                                                        str_replace(
                                                            '_',
                                                            ' ',
                                                            $warning->name
                                                        )
                                                    )
                                                }}
                                            </strong>

                                        </div>


                                        <div class="kijkwijzer-card__check">
                                            ✓
                                        </div>

                                    </div>

                                </label>

                            @endforeach

                        </div>

                    </div>

                </div>


                <div class="form-divider"></div>



                <div class="form-section">

                    <div class="form-section-title">

                        <span>02</span>

                        <div>
                            <h2>Afbeeldingen</h2>
                            <p>Pas de afbeeldingen van de film aan.</p>
                        </div>

                    </div>


                    <div class="form-grid">

                        <div class="form-group">

                            <label for="pic-path">
                                Poster URL
                            </label>

                            <input
                                type="url"
                                id="pic-path"
                                name="pic_path"
                                value="{{ old('pic_path', $film->pic_path) }}"
                                required
                            >

                            <small>
                                Verticale afbeelding voor de filmkaart.
                            </small>

                        </div>


                        <div class="form-group">

                            <label for="page-pic-path">
                                Pagina afbeelding URL
                            </label>

                            <input
                                type="url"
                                id="page-pic-path"
                                name="page_pic_path"
                                value="{{ old('page_pic_path', $film->page_pic_path) }}"
                                required
                            >

                            <small>
                                Grote afbeelding voor de detailpagina.
                            </small>

                        </div>

                    </div>

                </div>


                <div class="form-divider"></div>



                <div class="form-section">

                    <div class="form-section-title">

                        <span>03</span>

                        <div>
                            <h2>Beschrijving</h2>
                            <p>Bewerk de beschrijving van de film.</p>
                        </div>

                    </div>


                    <div class="form-group">

                        <label for="description">
                            Beschrijving
                            <span>*</span>
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="7"
                            required
                        >{{ old('description', $film->description) }}</textarea>

                    </div>

                </div>


                <div class="form-actions">

                    <button
                        type="button"
                        class="btn-secondary"
                    >
                        <a href="/films">Annuleren</a>
                    </button>


                    <button
                        type="submit"
                        class="btn-primary"
                    >
                        Wijzigingen opslaan
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection
