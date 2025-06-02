<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrdenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        if ($this->isMethod('post')) {
            return [
                'descripcion'    => 'required|string',
                'fecha_servicio' => 'required|date',
                'id_planta'      => ['required', Rule::exists('plantas', 'id_planta')],
                'id_tecnico'     => ['nullable', Rule::exists('tecnicos', 'id_tecnico')],
            
            ];
        }

        return [];
    }
}