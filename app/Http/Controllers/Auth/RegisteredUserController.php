<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;   // <--- Nuestro FormRequest
use App\Models\User;
use App\Models\Tecnico;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Mostrar el formulario de registro.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Procesar el formulario de registro.
     */
    public function store(RegisterRequest $request)
    {
        // 1) Creamos el usuario en 'users'
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 2) Asignamos el rol al usuario (usando Spatie/Permission)
        $user->assignRole($request->role);

        // 3) Si el rol es 'tecnico', guardamos la fila en 'tecnicos'
        if ($request->role === 'tecnico') {
            Tecnico::create([
                'nombre'       => $request->nombre_tecnico,
                'cedula'       => $request->cedula,
                'especialidad' => $request->especialidad,
            ]);
        }

        // 4) Disparamos evento Registered para que Laravel (ej. email de verificación) lo maneje
        event(new Registered($user));

        // 5) Logueamos automáticamente al usuario recién creado
        Auth::login($user);

        // 6) Redirigimos al dashboard (o ruta que prefieras)
        return redirect()->route('dashboard');
    }
}
