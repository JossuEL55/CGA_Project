<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required','string','max:100'],
            // Si no usas razon_social ni direccion, retíralos:
            // 'razon_social' => ['nullable','string','max:255'],
            // 'direccion'    => ['nullable','string','max:500'],
            'telefono' => ['nullable','string','max:20'],
            'correo'   => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('clientes','correo')
                    ->ignore($this->cliente?->id_cliente, 'id_cliente'),
            ],
            'ruc' => [
                'required',
                'string',
                'max:13',
                Rule::unique('clientes','ruc')
                    ->ignore($this->cliente?->id_cliente, 'id_cliente'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'    => 'El campo "Nombre" es obligatorio.',
            'nombre.max'         => 'El nombre no puede exceder 255 caracteres.',
            'telefono.max'       => 'El teléfono no puede exceder 30 caracteres.',
            'correo.email'       => 'Debes ingresar una dirección de correo válida.',
            'correo.unique'      => 'Ya existe otro cliente con ese mismo correo.',
            'ruc.required'       => 'El RUC es obligatorio.',
            'ruc.unique'         => 'Ya existe otro cliente con ese RUC.',
        ];
    }
}
