@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h1 class="mb-4">Historial de Órdenes Técnicas</h1>

  {{-- Formulario de filtros --}}
  <form action="{{ route('ordenes.historial') }}" method="GET" class="row g-3 mb-3">
    <div class="col-md-4">
      <label for="cliente_id" class="form-label">Filtrar por Cliente</label>
      <select name="cliente_id" id="cliente_id" class="form-select">
        <option value="">-- Todos --</option>
        @foreach($clientes as $cli)
          <option value="{{ $cli->id_cliente }}" {{ request('cliente_id') == $cli->id_cliente ? 'selected' : '' }}>
            {{ $cli->nombre }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="col-md-4">
      <label for="tecnico_id" class="form-label">Filtrar por Técnico</label>
      <select name="tecnico_id" id="tecnico_id" class="form-select">
        <option value="">-- Todos --</option>
        @foreach($tecnicos as $tec)
          <option value="{{ $tec->id_tecnico }}" {{ request('tecnico_id') == $tec->id_tecnico ? 'selected' : '' }}>
            {{ $tec->nombre }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="col-md-4 align-self-end">
      <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
    </div>
  </form>

  {{-- Incluir la tabla parcial --}}
  @include('ordenes.partials.tabla_ordenes', ['ordenes' => $ordenes])

  <div class="mt-3">
    {{ $ordenes->appends(request()->query())->links() }}
  </div>
</div>
@endsection
