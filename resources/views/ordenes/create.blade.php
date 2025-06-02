@extends('layouts.app')

@section('content')
<<<<<<< HEAD
<div class="container mx-auto p-4 max-w-lg">
  <h1 class="text-2xl font-bold mb-4">Crear Orden Técnica</h1>

  @if($errors->any())
    <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
      <ul>
        @foreach ($errors->all() as $error)
          <li>- {{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('ordenes.store') }}" method="POST" novalidate>
    @csrf

    <label class="block mb-1 font-semibold" for="descripcion">Descripción *</label>
    <textarea id="descripcion" name="descripcion" class="border p-2 rounded w-full mb-4" required>{{ old('descripcion') }}</textarea>

    <label class="block mb-1 font-semibold" for="fecha_servicio">Fecha de Servicio *</label>
    <input type="date" id="fecha_servicio" name="fecha_servicio" value="{{ old('fecha_servicio') }}" class="border p-2 rounded w-full mb-4" required>

    <label class="block mb-1 font-semibold" for="id_cliente">Cliente *</label>
    <select id="id_cliente" name="id_cliente" class="border p-2 rounded w-full mb-4" required>
      <option value="">Seleccione cliente</option>
      @foreach($clientes as $cliente)
      <option value="{{ $cliente->id_cliente }}" {{ old('id_cliente') == $cliente->id_cliente ? 'selected' : '' }}>{{ $cliente->nombre }}</option>
      @endforeach
    </select>

    <label class="block mb-1 font-semibold" for="id_planta">Planta *</label>
    <select id="id_planta" name="id_planta" class="border p-2 rounded w-full mb-4" required>
      <option value="">Seleccione planta</option>
      {{-- Las plantas se cargarán dinámicamente --}}
    </select>

    <label class="block mb-1 font-semibold" for="id_tecnico">Técnico *</label>
    <select id="id_tecnico" name="id_tecnico" class="border p-2 rounded w-full mb-4" required>
      <option value="">Seleccione técnico</option>
      @foreach($tecnicos as $tecnico)
      <option value="{{ $tecnico->id_tecnico }}" {{ old('id_tecnico') == $tecnico->id_tecnico ? 'selected' : '' }}>{{ $tecnico->nombre }}</option>
      @endforeach
    </select>

    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Guardar</button>
    <a href="{{ route('ordenes.index') }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
  </form>
</div>

<script>
  const clienteSelect = document.getElementById('id_cliente');
  const plantaSelect = document.getElementById('id_planta');

  clienteSelect.addEventListener('change', () => {
    const clienteId = clienteSelect.value;
    plantaSelect.innerHTML = '<option value="">Cargando plantas...</option>';
=======
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
>>>>>>> origin/develop2

    fetch(`/api/plantas?cliente_id=${clienteId}`)
      .then(response => response.json())
      .then(data => {
<<<<<<< HEAD
        let options = '<option value="">Seleccione planta</option>';
        data.forEach(planta => {
          options += `<option value="${planta.id}">${planta.nombre}</option>`;
        });
        plantaSelect.innerHTML = options;
      })
      .catch(() => {
        plantaSelect.innerHTML = '<option value="">Error al cargar plantas</option>';
      });
  });
</script>
@endsection
=======
      let options = '<option value="">-- Seleccione Planta --</option>';
      data.forEach(planta => {
        options += `<option value="${planta.id}">${planta.nombre}</option>`;
      });
      plantaSelect.innerHTML = options;
      });
    });
  </script>
@endpush
>>>>>>> origin/develop2
