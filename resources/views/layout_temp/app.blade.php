<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Media Pembelajaran')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('CSS/StyleBeranda.css') }}">
</head>
<body>
    @yield('content')

    @yield('scripts')
</body>
</html>
