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

            <a href="{{ route('catalog') }}"
               class="header__link {{ request()->routeIs('catalog') ? 'active' : '' }}">
                Catalog
            </a>

            <a href="{{ route('medewerkers') }}"
               class="header__link {{ request()->routeIs('medewerkers') ? 'active' : '' }}">
                Medewerkers
            </a>

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

            <a href="#" class="header__login">
                <svg viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="8" r="4"></circle>
                    <path d="M4.5 21C5.2 16.9 8 15 12 15C16 15 18.8 16.9 19.5 21"></path>
                </svg>

                <span>Inloggen</span>
            </a>
        </div>

    </div>
</header>
