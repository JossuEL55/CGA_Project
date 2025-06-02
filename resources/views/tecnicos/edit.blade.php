@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-lg">
  <h1 class="text-2xl font-bold mb-4">Editar Técnico</h1>

  @if($errors->any())
    <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
      <ul>
        @foreach ($errors->all() as $error)
          <li>- {{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('tecnicos.update', $tecnico) }}" method="POST" novalidate>
    @csrf
    @method('PUT')

    <label class="block mb-1 font-semibold" for="nombre">Nombre *</label>
    <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $tecnico->nombre) }}" placeholder="Nombre completo" class="border p-2 rounded w-full mb-4" required>

    <label class="block mb-1 font-semibold" for="cedula">Cédula *</label>
    <input type="text" id="cedula" name="cedula" value="{{ old('cedula', $tecnico->cedula) }}" placeholder="Cédula única" class="border p-2 rounded w-full mb-4" required>

    <label class="block mb-1 font-semibold" for="especialidad">Especialidad *</label>
    <input type="text" id="especialidad" name="especialidad" value="{{ old('especialidad', $tecnico->especialidad) }}" placeholder="Especialidad" class="border p-2 rounded w-full mb-4" required>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Actualizar</button>
    <a href="{{ route('tecnicos.index') }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
  </form>
</div>
@endsection
