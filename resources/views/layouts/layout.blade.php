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
