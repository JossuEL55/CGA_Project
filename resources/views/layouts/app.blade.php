<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>{{ config('app.name', 'Mi App') }}</title>
    <!-- Tus estilos y scripts -->
</head>

<body class="font-sans antialiased">
    @include('layouts.navigation')

    <main class="py-4">
        @yield('content')
    </main>
<<<<<<< HEAD
@if(auth()->user()->unreadNotifications->count())
    <div class="notifications p-4 bg-yellow-100 rounded mb-4">
        <h4 class="font-bold mb-2">Notificaciones</h4>
        <ul>
            @foreach(auth()->user()->unreadNotifications as $notification)
                <li class="mb-1">
                    {{ $notification->data['mensaje'] }}
                    <a href="{{ route('ordenes.show', $notification->data['orden_id']) }}" class="text-blue-600 underline">Ver</a>
                </li>
            @endforeach
        </ul>
    </div>
@endif
=======
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
>>>>>>> origin/develop2

</body>

</html>