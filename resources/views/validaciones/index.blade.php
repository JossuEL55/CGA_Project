@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-4xl">
  <h1 class="text-2xl font-bold mb-4">Historial de Validaciones</h1>

  <table class="min-w-full bg-white rounded shadow">
    <thead class="bg-gray-100">
      <tr>
        <th class="px-4 py-2">ID</th>
        <th class="px-4 py-2">Orden Técnica</th>
        <th class="px-4 py-2">Supervisor</th>
        <th class="px-4 py-2">Estado</th>
        <th class="px-4 py-2">Comentarios</th>
        <th class="px-4 py-2">Fecha</th>
        <th class="px-4 py-2">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($validaciones as $validacion)
      <tr>
        <td class="border px-4 py-2">{{ $validacion->id_validacion }}</td>
        <td class="border px-4 py-2">{{ $validacion->orden->id_orden }}</td>
        <td class="border px-4 py-2">{{ $validacion->supervisor->nombre ?? 'N/A' }}</td>
        <td class="border px-4 py-2">{{ $validacion->estado_validacion }}</td>
        <td class="border px-4 py-2">{{ Str::limit($validacion->comentarios, 50) }}</td>
        <td class="border px-4 py-2">{{ $validacion->created_at->format('d/m/Y H:i') }}</td>
        <td class="border px-4 py-2">
          <a href="{{ route('validaciones.show', $validacion) }}" class="text-blue-600 hover:underline">Ver</a>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" class="text-center p-4">No hay validaciones registradas.</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <div class="mt-4">
    {{ $validaciones->links() }}
  </div>
</div>
@endsection
