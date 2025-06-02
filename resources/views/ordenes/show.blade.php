@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-3xl">
  <h1 class="text-2xl font-bold mb-4">Orden Técnica #{{ $ordenTecnica->id_orden }}</h1>

  <div class="mb-4">
    <strong>Descripción:</strong> {{ $ordenTecnica->descripcion }}
  </div>
  <div class="mb-4">
    <strong>Fecha Servicio:</strong> {{ $ordenTecnica->fecha_servicio }}
  </div>
  <div class="mb-4">
    <strong>Estado:</strong> {{ $ordenTecnica->estado }}
  </div>
  <div class="mb-4">
    <strong>Planta:</strong> {{ $ordenTecnica->planta->nombre ?? '' }}
  </div>
  <div class="mb-4">
    <strong>Técnico:</strong> {{ $ordenTecnica->tecnico->nombre ?? '' }}
  </div>

  <h2 class="text-xl font-semibold mt-6 mb-2">Historial de Validaciones</h2>
  @forelse($ordenTecnica->validaciones as $validacion)
    <div class="border p-2 mb-2 rounded">
      <p><strong>Estado:</strong> {{ $validacion->estado_validacion }}</p>
      <p><strong>Supervisor:</strong> {{ $validacion->supervisor->nombre ?? 'N/A' }}</p>
      <p><strong>Comentarios:</strong> {{ $validacion->comentarios ?? 'Sin comentarios' }}</p>
      <p><strong>Fecha:</strong> {{ $validacion->created_at->format('d/m/Y H:i') }}</p>
    </div>
  @empty
    <p>No hay validaciones registradas.</p>
  @endforelse

  <a href="{{ route('ordenes.index') }}" class="inline-block mt-4 text-blue-600 hover:underline">Volver al listado</a>
</div>
@endsection
