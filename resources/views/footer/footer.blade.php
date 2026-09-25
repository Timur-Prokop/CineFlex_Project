@vite('resources/css/footer.css')

<footer class="site-footer">
    <div class="footer-container">

        <div class="footer-top">

            <div class="footer-brand">
                <div class="footer-logo">
                    CINE<span>FLEX</span>
                </div>

                <p>
                    Jouw bioscoop voor films, trailers en reserveringen.
                </p>
            </div>

            <nav class="footer-nav">
                <a href="{{route('home')}}">Home</a>
                <a href="{{route('films')}}">Films</a>
                <a href="{{route('catalog')}}">Catalog</a>
                <a href="{{route('contact')}}">Contact</a>
            </nav>

        </div>

        <div class="footer-bottom">
            <span>© 2026 CINEFLEX</span>

            <div class="footer-legal">
                <a href="#">Privacy</a>
                <a href="#">Voorwaarden</a>
            </div>
        </div>

    </div>
</footer>
