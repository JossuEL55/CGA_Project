{{-- resources/views/ordenes/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width: 600px;">
    <h1 class="mb-4">Crear Orden Técnica</h1>

    {{-- Mostrar errores de validación, si hay --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ordenes.store') }}" method="POST" novalidate>
        @csrf

        {{-- 1) Descripción --}}
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción *</label>
            <textarea id="descripcion"
                      name="descripcion"
                      class="form-control"
                      rows="3"
                      required>{{ old('descripcion') }}</textarea>
        </div>

        {{-- 2) Fecha de servicio --}}
        <div class="mb-3">
            <label for="fecha_servicio" class="form-label">Fecha de Servicio *</label>
            <input type="date"
                   id="fecha_servicio"
                   name="fecha_servicio"
                   value="{{ old('fecha_servicio') }}"
                   class="form-control"
                   required>
        </div>

        {{-- 3) Select de Cliente --}}
        <div class="mb-3">
            <label for="id_cliente" class="form-label">Cliente *</label>
            <select id="id_cliente"
                    name="id_cliente"
                    class="form-select"
                    required>
                <option value="">-- Seleccione cliente --</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id_cliente }}"
                        {{ old('id_cliente') == $cliente->id_cliente ? 'selected' : '' }}>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- 4) Select de Planta --}}
        <div class="mb-3">
            <label for="id_planta" class="form-label">Planta *</label>
            <select id="id_planta"
                    name="id_planta"
                    class="form-select"
                    required>
                <option value="">-- Seleccione planta --</option>
                @foreach($plantas as $planta)
                    <option value="{{ $planta->id_planta }}"
                        {{ old('id_planta') == $planta->id_planta ? 'selected' : '' }}>
                        {{ $planta->cliente->nombre }} / {{ $planta->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- 5) Select de Técnico (opcional) --}}
        <div class="mb-3">
            <label for="id_tecnico" class="form-label">Técnico</label>
            <select id="id_tecnico"
                    name="id_tecnico"
                    class="form-select">
                <option value="">-- Asignar técnico (opcional) --</option>
                @foreach($tecnicos as $tecnico)
                    <option value="{{ $tecnico->id_tecnico }}"
                        {{ old('id_tecnico') == $tecnico->id_tecnico ? 'selected' : '' }}>
                        {{ $tecnico->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Botones --}}
        <button type="submit" class="btn btn-primary">Guardar Orden</button>
        <a href="{{ route('ordenes.index') }}" class="btn btn-link">Cancelar</a>
    </form>
</div>
@endsection