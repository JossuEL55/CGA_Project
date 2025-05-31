{{-- Mensaje de éxito --}}
@if(session('success'))
  <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
    {{ session('success') }}
  </div>
@endif

{{-- Errores de validación --}}
@if($errors->any())
  <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
    <ul class="list-disc pl-5">
      @foreach($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif
