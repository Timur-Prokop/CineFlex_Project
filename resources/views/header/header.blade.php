<header class="header">
    <div class="header__container">

        <a href="#" class="header__logo">
            CINE<span>FLEX</span>
        </a>

        <nav class="header__nav">

            <a href="{{ route('home') }}"
               class="header__link {{ request()->routeIs('home') ? 'active' : '' }}">
                Home
            </a>

            <a href="{{ route('films') }}"
               class="header__link {{ request()->routeIs('films') ? 'active' : '' }}">
                Films
            </a>

            <a href="{{ route('planning.show') }}"
               class="header__link {{ request()->routeIs('planning.show') ? 'active' : '' }}">
                Rooster
            </a>

            @can('can-see-workers')
            <a href="{{ route('medewerkers.index') }}"
               class="header__link {{ request()->routeIs('medewerkers') ? 'active' : '' }}">
                Medewerkers
            </a>
            @endcan

            <a href="{{ route('contact') }}"
               class="header__link {{ request()->routeIs('contact') ? 'active' : '' }}">
                Contact
            </a>

        </nav>

        <div class="header__actions">
            <button class="header__search" aria-label="Zoeken">
                <svg viewBox="0 0 24 24" fill="none">
                    <circle cx="11" cy="11" r="7"></circle>
                    <path d="M16.5 16.5L21 21"></path>
                </svg>
            </button>

            @auth
                <div class="header__profile">

                    <button
                        type="button"
                        class="header__profile-button"
                        id="profileButton"
                        aria-expanded="false"
                        aria-haspopup="true"
                    >
            <span class="header__avatar">
                @if (auth()->user()->profile_picture)
                    <img
                        src="{{ asset('storage/' . auth()->user()->profile_picture) }}"
                        alt="Profielfoto"
                    >
                @else
                    {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
                @endif
            </span>

                        <svg class="header__profile-arrow" viewBox="0 0 24 24" fill="none">
                            <path d="M6 9L12 15L18 9"></path>
                        </svg>
                    </button>

                    <div class="header__dropdown" id="profileDropdown">

                        <div class="header__dropdown-user">
                            <strong>
                                {{ auth()->user()->first_name }}
                                {{ auth()->user()->prefix }}
                                {{ auth()->user()->surname }}
                            </strong>

                            <span>
                    {{ auth()->user()->email }}
                </span>
                        </div>

                        <div class="header__dropdown-divider"></div>

                        <a
                            href="{{ route('profile') }}"
                            class="header__dropdown-link"
                        >
                            <svg viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="8" r="4"></circle>
                                <path d="M4.5 21C5.2 16.9 8 15 12 15C16 15 18.8 16.9 19.5 21"></path>
                            </svg>

                            Profiel
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button
                                type="submit"
                                class="header__dropdown-link header__dropdown-logout"
                            >
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M10 17L15 12L10 7"></path>
                                    <path d="M15 12H3"></path>
                                    <path d="M21 3V21"></path>
                                </svg>

                                Uitloggen
                            </button>
                        </form>

                    </div>

                </div>
            @else
                <a href="{{ route('login') }}" class="header__login">
                    <svg viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="8" r="4"></circle>
                        <path d="M4.5 21C5.2 16.9 8 15 12 15C16 15 18.8 16.9 19.5 21"></path>
                    </svg>

                    <span>Inloggen</span>
                </a>
            @endauth
        </div>

    </div>
</header>
