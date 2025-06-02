@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-lg">
  <h1 class="text-2xl font-bold mb-4">Editar Orden Técnica</h1>

  @if($errors->any())
    <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
      <ul>
        @foreach ($errors->all() as $error)
          <li>- {{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('ordenes.update', $ordenTecnica) }}" method="POST" novalidate>
    @csrf
    @method('PUT')

    <label class="block mb-1 font-semibold" for="descripcion">Descripción *</label>
    <textarea id="descripcion" name="descripcion" class="border p-2 rounded w-full mb-4" required>{{ old('descripcion', $ordenTecnica->descripcion) }}</textarea>

    <label class="block mb-1 font-semibold" for="fecha_servicio">Fecha de Servicio *</label>
    <input type="date" id="fecha_servicio" name="fecha_servicio" value="{{ old('fecha_servicio', $ordenTecnica->fecha_servicio) }}" class="border p-2 rounded w-full mb-4" required>

    <label class="block mb-1 font-semibold" for="id_cliente">Cliente *</label>
    <select id="id_cliente" name="id_cliente" class="border p-2 rounded w-full mb-4" required>
      <option value="">Seleccione cliente</option>
      @foreach($clientes as $cliente)
      <option value="{{ $cliente->id_cliente }}" {{ old('id_cliente', $ordenTecnica->planta->id_cliente ?? '') == $cliente->id_cliente ? 'selected' : '' }}>{{ $cliente->nombre }}</option>
      @endforeach
    </select>

    <label class="block mb-1 font-semibold" for="id_planta">Planta *</label>
    <select id="id_planta" name="id_planta" class="border p-2 rounded w-full mb-4" required>
      <option value="">Seleccione planta</option>
      @foreach($plantas as $planta)
      <option value="{{ $planta->id_planta }}" {{ old('id_planta', $ordenTecnica->id_planta) == $planta->id_planta ? 'selected' : '' }}>{{ $planta->nombre }}</option>
      @endforeach
    </select>

    <label class="block mb-1 font-semibold" for="id_tecnico">Técnico *</label>
    <select id="id_tecnico" name="id_tecnico" class="border p-2 rounded w-full mb-4" required>
      <option value="">Seleccione técnico</option>
      @foreach($tecnicos as $tecnico)
      <option value="{{ $tecnico->id_tecnico }}" {{ old('id_tecnico', $ordenTecnica->id_tecnico) == $tecnico->id_tecnico ? 'selected' : '' }}>{{ $tecnico->nombre }}</option>
      @endforeach
    </select>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Actualizar</button>
    <a href="{{ route('ordenes.index') }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
  </form>

<script>
  const clienteSelect = document.getElementById('id_cliente');
  const plantaSelect = document.getElementById('id_planta');

  clienteSelect.addEventListener('change', () => {
    const clienteId = clienteSelect.value;
    plantaSelect.innerHTML = '<option value="">Cargando plantas...</option>';

    fetch(`/api/plantas?cliente_id=${clienteId}`)
      .then(response => response.json())
      .then(data => {
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
</div>
@endsection
