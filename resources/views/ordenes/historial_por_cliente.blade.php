@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h1 class="mb-4">Órdenes del Cliente: <span class="text-primary">{{ $cliente->nombre }}</span></h1>

  @include('ordenes.partials.tabla_ordenes', ['ordenes' => $ordenes])

  <div class="mt-3">
    {{ $ordenes->links() }}
  </div>
</div>
@endsection
