@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
  <h1 class="text-2xl font-bold mb-4">Técnicos</h1>

  <a href="{{ route('tecnicos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-700">
    Nuevo Técnico
  </a>

  <input type="text" id="buscador" placeholder="Buscar técnicos..." class="border rounded p-2 mb-4 w-full">

  <table class="min-w-full bg-white rounded shadow">
    <thead class="bg-gray-100">
      <tr>
        <th class="px-4 py-2">ID</th>
        <th class="px-4 py-2">Nombre</th>
        <th class="px-4 py-2">Cédula</th>
        <th class="px-4 py-2">Especialidad</th>
        <th class="px-4 py-2">Acciones</th>
      </tr>
    </thead>
    <tbody id="tabla-tecnicos">
      @foreach ($tecnicos as $tecnico)
      <tr>
        <td class="border px-4 py-2">{{ $tecnico->id_tecnico }}</td>
        <td class="border px-4 py-2">{{ $tecnico->nombre }}</td>
        <td class="border px-4 py-2">{{ $tecnico->cedula }}</td>
        <td class="border px-4 py-2">{{ $tecnico->especialidad }}</td>
        <td class="border px-4 py-2">
          <a href="{{ route('tecnicos.edit', $tecnico) }}" class="text-blue-600 hover:underline mr-2">Editar</a>
          <form action="{{ route('tecnicos.destroy', $tecnico) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar técnico?');">
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
    {{ $tecnicos->links() }}
  </div>
</div>

<script>
  document.getElementById('buscador').addEventListener('input', function() {
    const filtro = this.value.toLowerCase();
    document.querySelectorAll('#tabla-tecnicos tr').forEach(tr => {
      tr.style.display = tr.textContent.toLowerCase().includes(filtro) ? '' : 'none';
    });
  });
</script>
@endsection
