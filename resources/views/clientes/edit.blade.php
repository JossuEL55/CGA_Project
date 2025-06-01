@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-semibold mb-4">Editar Cliente</h2>

    @if($errors->any())
      <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('clientes.update', $cliente) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-4">
        <label class="block mb-1">Nombre <span class="text-red-500">*</span></label>
        <input type="text" name="nombre" value="{{ old('nombre', $cliente->nombre) }}"
               class="w-full border p-2 rounded" required>
      </div>

      <div class="mb-4">
        <label class="block mb-1">Razón Social</label>
        <input type="text" name="razon_social" value="{{ old('razon_social', $cliente->razon_social) }}"
               class="w-full border p-2 rounded">
      </div>

      <div class="mb-4">
        <label class="block mb-1">Dirección</label>
        <input type="text" name="direccion" value="{{ old('direccion', $cliente->direccion) }}"
               class="w-full border p-2 rounded">
      </div>

      <div class="mb-4">
        <label class="block mb-1">Teléfono</label>
        <input type="text" name="telefono" value="{{ old('telefono', $cliente->telefono) }}"
               class="w-full border p-2 rounded">
      </div>

      <div class="mb-4">
        <label class="block mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $cliente->email) }}"
               class="w-full border p-2 rounded">
      </div>

      <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">
        Actualizar Cliente
      </button>
    </form>
</div>
@endsection
