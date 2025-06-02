{{-- tabla_ordenes.blade.php --}}
<table class="table table-striped">
  <thead class="table-success">
    <tr>
      <th>ID</th>
      <th>Cliente</th>
      <th>Planta</th>
      <th>Técnico</th>
      <th>Estado</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($ordenes as $orden)
      <tr>
        <td>{{ $orden->id_orden }}</td>
        <td>{{ $orden->planta->cliente->nombre ?? '— sin cliente —' }}</td>
        <td>{{ $orden->planta->nombre ?? '— sin planta —' }}</td>
        <td>{{ $orden->tecnico->nombre ?? 'Sin asignar' }}</td>
        <td>
          <span class="badge 
            @if($orden->estado == 'Pendiente') bg-warning
            @elseif($orden->estado == 'En Proceso') bg-info
            @elseif($orden->estado == 'Validada') bg-success
            @elseif($orden->estado == 'Rechazada') bg-danger
            @else bg-secondary @endif">
            {{ $orden->estado }}
          </span>
        </td>
        <td>
          <a href="{{ route('ordenes.show', $orden->id_orden) }}" class="btn btn-primary btn-sm">Ver</a>
          @can('update', $orden)
            <a href="{{ route('ordenes.edit', $orden->id_orden) }}" class="btn btn-warning btn-sm">Editar</a>
          @endcan
          @can('validar', $orden)
            @if(in_array($orden->estado, ['Pendiente','En Proceso']))
              <a href="{{ route('ordenes.validarForm', $orden->id_orden) }}" class="btn btn-success btn-sm">Validar</a>
            @endif
          @endcan
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="6" class="text-center">No hay órdenes en este criterio.</td>
      </tr>
    @endforelse
  </tbody>
</table>
