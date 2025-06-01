@extends('layouts.app')

@section('title', 'Listado de Plantas')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

  {{-- Encabezado con título y botón --}}
  <div class="flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-800">Plantas</h1>
    <a href="{{ route('plantas.create') }}"
       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
      <!-- Ícono "+" -->
      <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
      </svg>
      Nueva Planta
    </a>
  </div>

  {{-- Mensaje Flash --}}
  @if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded">
      {{ session('success') }}
    </div>
  @endif

  {{-- Tabla de Plantas --}}
  <div class="bg-white shadow rounded-lg overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-100">
        @forelse($plantas as $planta)
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $planta->id_planta }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $planta->cliente->nombre }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $planta->nombre }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $planta->ubicacion ?? '–' }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 space-x-2">
              <a href="{{ route('plantas.edit', $planta) }}"
                 class="text-blue-500 hover:underline">Editar</a>
              <form action="{{ route('plantas.destroy', $planta) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('¿Eliminar esta planta?')"
                        class="text-red-500 hover:underline">
                  Eliminar
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
              No hay plantas registradas.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Paginación opcional --}}
  <div class="mt-4">
    {{ $plantas->links() }}
  </div>
</div>
@endsection
