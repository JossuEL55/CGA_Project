@extends('layouts.app')

@section('content')
<div class="container p-4">
  <h1>Clientes</h1>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>RUC</th>
        <th>Correo</th>
        <th>Teléfono</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($clientes as $cliente)
      <tr>
        <td>{{ $cliente->id_cliente }}</td>
        <td>{{ $cliente->nombre }}</td>
        <td>{{ $cliente->ruc }}</td>
        <td>{{ $cliente->correo }}</td>
        <td>{{ $cliente->telefono }}</td>
        <td>
          <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-info btn-sm">Ver</a>
          <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning btn-sm">Editar</a>
          <!-- Aquí iría un formulario para eliminar si quieres -->
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div>
    {{ $clientes->links() }}
  </div>
</div>
@endsection
