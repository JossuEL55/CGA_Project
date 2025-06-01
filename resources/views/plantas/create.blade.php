@extends('layouts.app')

@section('title', 'Nueva Planta')

@section('content')
<div class="max-w-2xl mx-auto">
  <div class="bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-semibold mb-6">Nueva Planta</h2>

    {{-- Errores de Validación --}}
    @if($errors->any())
      <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded mb-6">
        <ul class="list-disc pl-5 space-y-1">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('plantas.store') }}" method="POST">
      @csrf

      {{-- Cliente --}}
      <div class="mb-4">
        <label for="id_cliente" class="block text-gray-700 mb-1">
          Cliente <span class="text-red-500">*</span>
        </label>
        <select
          id="id_cliente"
          name="id_cliente"
          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
          required
        >
          <option value="">-- Seleccione Cliente --</option>
          @foreach($clientes as $cliente)
            <option
              value="{{ $cliente->id_cliente }}"
              {{ old('id_cliente') == $cliente->id_cliente ? 'selected' : '' }}
            >
              {{ $cliente->nombre }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- Nombre de la Planta --}}
      <div class="mb-4">
        <label for="nombre" class="block text-gray-700 mb-1">
          Nombre de la Planta <span class="text-red-500">*</span>
        </label>
        <input
          id="nombre"
          type="text"
          name="nombre"
          value="{{ old('nombre') }}"
          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
          required
        >
      </div>

      {{-- Ubicación --}}
      <div class="mb-4">
        <label for="ubicacion" class="block text-gray-700 mb-1">
          Ubicación
        </label>
        <input
          id="ubicacion"
          type="text"
          name="ubicacion"
          value="{{ old('ubicacion') }}"
          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
        >
      </div>

      {{-- Botones --}}
      <div class="flex justify-end space-x-2">
        <a href="{{ route('plantas.index') }}"
           class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
          Cancelar
        </a>
        <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
          <!-- Ícono de guardar -->
          <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 5v14a2 2 0 002 2h10a2 2 0 002-2V7l-4-4H7a2 2 0 00-2 2z" />
          </svg>
          Guardar Planta
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
