@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold">Órdenes Técnicas</h2>
        @role('admin')
          <a href="{{ route('ordenes.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Nueva Orden</a>
        @endrole
    </div>

    @if(session('success'))
      <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
        {{ session('success') }}
      </div>
    @endif

    <table class="min-w-full bg-white">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Cliente</th>
                <th class="px-4 py-2">Planta</th>
                <th class="px-4 py-2">Técnico</th>
                <th class="px-4 py-2">Estado</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ordenes as $orden)
              <tr>
                <td class="border px-4 py-2">{{ $orden->id }}</td>
                <td class="border px-4 py-2">{{ $orden->cliente->nombre }}</td>
                <td class="border px-4 py-2">{{ $orden->planta->nombre }}</td>
                <td class="border px-4 py-2">
                  {{ $orden->tecnico ? $orden->tecnico->name : 'Sin asignar' }}
                </td>
                <td class="border px-4 py-2 capitalize">{{ $orden->estado }}</td>
                <td class="border px-4 py-2">
                  @role('admin|supervisor')
                    <a href="{{ route('ordenes.show', $orden) }}" class="text-blue-500 mr-2">Ver</a>
                  @endrole

                  @role('tecnico')
                    @if($orden->tecnico_id === auth()->id() && $orden->estado === 'pendiente')
                      <a href="{{ route('ordenes.edit', $orden) }}" class="text-green-500">Editar</a>
                    @endif
                  @endrole
                </td>
              </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
