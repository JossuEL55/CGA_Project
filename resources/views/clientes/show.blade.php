@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalle del Cliente: {{ $cliente->nombre }}</h1>

    <p><strong>RUC:</strong> {{ $cliente->ruc }}</p>
    <p><strong>Correo:</strong> {{ $cliente->correo }}</p>
    <p><strong>Teléfono:</strong> {{ $cliente->telefono }}</p>

    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
