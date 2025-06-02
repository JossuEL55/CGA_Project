@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-lg">
  <h1 class="text-2xl font-bold mb-4">Editar Cliente</h1>

  @if($errors->any())
    <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
      <ul>
        @foreach ($errors->all() as $error)
          <li>- {{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('clientes.update', $cliente) }}" method="POST" novalidate>
    @csrf
    @method('PUT')

    <label class="block mb-1 font-semibold" for="nombre">Nombre *</label>
    <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" placeholder="Nombre completo" class="border p-2 rounded w-full mb-4" required>

    <label class="block mb-1 font-semibold" for="ruc">RUC *</label>
    <input type="text" id="ruc" name="ruc" value="{{ old('ruc', $cliente->ruc) }}" placeholder="Ej: 0123456789001" class="border p-2 rounded w-full mb-4" maxlength="13" required>

    <label class="block mb-1 font-semibold" for="correo">Correo</label>
    <input type="email" id="correo" name="correo" value="{{ old('correo', $cliente->correo) }}" placeholder="correo@empresa.com" class="border p-2 rounded w-full mb-4">

    <label class="block mb-1 font-semibold" for="telefono">Teléfono</label>
    <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $cliente->telefono) }}" placeholder="+593 9 1234 5678" class="border p-2 rounded w-full mb-4">

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Actualizar</button>
    <a href="{{ route('clientes.index') }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
  </form>
</div>
@endsection
