@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
  <h1 class="text-2xl font-bold mb-4">Plantas</h1>

  <a href="{{ route('plantas.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-700">
    Nueva Planta
  </a>

  <input type="text" id="buscador" placeholder="Buscar plantas..." class="border rounded p-2 mb-4 w-full">

  <table class="min-w-full bg-white rounded shadow">
    <thead class="bg-gray-100">
      <tr>
        <th class="px-4 py-2">ID</th>
        <th class="px-4 py-2">Cliente</th>
        <th class="px-4 py-2">Nombre</th>
        <th class="px-4 py-2">Ubicación</th>
        <th class="px-4 py-2">Acciones</th>
      </tr>
    </thead>
    <tbody id="tabla-plantas">
      @foreach ($plantas as $planta)
      <tr>
        <td class="border px-4 py-2">{{ $planta->id_planta }}</td>
        <td class="border px-4 py-2">{{ $planta->cliente->nombre }}</td>
        <td class="border px-4 py-2">{{ $planta->nombre }}</td>
        <td class="border px-4 py-2">{{ $planta->ubicacion }}</td>
        <td class="border px-4 py-2">
          <a href="{{ route('plantas.edit', $planta) }}" class="text-blue-600 hover:underline mr-2">Editar</a>
          <form action="{{ route('plantas.destroy', $planta) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar planta?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="mt-4">
    {{ $plantas->links() }}
  </div>
</div>

<script>
  document.getElementById('buscador').addEventListener('input', function() {
    const filtro = this.value.toLowerCase();
    document.querySelectorAll('#tabla-plantas tr').forEach(tr => {
      tr.style.display = tr.textContent.toLowerCase().includes(filtro) ? '' : 'none';
    });
  });
</script>
@endsection
