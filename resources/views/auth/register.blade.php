{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-header">{{ __('Registro de Usuario') }}</div>

        <div class="card-body">
          <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- 1) Nombre de Usuario --}}
            <div class="mb-3">
              <label for="name" class="form-label">{{ __('Nombre de Usuario') }}</label>
              <input id="name" type="text"
                     class="form-control @error('name') is-invalid @enderror"
                     name="name"
                     value="{{ old('name') }}"
                     required autofocus>
              @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            {{-- 2) Email --}}
            <div class="mb-3">
              <label for="email" class="form-label">{{ __('Email') }}</label>
              <input id="email" type="email"
                     class="form-control @error('email') is-invalid @enderror"
                     name="email"
                     value="{{ old('email') }}"
                     required>
              @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            {{-- 3) Contraseña --}}
            <div class="mb-3">
              <label for="password" class="form-label">{{ __('Contraseña') }}</label>
              <input id="password" type="password"
                     class="form-control @error('password') is-invalid @enderror"
                     name="password" required>
              @error('password')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            {{-- 4) Confirmar Contraseña --}}
            <div class="mb-3">
              <label for="password_confirmation" class="form-label">{{ __('Confirmar Contraseña') }}</label>
              <input id="password_confirmation" type="password"
                     class="form-control"
                     name="password_confirmation" required>
            </div>

            {{-- 5) Select de Rol --}}
            <div class="mb-3">
              <label for="role" class="form-label">{{ __('Selecciona un rol') }}</label>
              <select id="role" name="role"
                      class="form-select @error('role') is-invalid @enderror"
                      required>
                <option value="">-- Elige un rol --</option>
                <option value="admin"     {{ old('role')=='admin'      ? 'selected' : '' }}>Admin</option>
                <option value="tecnico"   {{ old('role')=='tecnico'    ? 'selected' : '' }}>Técnico</option>
                <option value="supervisor"{{ old('role')=='supervisor' ? 'selected' : '' }}>Supervisor</option>
              </select>
              @error('role')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <hr>

            {{-- 6) Campos específicos de Técnico --}}
            <div class="mb-3">
              <label for="nombre_tecnico" class="form-label">{{ __('Nombre de Técnico') }}</label>
              <input id="nombre_tecnico" type="text"
                     class="form-control @error('nombre_tecnico') is-invalid @enderror"
                     name="nombre_tecnico"
                     value="{{ old('nombre_tecnico') }}">
              @error('nombre_tecnico')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-3">
              <label for="cedula" class="form-label">{{ __('Cédula') }}</label>
              <input id="cedula" type="text"
                     class="form-control @error('cedula') is-invalid @enderror"
                     name="cedula"
                     value="{{ old('cedula') }}">
              @error('cedula')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-3">
              <label for="especialidad" class="form-label">{{ __('Especialidad') }}</label>
              <input id="especialidad" type="text"
                     class="form-control @error('especialidad') is-invalid @enderror"
                     name="especialidad"
                     value="{{ old('especialidad') }}">
              @error('especialidad')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            {{-- 7) Botón Registrar --}}
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">
                {{ __('Registrar') }}
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
