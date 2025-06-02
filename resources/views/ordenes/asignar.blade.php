@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Asignar Técnico a la Orden #{{ $ordenTecnica->id_orden }}</h1>

        <form method="POST" action="{{ route('ordenes.asignar', $ordenTecnica->id_orden) }}">
            @csrf

            <div class="mb-3">
                <label for="id_tecnico" class="form-label">Selecciona un técnico:</label>
                <select name="id_tecnico" id="id_tecnico" class="form-control" required>
                    <option value="">-- Selecciona --</option>
                    @foreach($tecnicos as $tecnico)
                        <option value="{{ $tecnico->id_tecnico }}" {{ $ordenTecnica->id_tecnico == $tecnico->id_tecnico ? 'selected' : '' }}>
                            {{ $tecnico->name }}
                        </option>
                    @endforeach
                </select>
                @error('id_tecnico')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Asignar Técnico</button>
            <a href="{{ route('ordenes.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">¡Éxito!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    {{ session('success') }}
                </div>
                <div class="modal-footer">
                    <!-- Botón para ir al dashboard -->
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Ir al Dashboard</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            @endif
                    });
    </script>
@endsection