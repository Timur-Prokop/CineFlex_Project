@extends('layouts.layout')

@section('content')

    @vite('resources/css/add_film.css')

    <div class="add-film-page">

        <div class="add-film-container">

            <div class="add-film-header">
                <div>
                    <span class="add-film-label">CINEFLEX ADMIN</span>
                    <h1>Nieuwe film toevoegen</h1>
                    <p>
                        Vul de informatie van de nieuwe film in.
                        De film wordt daarna toegevoegd aan de catalogus.
                    </p>
                </div>
            </div>

            @if ($errors->any())
                <div class="form-errors">
                    <div class="form-errors__title">
                        Er zijn fouten gevonden
                    </div>

                    <ul class="form-errors__list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form class="add-film-form" action="" method="POST">

                @csrf

                <div class="form-section">

                    <div class="form-section-title">
                        <span>01</span>

                        <div>
                            <h2>Algemene informatie</h2>
                            <p>Basisinformatie over de film.</p>
                        </div>
                    </div>


                    <div class="form-grid">

                        <div class="form-group form-group-wide">
                            <label for="title">
                                Titel
                                <span>*</span>
                            </label>

                            <input
                                type="text"
                                id="title"
                                name="title"
                                value="{{ old('title') }}"
                                placeholder="Bijvoorbeeld: Interstellar"
                                required
                            >

                            @error('title')
                            <span class="form-error">{{ $message }}</span>
                            @enderror
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
                                    value="{{ old('duration') }}"
                                    placeholder="120"
                                    min="1"
                                    required
                                >

                                <span>min</span>
                            </div>

                            @error('duration')
                            <span class="form-error">{{ $message }}</span>
                            @enderror
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
                                <option value="" disabled
                                    {{ old('fk_id_age_group') ? '' : 'selected' }}>
                                    Kies leeftijdsgroep
                                </option>

                                @foreach($age_groups as $age_group)
                                    <option
                                        value="{{ $age_group->id }}"
                                        {{ old('fk_id_age_group') == $age_group->id ? 'selected' : '' }}
                                    >
                                        {{ $age_group->age }}
                                    </option>
                                @endforeach
                            </select>

                            @error('fk_id_age_group')
                            <span class="form-error">{{ $message }}</span>
                            @enderror
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
                                    Kies één of meerdere waarschuwingen die bij deze film horen.
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
                                        {{ in_array($warning->id, old('warnings', [])) ? 'checked' : '' }}
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
                                                {{ ucfirst(str_replace('_', ' ', $warning->name)) }}
                                            </strong>
                                        </div>

                                        <div class="kijkwijzer-card__check">
                                            ✓
                                        </div>

                                    </div>

                                </label>

                            @endforeach

                        </div>

                        @error('warnings')
                        <span class="form-error">{{ $message }}</span>
                        @enderror

                    </div>

                </div>


                <div class="form-divider"></div>


                <div class="form-section">

                    <div class="form-section-title">
                        <span>02</span>

                        <div>
                            <h2>Afbeeldingen</h2>
                            <p>Voeg de afbeeldingen van de film toe.</p>
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
                                value="{{ old('pic_path') }}"
                                placeholder="https://..."
                            >

                            <small>
                                Verticale afbeelding voor de filmkaart.
                            </small>

                            @error('pic_path')
                            <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="page-pic-path">
                                Pagina afbeelding URL
                            </label>

                            <input
                                type="url"
                                id="page-pic-path"
                                name="page_pic_path"
                                value="{{ old('page_pic_path') }}"
                                placeholder="https://..."
                            >

                            <small>
                                Grote afbeelding voor de detailpagina.
                            </small>

                            @error('page_pic_path')
                            <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                </div>


                <div class="form-divider"></div>


                <div class="form-section">

                    <div class="form-section-title">
                        <span>03</span>

                        <div>
                            <h2>Beschrijving</h2>
                            <p>Vertel kort waar de film over gaat.</p>
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
                            placeholder="Schrijf hier een korte beschrijving van de film..."
                            required
                        >{{ old('description') }}</textarea>

                        @error('description')
                        <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>


                <div class="form-actions">

                    <a
                        href="{{route('films')}}"
                        class="btn-secondary"
                    >
                        Annuleren
                    </a>

                    <button
                        type="submit"
                        class="btn-primary"
                    >
                        <span class="btn-plus">+</span>
                        Film toevoegen
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection
