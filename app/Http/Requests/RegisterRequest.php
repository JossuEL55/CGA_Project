<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Solo usuarios “no autenticados” pueden acceder a registrarse
        return auth()->guest();
    }

    public function rules(): array
    {
        return [
            // 1) Nombre de Usuario
            'name' => ['required', 'string', 'max:255'],

            // 2) Email
            'email' => ['required', 'string', 'email', 'max:255',
                        Rule::unique('users', 'email')],

            // 3) Contraseña
            'password' => ['required', 'string', 'min:6', 'confirmed'],

            // 5) Select de Rol
            'role' => ['required', 'string', Rule::in(['admin', 'tecnico', 'supervisor'])],

            // 6) Campos para “tecnico” (solo si role == tecnico)
            'nombre_tecnico'  => ['nullable', 'string', 'max:100'],
            'cedula'          => ['nullable', 'digits:10', 
                                  Rule::unique('tecnicos','cedula')],
            'especialidad'    => ['nullable', 'string', 'max:100'],
        ];
    }

    public function withValidator($validator)
    {
        // Aquí agregamos validación condicional: si role es “tecnico”, 
        // entonces los campos nombre_tecnico, cedula y especialidad son obligatorios.
        $validator->sometimes(
            ['nombre', 'cedula', 'especialidad'],
            ['required'], // reglas adicionales
            function ($input) {
                return $input->role === 'tecnico';
            }
        );
    }

    public function messages(): array
    {
        return [
            'name.required'            => 'El nombre de usuario es obligatorio.',
            'name.max'                 => 'El nombre no puede exceder 255 caracteres.',

            'email.required'           => 'El correo electrónico es obligatorio.',
            'email.email'              => 'Debe ingresar un email válido.',
            'email.unique'             => 'Ya existe una cuenta con ese correo.',

            'password.required'        => 'La contraseña es obligatoria.',
            'password.min'             => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed'       => 'La confirmación de la contraseña no coincide.',

            'role.required'            => 'Debes seleccionar un rol.',
            'role.in'                  => 'El rol seleccionado no es válido.',

            'nombre_tecnico.required'  => 'El nombre de técnico es obligatorio si eres técnico.',
            'nombre_tecnico.max'       => 'El nombre de técnico no puede exceder 100 caracteres.',

            'cedula.required'          => 'La cédula es obligatoria si eres técnico.',
            'cedula.digits'            => 'La cédula debe tener exactamente 10 dígitos.',
            'cedula.unique'            => 'Ya hay un técnico con esa cédula.',

            'especialidad.required'    => 'La especialidad es obligatoria si eres técnico.',
            'especialidad.max'         => 'La especialidad no puede exceder 100 caracteres.',
        ];
    }
}
