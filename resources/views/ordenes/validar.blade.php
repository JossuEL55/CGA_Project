{{-- resources/views/ordenes/validar.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Validar Orden Técnica #{{ $orden->id_orden }}</h2>

    {{-- Mostrar detalles básicos --}}
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            Información de la orden
        </div>
        <div class="card-body">
            <p><strong>Cliente:</strong> {{ $orden->planta->cliente->nombre }}</p>
            <p><strong>Planta:</strong> {{ $orden->planta->nombre }}</p>
            <p><strong>Técnico asignado:</strong> {{ $orden->tecnico->nombre ?? 'Sin asignar' }}</p>
            <p><strong>Descripción:</strong> {{ $orden->descripcion }}</p>
            <p><strong>Estado actual:</strong> <span class="badge bg-info">{{ $orden->estado }}</span></p>
        </div>
    </div>

    {{-- Formulario de validación --}}
    <div class="card">
        <div class="card-header">
            Formulario de Validación
        </div>
        <div class="card-body">
            <form action="{{ route('ordenes.validar', $orden) }}" method="POST">
                @csrf

                {{-- Selector de estado --}}
                <div class="mb-3">
                    <label for="estado" class="form-label">Nuevo estado <span class="text-danger">*</span></label>
                    <select name="estado" id="estado" class="form-select @error('estado') is-invalid @enderror">
                        <option value="">-- Seleccione un estado --</option>
                        <option value="Pendiente"   {{ old('estado') == 'Pendiente'   ? 'selected' : '' }}>Pendiente</option>
                        <option value="En Proceso"  {{ old('estado') == 'En Proceso'  ? 'selected' : '' }}>En Proceso</option>
                        <option value="Validada"    {{ old('estado') == 'Validada'    ? 'selected' : '' }}>Validada</option>
                        <option value="Rechazada"   {{ old('estado') == 'Rechazada'   ? 'selected' : '' }}>Rechazada</option>
                    </select>
                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Observaciones --}}
                <div class="mb-3">
                    <label for="observaciones" class="form-label">Observaciones (opcional)</label>
                    <textarea name="observaciones" id="observaciones"
                              class="form-control @error('observaciones') is-invalid @enderror"
                              rows="4">{{ old('observaciones') }}</textarea>
                    @error('observaciones')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Botones --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('ordenes.index') }}" class="btn btn-secondary">
                        ← Volver al listado
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Guardar validación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
