@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
  <h1 class="text-2xl font-bold mb-4">Clientes</h1>

  <a href="{{ route('clientes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-700">
    Nuevo Cliente
  </a>

  <input type="text" id="buscador" placeholder="Buscar clientes..." class="border rounded p-2 mb-4 w-full">

  <table class="min-w-full bg-white rounded shadow">
    <thead class="bg-gray-100">
      <tr>
        <th class="px-4 py-2">ID</th>
        <th class="px-4 py-2">Nombre</th>
        <th class="px-4 py-2">RUC</th>
        <th class="px-4 py-2">Correo</th>
        <th class="px-4 py-2">Teléfono</th>
        <th class="px-4 py-2">Acciones</th>
      </tr>
    </thead>
    <tbody id="tabla-clientes">
      @foreach ($clientes as $cliente)
      <tr>
        <td class="border px-4 py-2">{{ $cliente->id_cliente }}</td>
        <td class="border px-4 py-2">{{ $cliente->nombre }}</td>
        <td class="border px-4 py-2">{{ $cliente->ruc }}</td>
        <td class="border px-4 py-2">{{ $cliente->correo }}</td>
        <td class="border px-4 py-2">{{ $cliente->telefono }}</td>
        <td class="border px-4 py-2">
          <a href="{{ route('clientes.edit', $cliente) }}" class="text-blue-600 hover:underline mr-2">Editar</a>
          <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar cliente?');">
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
    {{ $clientes->links() }}
  </div>
</div>

<script>
  document.getElementById('buscador').addEventListener('input', function() {
    const filtro = this.value.toLowerCase();
    document.querySelectorAll('#tabla-clientes tr').forEach(tr => {
      tr.style.display = tr.textContent.toLowerCase().includes(filtro) ? '' : 'none';
    });
  });
</script>
@endsection
