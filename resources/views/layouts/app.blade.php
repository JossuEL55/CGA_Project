<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Mi App') }}</title>
    <!-- Tus estilos y scripts -->
</head>
<body class="font-sans antialiased">
    @include('layouts.navigation')

    <main class="py-4">
        @yield('content')
    </main>
</body>
</html>
