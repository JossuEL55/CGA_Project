<!-- resources/views/clientes/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-semibold mb-4">Nuevo Cliente</h2>

    @if($errors->any())
        <div class="text-red-600 mb-4">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('clientes.store') }}" method="POST">
        @csrf
        <input name="nombre" placeholder="Nombre Completo" class="w-full mb-2 p-2 border rounded">
        <input name="ruc" placeholder="RUC (13 dígitos)" class="w-full mb-2 p-2 border rounded">
        <input name="telefono" placeholder="+593 XX XXX XXXX" class="w-full mb-2 p-2 border rounded">
        <input name="correo" placeholder="correo@empresa.com" class="w-full mb-2 p-2 border rounded">

        <button class="bg-green-600 text-white p-2 rounded">Guardar Cliente</button>
    </form>
</div>
@endsection
