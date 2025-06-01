@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold">Plantas</h2>
        <a href="{{ route('plantas.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">
            Nueva Planta
        </a>
    </div>

    @if(session('success'))
      <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
        {{ session('success') }}
      </div>
    @endif

    <table class="min-w-full bg-white">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 text-left">ID</th>
                <th class="px-4 py-2 text-left">Cliente</th>
                <th class="px-4 py-2 text-left">Nombre</th>
                <th class="px-4 py-2 text-left">Ubicación</th>
                <th class="px-4 py-2 text-left">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($plantas as $planta)
              <tr>
                  <td class="border px-4 py-2">{{ $planta->id }}</td>
                  <td class="border px-4 py-2">{{ $planta->cliente->nombre }}</td>
                  <td class="border px-4 py-2">{{ $planta->nombre }}</td>
                  <td class="border px-4 py-2">{{ $planta->ubicacion }}</td>
                  <td class="border px-4 py-2">
                      <a href="{{ route('plantas.edit', $planta) }}" class="text-blue-500 mr-2">Editar</a>
                      <form action="{{ route('plantas.destroy', $planta) }}" method="POST" class="inline-block">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="text-red-500" onclick="return confirm('¿Eliminar esta planta?')">
                            Eliminar
                          </button>
                      </form>
                  </td>
              </tr>
            @empty
              <tr>
                  <td colspan="5" class="border px-4 py-2 text-center">No hay plantas registradas</td>
              </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
