<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlantaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_cliente' => [
                'required',
                'integer',
                Rule::exists('clientes', 'id_cliente'),
            ],
            'nombre'    => ['required','string','max:255'],
            'ubicacion' => ['nullable','string','max:150'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_cliente.required' => 'Debes seleccionar un Cliente para la Planta.',
            'id_cliente.exists'   => 'El Cliente seleccionado no es válido.',
            'nombre.required'     => 'El nombre de la Planta es obligatorio.',
            'nombre.max'          => 'El nombre de la Planta no puede exceder 255 caracteres.',
            'ubicacion.max'       => 'La ubicación no puede exceder 500 caracteres.',
        ];
    }
}
