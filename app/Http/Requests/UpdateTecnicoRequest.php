<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTecnicoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'nombre'       => ['required','string','max:100'],
            'cedula'       => [
                'required',
                'digits:20',
                Rule::unique('tecnicos','cedula')->ignore($this->tecnico->id_tecnico, 'id_tecnico'),
            ],
            'especialidad' => ['required','string','max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'       => 'El nombre del técnico es obligatorio.',
            'nombre.max'            => 'El nombre no puede exceder 100 caracteres.',
            'cedula.required'       => 'La cédula es obligatoria.',
            'cedula.digits'         => 'La cédula debe tener 10 dígitos numéricos.',
            'cedula.unique'         => 'Ya existe otro técnico con esa cédula.',
            'especialidad.required' => 'La especialidad es obligatoria.',
            'especialidad.max'      => 'La especialidad no puede exceder 100 caracteres.',
        ];
    }
}
