@extends('layouts.app')

@section('content')
  <div class="container mx-auto p-4">
    <h2 class="text-2xl font-semibold mb-4">Nueva Orden Técnica</h2>

    @if($errors->any())
    <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
    <ul>
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
    </ul>
    </div>
    @endif

    <form action="{{ route('ordenes.store') }}" method="POST">
    @csrf

    <div class="mb-4">
      <label class="block mb-1">Cliente</label>
      <select name="cliente_id" id="cliente_id" class="w-full border p-2 rounded">
      <option value="">-- Seleccione Cliente --</option>
      @foreach($clientes as $c)
      <option value="{{ $c->id }}" {{ old('cliente_id') == $c->id ? 'selected' : '' }}>
      {{ $c->nombre }}
      </option>
    @endforeach
      </select>
    </div>

    <div class="mb-4">
      <label class="block mb-1">Planta</label>
      <select name="planta_id" id="planta_id" class="w-full border p-2 rounded">
      <option value="">-- Primero seleccione Cliente --</option>
      </select>
    </div>

    <div class="mb-4">
      <label class="block mb-1">Técnico (opcional)</label>
      <select name="tecnico_id" class="w-full border p-2 rounded">
      <option value="">-- Ninguno --</option>
      @foreach($tecnicos as $t)
      <option value="{{ $t->id }}" {{ old('tecnico_id') == $t->id ? 'selected' : '' }}>
      {{ $t->name }}
      </option>
    @endforeach
      </select>
    </div>

    <div class="mb-4">
      <label class="block mb-1">Observaciones</label>
      <textarea name="observaciones" rows="3" class="w-full border p-2 rounded">{{ old('observaciones') }}</textarea>
    </div>

    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">
      Crear Orden
    </button>
    </form>
  </div>
@endsection

@push('scripts')
  <!-- Script para cargar dinámicamente las plantas según cliente -->
  <script>
    document.getElementById('cliente_id').addEventListener('change', function () {
    const clienteId = this.value;
    const plantaSelect = document.getElementById('planta_id');
    plantaSelect.innerHTML = '<option>Cargando...</option>';

    fetch(`/api/plantas?cliente_id=${clienteId}`)
      .then(res => res.json())
      .then(data => {
      let options = '<option value="">-- Seleccione Planta --</option>';
      data.forEach(planta => {
        options += `<option value="${planta.id}">${planta.nombre}</option>`;
      });
      plantaSelect.innerHTML = options;
      });
    });
  </script>
@endpush