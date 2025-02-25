<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Agropuro</title>
    @vite([
        'resources/css/app.css',
         'resources/js/app.js'])
</head>
<body id="app">

    @include('partials.header')

    <main>
        @yield('content')
    </main>
</@include('partials.footer')


</body>
</html>
