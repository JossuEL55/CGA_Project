<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'cedula'       => ['required','digits:10'],
            'especialidad' => ['required','string','max:100'],
        ];
    }
}
