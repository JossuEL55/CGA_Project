@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-lg">
  <h1 class="text-2xl font-bold mb-4">Crear Planta</h1>

  @if($errors->any())
    <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
      <ul>
        @foreach ($errors->all() as $error)
          <li>- {{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('plantas.store') }}" method="POST" novalidate>
    @csrf

    <label class="block mb-1 font-semibold" for="id_cliente">Cliente *</label>
    <select id="id_cliente" name="id_cliente" class="border p-2 rounded w-full mb-4" required>
      <option value="">Seleccione cliente</option>
      @foreach($clientes as $cliente)
        <option value="{{ $cliente->id_cliente }}" {{ old('id_cliente') == $cliente->id_cliente ? 'selected' : '' }}>{{ $cliente->nombre }}</option>
      @endforeach
    </select>

    <label class="block mb-1 font-semibold" for="nombre">Nombre *</label>
    <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" placeholder="Nombre de la planta" class="border p-2 rounded w-full mb-4" required>

    <label class="block mb-1 font-semibold" for="ubicacion">Ubicación</label>
    <input type="text" id="ubicacion" name="ubicacion" value="{{ old('ubicacion') }}" placeholder="Ubicación física" class="border p-2 rounded w-full mb-4">

    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Guardar</button>
    <a href="{{ route('plantas.index') }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
  </form>
</div>
@endsection
