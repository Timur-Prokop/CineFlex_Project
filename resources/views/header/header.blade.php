<header class="header">
    <div class="header__container">

        <a href="{{ route('home') }}" class="header__logo">
            CINE<span>FLEX</span>
        </a>

        <nav class="header__nav" id="mobileNav">
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

            @can('can-access-manager-area')
                <a href="{{ route('medewerkers.index') }}"
                   class="header__link {{ request()->routeIs('medewerkers*') ? 'active' : '' }}">
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
                                <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profielfoto">
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
                            <span>{{ auth()->user()->email }}</span>
                        </div>

                        <div class="header__dropdown-divider"></div>

                        <a href="{{ route('profile') }}" class="header__dropdown-link">
                            <svg viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="8" r="4"></circle>
                                <path d="M4.5 21C5.2 16.9 8 15 12 15C16 15 18.8 16.9 19.5 21"></path>
                            </svg>
                            Profiel
                        </a>

                        <a href="{{ route('reservations.index') }}" class="header__dropdown-link">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M3 9C3 7.9 3.9 7 5 7H19C20.1 7 21 7.9 21 9V10.5C19.9 10.5 19 11.4 19 12.5C19 13.6 19.9 14.5 21 14.5V16C21 17.1 20.1 18 19 18H5C3.9 18 3 17.1 3 16V14.5C4.1 14.5 5 13.6 5 12.5C5 11.4 4.1 10.5 3 10.5V9Z"></path>
                                <path d="M12 9.5V14.5"></path>
                            </svg>
                            Mijn reserveringen
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="header__dropdown-link header__dropdown-logout">
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

            <button class="header__hamburger" id="mobileMenuBtn" aria-label="Menu">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

    </div>
</header>
