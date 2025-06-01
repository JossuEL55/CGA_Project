<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a hacer esta petición.
     * Por ahora devolvemos true para permitir que el controlador reciba
     * siempre el request validado. Más adelante puedes ajustar esto
     * (p. ej. permitiendo sólo a admins).
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para crear o actualizar un Cliente.
     * Ajusta los mensajes y longitudes máximas según tu esquema de BD.
     */
    public function rules(): array
    {
        return [
            // 'nombre' es obligatorio y máximo 255 caracteres
            'nombre'       => ['required', 'string', 'max:255'],

            // 'razon_social' opcional, máximo 255 caracteres
            'razon_social' => ['nullable', 'string', 'max:255'],

            // 'direccion' opcional, máximo 500 caracteres
            'direccion'    => ['nullable', 'string', 'max:500'],

            // 'telefono' opcional, máximo 30 caracteres
            'telefono'     => ['nullable', 'string', 'max:30'],

            // 'email' opcional, pero si se envía debe ser email válido y único en la tabla 'clientes'
            // Al actualizar, ignoramos el propio ID (para que no choque con sí mismo)
            'correo'        => [
                'nullable',
                'correo',
                'max:255',
                // Si tu columna en BD se llama 'email', Laravel asumirá que la tabla es 'clientes'.
                // En 'unique:clientes,email' verificamos que no exista otro cliente con ese email.
                // Para update: unique:clientes,email,{{ $this->cliente->id ?? 'NULL' }},id
                // (porque el route-model-binding inyecta $this->cliente cuando es una edición).
                // En otras palabras, si estamos en un update, ignoramos el registro actual.
                \Illuminate\Validation\Rule::unique('clientes', 'email')
                    ->ignore($this->cliente?->id, 'id'),
            ],
        ];
    }

    /**
     * (Opcional) Puedes personalizar los mensajes de error.
     */
    public function messages(): array
    {
        return [
            'nombre.required'       => 'El campo "Nombre" es obligatorio.',
            'nombre.max'            => 'El nombre no puede exceder 255 caracteres.',
            'razon_social.max'      => 'La razón social no puede exceder 255 caracteres.',
            'direccion.max'         => 'La dirección no puede exceder 500 caracteres.',
            'telefono.max'          => 'El teléfono no puede exceder 30 caracteres.',
            'correo.correo'           => 'Debes ingresar una dirección de correo válida.',
            'correo.unique'          => 'Ya existe otro cliente con ese mismo correo.',
        ];
    }
}
