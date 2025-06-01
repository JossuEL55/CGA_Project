@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-semibold mb-4">Detalle de Orden #{{ $ordenTecnica->id }}</h2>

    <div class="mb-4">
        <p><strong>Cliente:</strong> {{ $ordenTecnica->cliente->nombre }}</p>
        <p><strong>Planta:</strong> {{ $ordenTecnica->planta->nombre }}</p>
        <p><strong>Técnico:</strong> {{ $ordenTecnica->tecnico ? $ordenTecnica->tecnico->name : 'Sin asignar' }}</p>
        <p><strong>Observaciones:</strong> {{ $ordenTecnica->observaciones ?? '—' }}</p>
        <p><strong>Estado:</strong> <span class="capitalize">{{ $ordenTecnica->estado }}</span></p>
    </div>

    @if($ordenTecnica->estado === 'pendiente')
      <form action="{{ route('ordenes.validar', $ordenTecnica) }}" method="POST">
        @csrf
        <div class="mb-4">
          <label class="block mb-1">Marcar como:</label>
          <select name="estado" class="w-full border p-2 rounded">
            <option value="aprobada">Aprobada</option>
            <option value="rechazada">Rechazada</option>
          </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Guardar Cambio</button>
      </form>
    @else
      <p class="mt-4">Orden revisada por Supervisor ID 
         {{ $ordenTecnica->supervisor_id }}.</p>
    @endif
</div>
@endsection
