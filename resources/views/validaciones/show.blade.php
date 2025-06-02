@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-lg">
  <h1 class="text-2xl font-bold mb-4">Detalle Validación #{{ $validacion->id_validacion }}</h1>

  <p><strong>Orden Técnica:</strong> {{ $validacion->orden->id_orden }}</p>
  <p><strong>Supervisor:</strong> {{ $validacion->supervisor->nombre ?? 'N/A' }}</p>
  <p><strong>Estado:</strong> {{ $validacion->estado_validacion }}</p>
  <p><strong>Comentarios:</strong></p>
  <p class="border rounded p-2">{{ $validacion->comentarios ?? 'Sin comentarios' }}</p>
  <p><strong>Fecha:</strong> {{ $validacion->created_at->format('d/m/Y H:i') }}</p>

  <a href="{{ route('validaciones.index') }}" class="inline-block mt-4 text-blue-600 hover:underline">Volver al listado</a>
</div>
@endsection
