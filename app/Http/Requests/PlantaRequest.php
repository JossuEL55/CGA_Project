<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlantaRequest extends FormRequest
{
    /**
     * Autorizar la petición. Por ahora devolvemos true.
     * Más adelante podrías restringir sólo a admins.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para crear o actualizar una Planta.
     */
    public function rules(): array
    {
        return [
            // 'cliente_id' es obligatorio y debe existir en la tabla 'clientes'
            'cliente_id' => [
                'required',
                'integer',
                Rule::exists('clientes', 'id'),
            ],

            // 'nombre' de la planta es obligatorio, máximo 255 caracteres
            'nombre'     => ['required', 'string', 'max:255'],

            // 'ubicacion' opcional, máximo 500 caracteres
            'ubicacion'  => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Mensajes de error opcionales.
     */
    public function messages(): array
    {
        return [
            'cliente_id.required'   => 'Debes seleccionar un Cliente para la Planta.',
            'cliente_id.exists'     => 'El Cliente seleccionado no es válido.',
            'nombre.required'       => 'El nombre de la Planta es obligatorio.',
            'nombre.max'            => 'El nombre de la Planta no puede exceder 255 caracteres.',
            'ubicacion.max'         => 'La ubicación no puede exceder 500 caracteres.',
        ];
    }
}
