@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
  <div class="bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-semibold mb-6">Editar Cliente</h2>

    {{-- Mostrar errores de validación --}}
    @if($errors->any())
      <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded mb-6">
        <ul class="list-disc pl-5 space-y-1">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('clientes.update', $cliente) }}" method="POST">
      @csrf
      @method('PUT')

      {{-- Nombre --}}
      <div class="mb-4">
        <label for="nombre" class="block text-gray-700 mb-1">
          Nombre <span class="text-red-500">*</span>
        </label>
        <input
          id="nombre"
          type="text"
          name="nombre"
          value="{{ old('nombre', $cliente->nombre) }}"
          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
          required
        >
      </div>

      {{-- Razón Social --}}
      <div class="mb-4">
        <label for="razon_social" class="block text-gray-700 mb-1">
          Razón Social
        </label>
        <input
          id="razon_social"
          type="text"
          name="razon_social"
          value="{{ old('razon_social', $cliente->razon_social) }}"
          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
        >
      </div>

      {{-- Dirección --}}
      <div class="mb-4">
        <label for="direccion" class="block text-gray-700 mb-1">
          Dirección
        </label>
        <input
          id="direccion"
          type="text"
          name="direccion"
          value="{{ old('direccion', $cliente->direccion) }}"
          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
        >
      </div>

      {{-- Teléfono --}}
      <div class="mb-4">
        <label for="telefono" class="block text-gray-700 mb-1">
          Teléfono
        </label>
        <input
          id="telefono"
          type="text"
          name="telefono"
          value="{{ old('telefono', $cliente->telefono) }}"
          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
        >
      </div>

      {{-- Email --}}
      <div class="mb-6">
        <label for="email" class="block text-gray-700 mb-1">
          Email
        </label>
        <input
          id="email"
          type="email"
          name="email"
          value="{{ old('email', $cliente->email) }}"
          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
        >
      </div>

      {{-- Botón de actualización --}}
      <div class="flex justify-end">
        <button
          type="submit"
          class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring"
        >
          <!-- Ícono de lápiz -->
          <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15.232 5.232l3.536 3.536M9 13.5l4.5-4.5" />
          </svg>
          Actualizar Cliente
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

