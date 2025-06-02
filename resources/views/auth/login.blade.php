{{-- Ejemplo resumido de login.blade.php --}}
@extends('layouts.app')

@push('styles')
    <style>
        /* Fondo de pantalla completa */
        .login-page {
            background: url('{{ asset("images/login-bg.jpg") }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        /* Recuadro transparente para el formulario */
        .login-box {
            background-color: rgba(255,255,255,0.85);
            padding: 2rem;
            border-radius: 0.5rem;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.2);
            text-align: center;
        }
        .login-box h2 {
            margin-bottom: 1.5rem;
            color: var(--verde-oscuro);
        }
        .login-box .btn-primary {
            background-color: var(--verde-oscuro);
            border: none;
        }
        .login-box .btn-primary:hover {
            background-color: var(--verde-claro);
        }
    </style>
@endpush

@section('content')
<div class="login-page">
    <div class="login-box">
        {{-- Logo superior --}}
        <img src="{{ asset('images/oil.png') }}" alt="Logo CGA OIL" height="60" class="mb-3">

        <h2>Iniciar Sesión</h2>
        {{-- (formulario de login aquí) --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf
            {{-- campos de email y password --}}
            <div class="mb-3">
                <label for="email" class="form-label"><strong>Email</strong></label>
                <input id="email" type="email" name="email" required autofocus class="form-control" placeholder="correo@ejemplo.com">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label"><strong>Contraseña</strong></label>
                <input id="password" type="password" name="password" required class="form-control" placeholder="********">
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                <label class="form-check-label" for="remember_me">Recordarme</label>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
            </div>
            {{-- enlaces de “Olvidé mi contraseña” y “Registrarse” --}}
            <div class="mt-3 d-flex justify-content-between">
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                @endif
                @if(Route::has('register'))
                    <a href="{{ route('register') }}">Registrarse</a>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
