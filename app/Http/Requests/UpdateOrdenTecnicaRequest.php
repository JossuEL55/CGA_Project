<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrdenTecnicaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Solo usuarios autenticados pueden actualizar órdenes
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string,mixed>
     */
    public function rules(): array
    {
        return [
            'descripcion'    => ['required','string'],
            'fecha_servicio' => ['required','date'],
            'estado'         => ['required','string','max:50'],
            'id_cliente'     => ['required','exists:clientes,id_cliente'],
            'id_planta'      => ['required','exists:plantas,id_planta'],
            'id_tecnico'     => ['required','exists:tecnicos,id_tecnico'],
        ];
    }
}
