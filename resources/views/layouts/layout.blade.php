<!doctype html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/header.css', 'resources/js/header.js' ])

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CineFlex</title>
</head>
<body>

@include("header.header")

@yield("content")

@include("footer.footer")
</body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const headerNav = document.querySelector('.header__nav');

        if (mobileMenuBtn && headerNav) {
            mobileMenuBtn.addEventListener('click', function() {
                headerNav.classList.toggle('active');
            });
        }
    });
</script>
