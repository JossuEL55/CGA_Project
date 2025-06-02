{{-- resources/views/ordenes/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Detalle de la Orden #{{ $orden->id_orden }}</h1>

    {{-- Información básica de la orden --}}
    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Cliente:</strong>
                {{ optional($orden->planta->cliente)->nombre ?? '– sin cliente –' }}
            </p>
            <p><strong>Planta:</strong>
                {{ optional($orden->planta)->nombre ?? '– sin planta –' }}
            </p>
            <p><strong>Técnico asignado:</strong>
                {{ optional($orden->tecnico)->nombre ?? '– sin asignar –' }}
            </p>
            <p><strong>Supervisor:</strong>
                {{ optional($orden->supervisor)->nombre ?? '– sin validar –' }}
            </p>
            <p><strong>Estado:</strong>
                <span class="badge 
                    @if($orden->estado === 'Pendiente') bg-warning text-dark
                    @elseif($orden->estado === 'En Proceso') bg-info text-white
                    @elseif($orden->estado === 'Validada') bg-success text-white
                    @elseif($orden->estado === 'Rechazada') bg-danger text-white
                    @else bg-secondary text-white
                    @endif
                ">
                    {{ $orden->estado }}
                </span>
            </p>
            <p><strong>Descripción:</strong> {{ $orden->descripcion ?? 'Sin descripción' }}</p>
            <p><strong>Fecha de creación:</strong>
                {{ $orden->created_at->format('d/m/Y H:i') }}
            </p>
            {{-- Agrega aquí más campos si los tuvieras --}}
        </div>
    </div>

    {{-- Botones de acción --}}
    <div class="d-flex gap-2">
        <a href="{{ route('ordenes.index') }}" class="btn btn-secondary">
            ← Volver al listado
        </a>

        @can('update', $orden)
            <a href="{{ route('ordenes.edit', $orden->id_orden) }}" class="btn btn-warning">
                Editar Orden
            </a>
        @endcan

        @can('destroy', $orden)
            <form action="{{ route('ordenes.destroy', $orden->id_orden) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('¿Estás seguro de eliminar esta orden?')">
                    Eliminar Orden
                </button>
            </form>
        @endcan
    </div>
</div>
@endsection
