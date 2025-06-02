@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-lg">
  <h1 class="text-2xl font-bold mb-4">Crear Validación</h1>

  <form action="{{ route('validaciones.store') }}" method="POST">
    @csrf

    <input type="hidden" name="id_orden" value="{{ $orden->id_orden }}">

    <label class="block mb-1 font-semibold" for="estado_validacion">Estado *</label>
    <select name="estado_validacion" id="estado_validacion" class="border p-2 rounded w-full mb-4" required>
      <option value="">Seleccione estado</option>
      <option value="Validada" {{ old('estado_validacion') == 'Validada' ? 'selected' : '' }}>Validada</option>
      <option value="Rechazada" {{ old('estado_validacion') == 'Rechazada' ? 'selected' : '' }}>Rechazada</option>
    </select>

    <label class="block mb-1 font-semibold" for="comentarios">Comentarios</label>
    <textarea name="comentarios" id="comentarios" rows="4" class="border p-2 rounded w-full mb-4" placeholder="Comentarios adicionales">{{ old('comentarios') }}</textarea>

    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Guardar Validación</button>
    <a href="{{ route('validaciones.index') }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
  </form>
</div>
@endsection
