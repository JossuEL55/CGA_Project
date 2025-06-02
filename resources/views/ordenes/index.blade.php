{{-- resources/views/ordenes/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Órdenes Técnicas</h1>

    {{-- Botón “Nueva Orden” si el usuario tiene permiso --}}
    @can('create', App\Models\OrdenTecnica::class)
        <a href="{{ route('ordenes.create') }}" class="btn btn-success mb-3">
            Nueva Orden
        </a>
    @endcan

    {{-- Buscador básico --}}
    <input type="text" id="buscador" class="form-control mb-3" placeholder="Buscar órdenes...">

    <table class="table table-striped table-bordered">
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
        <tbody id="tabla-ordenes">
            @forelse ($ordenes as $orden)
                <tr>
                    <td>{{ $orden->id_orden }}</td>
                    <td>{{ optional($orden->planta->cliente)->nombre ?? '— sin cliente —' }}</td>
                    <td>{{ optional($orden->planta)->nombre ?? '— sin planta —' }}</td>
                    <td>{{ optional($orden->tecnico)->nombre ?? 'Sin asignar' }}</td>
                    <td>
                        <span class="badge
                            @if($orden->estado === 'Pendiente') bg-warning
                            @elseif($orden->estado === 'En Proceso') bg-info
                            @elseif($orden->estado === 'Validada') bg-success
                            @elseif($orden->estado === 'Rechazada') bg-danger
                            @else bg-secondary
                            @endif
                        ">
                            {{ $orden->estado }}
                        </span>
                    </td>
                    <td>
                        {{-- Ver --}}
                        <a href="{{ route('ordenes.show', $orden->id_orden) }}" class="btn btn-primary btn-sm">
                            Ver
                        </a>

                        {{-- Editar (si tiene permiso) --}}
                        @can('update', $orden)
                            <a href="{{ route('ordenes.edit', $orden->id_orden) }}" class="btn btn-warning btn-sm">
                                Editar
                            </a>
                        @endcan

                        {{-- Validar (para supervisores en estado Pendiente/En Proceso) --}}
                        @can('validar', $orden)
                            @if(in_array($orden->estado, ['Pendiente', 'En Proceso']))
                                <a href="{{ route('ordenes.validarForm', $orden->id_orden) }}" class="btn btn-success btn-sm">
                                    Validar
                                </a>
                            @endif
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No hay órdenes registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Paginación --}}
    <div class="mt-3">
        {{ $ordenes->links() }}
    </div>
</div>

{{-- Script para el filtro de filas --}}
<script>
    document.getElementById('buscador').addEventListener('input', function() {
        const filtro = this.value.toLowerCase();
        document.querySelectorAll('#tabla-ordenes tr').forEach(tr => {
            tr.style.display = tr.textContent.toLowerCase().includes(filtro) ? '' : 'none';
        });
    });
</script>
@endsection
