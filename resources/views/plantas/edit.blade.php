@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-semibold mb-4">Editar Planta</h2>

    @if($errors->any())
      <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('plantas.update', $planta) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-4">
        <label class="block mb-1">Cliente <span class="text-red-500">*</span></label>
        <select name="cliente_id" class="w-full border p-2 rounded" required>
          <option value="">-- Seleccione Cliente --</option>
          @foreach($clientes as $cliente)
            <option value="{{ $cliente->id }}"
              {{ old('cliente_id', $planta->cliente_id) == $cliente->id ? 'selected' : '' }}>
              {{ $cliente->nombre }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="mb-4">
        <label class="block mb-1">Nombre de la Planta <span class="text-red-500">*</span></label>
        <input type="text" name="nombre" value="{{ old('nombre', $planta->nombre) }}"
               class="w-full border p-2 rounded" required>
      </div>

      <div class="mb-4">
        <label class="block mb-1">Ubicación</label>
        <input type="text" name="ubicacion" value="{{ old('ubicacion', $planta->ubicacion) }}"
               class="w-full border p-2 rounded">
      </div>

      <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">
        Actualizar Planta
      </button>
    </form>
</div>
@endsection
