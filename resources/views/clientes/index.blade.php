<!-- resources/views/clientes/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Clientes</h1>

    <input type="text" id="filtro" placeholder="Buscar cliente..." class="border rounded p-2 mb-4 w-full">

    <table class="min-w-full bg-white rounded shadow">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Correo</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody id="tablaClientes">
            @foreach($clientes as $cliente)
            <tr>
                <td class="border px-4 py-2">{{ $cliente->id_cliente }}</td>
                <td class="border px-4 py-2">{{ $cliente->nombre }}</td>
                <td class="border px-4 py-2">{{ $cliente->correo }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('clientes.edit', $cliente) }}" class="text-blue-500">Editar</a>
                    <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500">Eliminar</button>
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
document.getElementById('filtro').addEventListener('input', function() {
    let filtro = this.value.toLowerCase();
    document.querySelectorAll('#tablaClientes tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(filtro) ? '' : 'none';
    });
});
</script>
@endsection
