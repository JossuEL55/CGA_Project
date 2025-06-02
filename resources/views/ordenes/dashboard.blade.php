{{-- resources/views/ordenes/dashboard.blade.php --}}
@extends('layouts.app')

@push('styles')
    <style>
        /* Banner grande en la parte superior */
        .dashboard-hero {
            background: url('{{ asset("images/cga.") }}') no-repeat center center;
            background-size: cover;
            height: 250px;
            position: relative;
            color: white;
        }
        .dashboard-hero::after {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(0, 0, 0, 0.4); /* oscurecer un poco la imagen */
        }
        .dashboard-hero .hero-content {
            position: relative;
            z-index: 1;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .dashboard-hero h1 {
            font-size: 2.5rem;
            font-weight: bold;
            text-shadow: 1px 1px 4px rgba(0,0,0,0.7);
        }
        .dashboard-hero p {
            font-size: 1.1rem;
            margin-top: 0.5rem;
            text-shadow: 1px 1px 4px rgba(0,0,0,0.7);
        }
    </style>
@endpush

@section('content')
    {{-- Hero banner --}}
    <div class="dashboard-hero mb-5">
        <div class="hero-content text-center">
            <h1>Bienvenido, {{ Auth::user()->name }}</h1>
            <p>Visión general de las órdenes técnicas</p>
        </div>
    </div>

    {{-- Tarjetas de métricas --}}
    <div class="row gy-4">
        {{-- Total de Órdenes --}}
        <div class="col-md-3">
            <div class="card text-white bg-primary h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Total de Órdenes</h5>
                    <h2 class="card-text">{{ $totalOrdenes }}</h2>
                </div>
            </div>
        </div>

        {{-- Órdenes por estado --}}
        @foreach($estados as $estado => $cantidad)
            @php
                switch($estado) {
                    case 'Pendiente':
                        $bg = 'bg-warning text-dark';
                        break;
                    case 'En Proceso':
                        $bg = 'bg-info text-white';
                        break;
                    case 'Validada':
                        $bg = 'bg-success text-white';
                        break;
                    case 'Rechazada':
                        $bg = 'bg-danger text-white';
                        break;
                    default:
                        $bg = 'bg-secondary text-white';
                }
            @endphp

            <div class="col-md-3">
                <div class="card {{ $bg }} h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $estado }}</h5>
                        <h2 class="card-text">{{ $cantidad }}</h2>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Botón rápido para ver todas las órdenes --}}
    <div class="mt-5 text-center">
        <a href="{{ route('ordenes.index') }}" class="btn btn-outline-primary btn-lg">
            <i class="bi bi-list-check"></i> Ver listado completo de órdenes
        </a>
    </div>
@endsection
