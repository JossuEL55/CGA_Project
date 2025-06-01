@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-semibold mb-4">Agregar Observaciones a Orden #{{ $ordenTecnica->id }}</h2>

    @if($errors->any())
      <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('ordenes.update', $ordenTecnica) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-4">
        <label class="block mb-1">Observaciones</label>
        <textarea name="observaciones" rows="4" class="w-full border p-2 rounded">{{ old('observaciones', $ordenTecnica->observaciones) }}</textarea>
      </div>

      <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">
        Guardar Observaciones
      </button>
    </form>
</div>
@endsection
