{{-- resources/views/ordenes/create.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-lg">
  <h1 class="text-2xl font-bold mb-4">Crear Orden Técnica</h1>

  {{-- Si hay errores de validación, los mostramos aquí --}}
  @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
      <ul>
        @foreach ($errors->all() as $error)
          <li>- {{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('ordenes.store') }}" method="POST" novalidate>
    @csrf

    {{-- 1) Fecha de servicio --}}
    <label class="block mb-1 font-semibold" for="fecha_servicio">Fecha de Servicio *</label>
    <input 
      type="date" 
      id="fecha_servicio" 
      name="fecha_servicio" 
      value="{{ old('fecha_servicio') }}" 
      class="border p-2 rounded w-full mb-4"
      required
    >

    {{-- 2) Select de Clientes --}}
    <label class="block mb-1 font-semibold" for="id_cliente">Cliente *</label>
    <select 
      id="id_cliente" 
      name="id_cliente" 
      class="border p-2 rounded w-full mb-4" 
      required
    >
      <option value="">-- Seleccione cliente --</option>
      @foreach($clientes as $cliente)
        <option 
          value="{{ $cliente->id_cliente }}"
          {{ old('id_cliente') == $cliente->id_cliente ? 'selected' : '' }}
        >
          {{ $cliente->nombre }}
        </option>
      @endforeach
    </select>

    {{-- 3) Select de Plantas --}}
    {{--    Aquí podrías filtrar “solo las plantas de ese cliente” con JavaScript. 
              Por simplicidad, cargamos todas las plantas y luego el usuario elige. --}}
    <label class="block mb-1 font-semibold" for="id_planta">Planta *</label>
    <select 
      id="id_planta" 
      name="id_planta" 
      class="border p-2 rounded w-full mb-4" 
      required
    >
      <option value="">-- Seleccione planta --</option>
      @foreach($plantas as $planta)
        <option 
          value="{{ $planta->id_planta }}"
          {{ old('id_planta') == $planta->id_planta ? 'selected' : '' }}
        >
          {{ $planta->cliente->nombre }} / {{ $planta->nombre }}
        </option>
      @endforeach
    </select>

    {{-- 4) Select de Técnico --}}
    <label class="block mb-1 font-semibold" for="id_tecnico">Técnico</label>
    <select 
      id="id_tecnico" 
      name="id_tecnico" 
      class="border p-2 rounded w-full mb-4"
    >
      <option value="">-- Asignar técnico (opcional) --</option>
      @foreach($tecnicos as $tecnico)
        <option 
          value="{{ $tecnico->id_tecnico }}"
          {{ old('id_tecnico') == $tecnico->id_tecnico ? 'selected' : '' }}
        >
          {{ $tecnico->nombre }}
        </option>
      @endforeach
    </select>

    >{{ old('observaciones') }}</textarea>
    <label for="descripcion" class="form-label">Descripción *</label>
<textarea id="descripcion" name="descripcion" class="form-control" required>{{ old('descripcion') }}</textarea>

@error('descripcion')
    <div class="text-danger">{{ $message }}</div>
@enderror

    {{-- 6) Botón Enviar --}}
    <button 
      type="submit" 
      class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
    >
      Guardar Orden
    </button>

    <a href="{{ route('ordenes.index') }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
  </form>
</div>
@endsection
