{{-- resources/views/clientes/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Detalles del Cliente</h1>

    <div class="card p-4 shadow rounded border border-gray-300">
        <p><strong>ID:</strong> {{ $cliente->id_cliente }}</p>
        <p><strong>Nombre:</strong> {{ $cliente->nombre }}</p>
        <p><strong>RUC:</strong> {{ $cliente->ruc }}</p>
        <p><strong>Correo:</strong> {{ $cliente->correo }}</p>
        <p><strong>Teléfono:</strong> {{ $cliente->telefono }}</p>
    </div>

    <a href="{{ route('clientes.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">
        &larr; Volver a la lista de clientes
    </a>
</div>
@endsection
