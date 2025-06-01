@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold">Clientes</h2>
        <a href="{{ route('clientes.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">
            Nuevo Cliente
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
                <th class="px-4 py-2 text-left">Nombre</th>
                <th class="px-4 py-2 text-left">Razón Social</th>
                <th class="px-4 py-2 text-left">Email</th>
                <th class="px-4 py-2 text-left">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clientes as $cliente)
              <tr>
                  <td class="border px-4 py-2">{{ $cliente->id }}</td>
                  <td class="border px-4 py-2">{{ $cliente->nombre }}</td>
                  <td class="border px-4 py-2">{{ $cliente->razon_social }}</td>
                  <td class="border px-4 py-2">{{ $cliente->email }}</td>
                  <td class="border px-4 py-2">
                      <a href="{{ route('clientes.edit', $cliente) }}" class="text-blue-500 mr-2">Editar</a>
                      <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="inline-block">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="text-red-500" onclick="return confirm('¿Eliminar este cliente?')">
                            Eliminar
                          </button>
                      </form>
                  </td>
              </tr>
            @empty
              <tr>
                  <td colspan="5" class="border px-4 py-2 text-center">No hay clientes registrados</td>
              </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
