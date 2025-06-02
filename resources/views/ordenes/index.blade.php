@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
  <h1 class="text-2xl font-bold mb-4">Órdenes Técnicas</h1>

  <a href="{{ route('ordenes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-700">
    Nueva Orden Técnica
  </a>

  <input type="text" id="buscador" placeholder="Buscar órdenes..." class="border rounded p-2 mb-4 w-full">

  <table class="min-w-full bg-white rounded shadow">
    <thead class="bg-gray-100">
      <tr>
        <th class="px-4 py-2">ID</th>
        <th class="px-4 py-2">Descripción</th>
        <th class="px-4 py-2">Fecha Servicio</th>
        <th class="px-4 py-2">Estado</th>
        <th class="px-4 py-2">Planta</th>
        <th class="px-4 py-2">Técnico</th>
        <th class="px-4 py-2">Acciones</th>
      </tr>
    </thead>
    <tbody id="tabla-ordenes">
      @foreach ($ordenes as $orden)
      <tr>
        <td class="border px-4 py-2">{{ $orden->id_orden }}</td>
        <td class="border px-4 py-2">{{ $orden->descripcion }}</td>
        <td class="border px-4 py-2">{{ $orden->fecha_servicio }}</td>
        <td class="border px-4 py-2">{{ $orden->estado }}</td>
        <td class="border px-4 py-2">{{ $orden->planta->nombre ?? '' }}</td>
        <td class="border px-4 py-2">{{ $orden->tecnico->nombre ?? '' }}</td>
        <td class="border px-4 py-2">
          <a href="{{ route('ordenes.show', $orden) }}" class="text-blue-600 hover:underline mr-2">Ver</a>
          @can('update', $orden)
          <a href="{{ route('ordenes.edit', $orden) }}" class="text-green-600 hover:underline mr-2">Editar</a>
          @endcan
          @can('validar', $orden)
          <a href="{{ route('ordenes.validar', $orden) }}" class="text-purple-600 hover:underline">Validar</a>
          @endcan
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="mt-4">
    {{ $ordenes->links() }}
  </div>
</div>

<script>
  document.getElementById('buscador').addEventListener('input', function() {
    const filtro = this.value.toLowerCase();
    document.querySelectorAll('#tabla-ordenes tr').forEach(tr => {
      tr.style.display = tr.textContent.toLowerCase().includes(filtro) ? '' : 'none';
    });
  });
</script>
@endsection
