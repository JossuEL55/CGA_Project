{{-- resources/views/ordenes/validar.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width: 600px;">
    <h1 class="mb-4">Validar Orden #{{ $orden->id_orden }}</h1>

    {{-- Mostrar información básica de la orden --}}
    <div class="mb-3">
        <strong>Cliente:</strong> {{ $orden->planta->cliente->nombre }}<br>
        <strong>Planta:</strong> {{ $orden->planta->nombre }}<br>
        <strong>Técnico asignado:</strong> {{ $orden->tecnico->nombre ?? 'Sin asignar' }}<br>
        <strong>Descripción:</strong> <br>
        <div class="border p-2 rounded">{{ $orden->descripcion }}</div>
    </div>

    <form action="{{ route('ordenes.validar', $orden->id_orden) }}" method="POST">
        @csrf

        {{-- Campo “estado” --}}
        <div class="mb-3">
            <label for="estado" class="form-label">Nuevo Estado *</label>
            <select id="estado"
                    name="estado"
                    class="form-select"
                    required>
                <option value="">-- Seleccione estado --</option>
                <option value="Pendiente"    {{ old('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="En Proceso"    {{ old('estado') == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
                <option value="Validada"      {{ old('estado') == 'Validada' ? 'selected' : '' }}>Validada</option>
                <option value="Rechazada"     {{ old('estado') == 'Rechazada' ? 'selected' : '' }}>Rechazada</option>
            </select>
        </div>

        {{-- Botones --}}
        <button type="submit" class="btn btn-success">Guardar Validación</button>
        <a href="{{ route('ordenes.index') }}" class="btn btn-link">Cancelar</a>
    </form>
</div>
@endsection